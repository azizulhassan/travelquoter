<?php

namespace App\Livewire\Visa;

use App\Models\Bookmark;
use App\Models\Country;
use App\Models\State;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Step2Filter extends Component implements HasForms
{
    use InteractsWithForms;

    public $search;
    public $location;
    public $category;
    public $agents_array = [];
    public $agents = [];
    public $country;
    public $australia_id;

    public function mount()
    {
        $this->australia_id = Country::where('name', 'Australia')->first()->id;

        $db_states = State::has('agencies')->with(['agencies', 'country'])->where('status', true)->get();

        if (count($db_states)) {
            $this->agents_array = $db_states->map(function ($item) {
                return [
                    'location' => $item->name . ', ' . $item->country->name,
                    'agents' => $item->agencies->toArray()
                ];
            });
        }

        if (session()->has('step-2-visa')) {
            $this->form->fill([
                'location' => 'All',
                'category' => 'All',
                'agents' => session()->get('step-2-visa')
            ]);
        } else {
            $this->form->fill([
                'location' => 'All',
                'category' => 'All',
            ]);
        }
    }

    public function updated()
    {
        $query = State::has('agencies')->with(['agencies', 'country'])->where('status', true);

        $query = $query->where(function ($query) {
            if ($this->search) {
                $search = $this->search;
                $query->whereHas('country', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->orWhere('name', 'like', '%' . $search . '%');
            }

            if ($this->location) {
                $countryArray = Country::pluck('id');
                if ($this->location == "All") {
                    $query = $query->whereIn('country_id', $countryArray);
                } elseif ($this->location == "International") {
                    $query = $query->where('country_id', '!=', $this->australia_id)->whereIn('country_id', $countryArray);
                } else {
                    $query = $query->where('country_id', $this->australia_id);
                }
            }

            if ($this->country) {
                $query->where('country_id', $this->country);
            }

            if ($this->category) {
                if ($this->category == 'Recent') {
                    $query = $query->orderBy('created_at', 'DESC');
                } elseif ($this->category == 'Top') {
                    $query = $query->orderBy('created_at', 'ASC');
                } elseif ($this->category == 'Random') {
                    $query = $query->orderBy('created_at', 'DESC');
                } else {
                    if ($this->category == 'Bookmarked') {
                        if (Auth::guard('client')->check()) {
                            $bookmarks = Bookmark::where('client_id', Auth::guard('client')->user()->id)->pluck('agent_id');
                            $query = $query->whereHas('agencies', function ($query) use ($bookmarks) {
                                return $query->whereIn('agent_id', $bookmarks);
                            });
                        } else {
                            Notification::make()->title(__('You need to login first'))->success()->send();
                        }
                    }
                }
            }
        });

        $query = $query->get();

        $this->agents_array = $query->map(function ($item) {
            return [
                'location' => $item->name . ', ' . $item->country->name,
                'agents' => $item->agencies->toArray()
            ];
        });
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 1,
                'sm' => 1,
                'md' => 2,
                'lg' => 3,
            ])->schema([
                Forms\Components\Grid::make()->schema([
                    Forms\Components\TextInput::make('search')->live()->label('')->placeholder(__('Search by state and country'))->prefixIcon('heroicon-o-magnifying-glass')->columnSpanFull(),

                    Forms\Components\Grid::make()->schema($this->grabAgents()),
                ])->columnSpan([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 2,
                ]),
                Forms\Components\Section::make(__('Filter'))->schema([
                    Forms\Components\Radio::make('location')->live()->label(__('Location'))->options([
                        'All' => __('All'),
                        $this->australia_id => __('Australia'),
                        'International' => __('International')
                    ]),
                    Forms\Components\Select::make('country')->live()->label('')->options(Country::where('status', true)->pluck('name', 'id'))->searchable()->preload()->placeholder(__('Choose')),
                    Forms\Components\Radio::make('category')->live()->label(__('Category'))->options([
                        'All' => __('All'),
                        'Top' => __('Top'),
                        'Recent' => __('Recent'),
                        'Random' => __('Random'),
                        'Bookmarked' => __('Bookmarked'),
                    ]),
                ])->columnSpan([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 1,
                ])->collapsible()->extraAttributes(['class' => 'section-sm sticky top-1'])
            ]),
        ]);
    }

    public function grabAgents(): array
    {
        $array = [];

        if (count($this->agents_array) > 0) {
            foreach ($this->agents_array as $key => $item) {
                array_push(
                    $array,
                    Forms\Components\Section::make(__($item['location']))->schema([
                        Forms\Components\CheckboxList::make('agents')->live()->label('')->options(function () use ($item) {
                            $array = collect($item['agents'])->mapWithKeys(function ($item, $key) {
                                return [
                                    $item['agent_id'] => $item['agency_name']
                                ];
                            })->toArray();
                            return $array;
                        })
                    ])->collapsible()->extraAttributes(['class' => 'section-sm'])
                );
            }
        }

        return $array;
    }

    public function submit()
    {
        $this->validate([
            'agents' => 'required|array',
            'agents.*' => 'required|int',
        ]);

        session(['step-2-visa' => $this->agents]);

        Notification::make()->title('Submit your details.')->info()->send();

        return $this->redirect(route('visa.step-3'), false);
    }

    public function render()
    {
        return view('livewire.visa.step2-filter');
    }
}
