<?php

namespace App\Livewire\Insurance;

use App\Forms\Components\AddTravellers;
use App\Models\Country;
use App\Models\PassportType;
use App\Models\VisitPurpose;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Livewire\Attributes\Url;

class Step1Form extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    #[Url(except: '', keep: true)]
    public $country = '';

    #[Url(except: '', keep: true)]
    public $departure_date = '';

    #[Url(except: '', keep: true)]
    public $arrival_date = '';

    #[Url(except: '', keep: true)]
    public $no_of_travelers = '';

    // #[Url(except: '', keep: true)]
    // public $age_of_travelers = '';
    

    public function mount()
    {
        if (session()->has('step-1-insurance')) {
            $this->form->fill(session()->get('step-1-insurance'));
        }
    }

    public function resetForm()
    {
        session()->forget('step-1-insurance');
        session()->forget('no_of_travelers');

        $this->country = '';
        $this->departure_date = '';
        $this->arrival_date = '';
        $this->no_of_travelers = '';
        // $this->age_of_travelers = '';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 3,
            ])->schema([
                Forms\Components\Select::make('country')->label(__('Country'))->options(Country::where('status', true)->orderBy('name', 'ASC')->pluck('name', 'name'))->placeholder('Country')->searchable()->preload()->required(),
                Forms\Components\DatePicker::make('departure_date')->label(__('Departure date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\DatePicker::make('arrival_date')->label(__('Arrival date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->minDate(now())->closeOnDateSelection(),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 2,
            ])->schema([
                AddTravellers::make('no_of_travelers')->label(__('No of travelers'))->required()->default(session('insurance-travlers')),
                // Forms\Components\TextInput::make('age_of_travelers')->label(__('Age of travelers'))->numeric()->required()->suffix('years'),
            ])
        ]);
    }

    // public function shareAction(): Action {
    //     return Action::make('share')->label(__('share'))->outlined()->icon('heroicon-m-share')
    //         ->action(function () {
    //             Notification::make()->title('Link Copied')->success()->send();
    //         });
    // }

    public function share()
    {
        Notification::make()->title('Link copied successfully.')->info()->send();

        $this->js(<<<JS
            navigator.clipboard.writeText(window.location.href);
        JS);
    }

    public function next()
    {
        if(session()->has('no_of_travelers')) {
            $this->no_of_travelers = session()->get('no_of_travelers');
        }

        session(['step-1-insurance' => $this->form->getState()]);
        Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
        return $this->redirect(route('insurance.step-2'), false);
    }

    public function render()
    {
        return view('livewire.insurance.step1-form');
    }
}
