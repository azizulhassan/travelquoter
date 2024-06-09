<?php

namespace App\Livewire\Hotel;

use App\Forms\Components\Hotel\AccomodationType;
use App\Forms\Components\Hotel\AddTravelers;
use App\Forms\Components\Hotel\Rooms;
use App\Models\AccommodationType;
use App\Models\Amenity;
use App\Models\CarType;
use App\Models\State;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class Step1Form extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    #[Url(except:'', keep:true)]
    public $desired_city = '';

    #[Url(except:'', keep:true)]
    public $check_in = '';

    #[Url(except:'', keep:true)]
    public $check_out = '';

    #[Url(except:'', keep:true)]
    public $trip_days = '';

    #[Url(except:'', keep:true)]
    public $no_of_travelers = '';

    #[Url(except:'', keep:true)]
    public $accommodation_type = [];
    public $accommodation_type_string = '';

    #[Url(except:'', keep:true)]
    public $room = ['rooms' => [], 'bed_type' => []];

    #[Url(except:'', keep:true)]
    public $rating = '';

    public $other = [];

    public $totalTravelers = 0;
    public $room_with_type;

    #[On('update-accommodation-types')]
    public function updateAccommodationTypes() {
        if(session()->has('accommodation_types')) {
            $this->accommodation_type = session()->get('accommodation_types');
            $this->accommodation_type_string = implode(', ', $this->accommodation_type);
        }
    }

    public function googleSearch($search)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' . $search . '&key='. env('GOOGLE_MAPS_API_KEY'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);
        
        return $response;
    }

    #[On('travelers-added')]
    public function updateTravelers() {
        
        if(session()->has('no_of_travelers')) {
            $this->no_of_travelers = session()->get('no_of_travelers');
            $this->totalTravelers = $this->no_of_travelers['adults'] + $this->no_of_travelers['infants'] + $this->no_of_travelers['children'];
        }
    }

    #[On('rooms-added')]
    public function updateRooms() {
        if(session()->has('selected_room') && session()->has('selected_bedtype')) {
            $this->room = [
                'rooms' => session()->get('selected_room'),
                'bed_type' => session()->get('selected_bedtype')
            ];
            
            $this->room_with_type = session()->get('selected_room') . ' Bedroom, ' . session()->get('selected_bedtype');
        }
    }

    public function updateTotalTravlers() {
        $this->totalTravelers = $this->no_of_travelers['adults'] + $this->no_of_travelers['infants'] + $this->no_of_travelers['children'];
    }

    public function mount()
    {
        if (session()->has('step-1-hotel')) {
            $this->form->fill(session()->get('step-1-hotel'));
        }

        $this->dispatch('travelers-added');
        $this->dispatch('rooms-added');
        $this->dispatch('update-accommodation-types');
    }

    public function resetForm()
    {
        session()->forget(['step-1-hotel', 'no_of_travelers', 'accommodation_types', 'selected_room', 'selected_bedtype']);
        // $this->dispatch('$refresh');
        $this->desired_city = '';
        $this->check_in = '';
        $this->check_out = '';
        $this->trip_days = '';
        $this->no_of_travelers = '';
        $this->totalTravelers = 0;
        $this->accommodation_type = [];
        $this->accommodation_type_string = '';
        $this->room = '';
        $this->rating = '';
        $this->other = '';
        $this->room_with_type = '';
    }

    public function updated() {
        if ($this->check_in && $this->check_in != 'null' && $this->check_out && $this->check_out != 'null') {
            $check_in = Carbon::parse($this->check_in);
            $check_out = Carbon::parse($this->check_out);
            
            if ($check_out->gt($check_in)) {
                $trip_days = $check_out->diffInDays($check_in);
                $this->trip_days = $trip_days;
            }
            else {
                $this->check_out = '';
                Notification::make()->title('Check out date should be greater.')->danger()->send();
            }
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 2,
                'sm' => 3,
                'md' => 3,
                'lg' => 4
            ])->schema([
                Forms\Components\Select::make('desired_city')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {
                        
                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required(),
                Forms\Components\DatePicker::make('check_in')->live()->label(__('Check in'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\DatePicker::make('check_out')->live()->label(__('Check out'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\TextInput::make('trip_days')->label(__('Trip days'))->numeric()->minValue(1)->postfix(__('Days'))->required()->disabled()
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 2,
                'md' => 5,
            ])->schema([
                AddTravelers::make('no_of_travelers')->label(__('No of travelers'))->required(),
                AccomodationType::make('accommodation_type')->label(__('Accommodation type'))->required(),
                // Forms\Components\Select::make('room')->options([
                //     'One' => __('One'),
                //     'Two' => __('Two'),
                //     'Three' => __('Three'),
                //     'Four' => __('Four'),
                //     'Five' => __('Five')
                // ])->preload()->searchable()->placeholder(__('Choose'))->postfix(__('Bedroom'))->required(),
                Rooms::make('room')->required(),
                Forms\Components\Select::make('rating')->options([
                    '⭐⭐⭐⭐⭐ (5 Stars)' => '⭐⭐⭐⭐⭐ '.__('(5 Stars)'),
                    '⭐⭐⭐⭐ (4 Stars)' => '⭐⭐⭐⭐ '.__('(4 Stars)'),
                    '⭐⭐⭐ (3 Stars)' => '⭐⭐⭐ '.__('(3 Stars)'),
                    '⭐⭐ (2 Stars)' => '⭐⭐ '.__('(2 Stars)'),
                    '⭐ (1 Star)' => '⭐ '.__('(1 Star)'),
                    'Doesn\'t matter' => __('Doesn\'t matter'),
                ])->preload()->searchable()->placeholder(__('Choose'))->required(),
                Forms\Components\Select::make('other')->label(__('Other'))->options(Amenity::where('status', true)->pluck('name', 'slug'))->multiple()->placeholder(__('Choose'))->required(),
            ])
        ]);
    }

    public function share() {
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

        session(['step-1-hotel' => $this->form->getState()]);
        Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
        return $this->redirect(route('hotel.step-2'), false);
    }

    public function render()
    {
        return view('livewire.hotel.step1-form');
    }
}
