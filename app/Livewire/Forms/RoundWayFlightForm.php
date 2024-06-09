<?php

namespace App\Livewire\Forms;

use App\Models\AccommodationType;
use App\Models\Airline;
use App\Models\Amenity;
use App\Models\BedType;
use App\Models\CarType;
use App\Models\FlightClass;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Livewire\Attributes\Url;

class RoundWayFlightForm extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    #[Url(except: '', keep: true)]
    public $from = '';

    #[Url(except: '', keep: true)]
    public $to = '';

    #[Url(except: '', keep: true)]
    public $departure_date = '';

    #[Url(except: '', keep: true)]
    public $trip_days = '';

    #[Url(except: '', keep: true)]
    public $return_date = '';

    #[Url(except: '', keep: true)]
    public $no_of_passenger = '';

    #[Url(except: '', keep: true)]
    public $flight_type = '';

    #[Url(except: '', keep: true)]
    public $flight_class_id = '';

    #[Url(except: '', keep: true)]
    public $is_flexible_date = '';

    #[Url(except: '', keep: true)]
    public $is_visa = '';

    #[Url(except: '', keep: true)]
    public $airline = '';

    #[Url(except: '', keep: true)]
    public $is_insurance = '';
    

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


    public function share()
    {
        Notification::make()->title('Link copied successfully.')->info()->send();

        $this->js(<<<JS
            navigator.clipboard.writeText(window.location.href);
        JS);
    }

    public function mount()
    {
        if (session()->has('step-1-round-way-flight')) {
            $this->form->fill(session()->get('step-1-round-way-flight'));
        }
    }

    public function swap()
    {
        $temp = $this->from;
        $this->from = $this->to;
        $this->to = $temp;
    }

    public function resetForm()
    {
        session()->forget(['step-1-round-way-flight', 'roundway_options_hotels_primary', 'roundway_options_cars_primary', 'roundway_options_transfers_primary', 'roundway_options_activities_primary', 'step-1-one-way-flight', 'oneway_options_hotels_primary', 'oneway_options_cars_primary', 'oneway_options_transfers_primary', 'oneway_options_activities_primary']);

        $this->from = '';
        $this->to = '';
        $this->departure_date = '';
        $this->trip_days = '';
        $this->return_date = '';
        $this->no_of_passenger = '';
        $this->flight_type = '';
        $this->flight_class_id = '';
        $this->is_flexible_date = '';
        $this->is_visa = '';
        $this->airline = '';
        $this->is_insurance = '';
    }

    public function updated()
    {

        if ($this->departure_date && $this->departure_date != 'null' && $this->return_date && $this->return_date != 'null') {
            $departure_date = Carbon::parse($this->departure_date);
            $return_date = Carbon::parse($this->return_date);

            if ($return_date->gt($departure_date)) {
                $trip_days = $return_date->diffInDays($departure_date);
                $this->trip_days = $trip_days;
            } else {
                $this->return_date = '';
                Notification::make()->title('Check out date should be greater.')->danger()->send();
            }
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 2,
                'sm' => 2,
                'md' => 3,
                'lg' => 5
            ])->schema([
                Forms\Components\Select::make('from')->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {
                        
                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required(),

                Forms\Components\Select::make('to')->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {
                        
                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required(),

                Forms\Components\DatePicker::make('departure_date')->live()->label(__('Departure date'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\TextInput::make('trip_days')->live()->label(__('Trip days'))->numeric()->required()->helperText('Set Departure & Return date.')->disabled(),
                Forms\Components\DatePicker::make('return_date')->live()->label(__('Return date'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
            ]),
            Forms\Components\Grid::make([
                'default' => 2,
                'sm' => 2,
                'md' => 3,
                'lg' => 6,
            ])->schema([
                Forms\Components\TextInput::make('no_of_passenger')->label(__('Passengers'))->numeric()->required()->suffixIcon('heroicon-o-user-group'),
                Forms\Components\Select::make('flight_class_id')->label(__('Cabin class'))->options(FlightClass::where('status', true)->pluck('name', 'id'))->preload()->searchable()->placeholder(__('Choose'))->required(),
                Forms\Components\Select::make('is_visa')->label(__('Visa'))->options([
                    true => 'Yes',
                    false => 'No'
                ])->preload()->searchable()->placeholder(__('Choose'))->required(),
                Forms\Components\Select::make('is_flexible_date')->label(__('Flexible date'))->options([
                    true => 'Yes',
                    false => 'No'
                ])->preload()->searchable()->placeholder(__('Choose'))->required(),
                Forms\Components\Select::make('airline')->label(__('Airline'))->options(Airline::where('status', true)->pluck('name', 'name'))->preload()->searchable()->placeholder(__('Choose'))->required(),
                Forms\Components\Select::make('is_insurance')->label(__('Insurance'))->options([
                    true => 'Yes',
                    false => 'No'
                ])->preload()->searchable()->placeholder(__('Choose'))->required(),
            ])
        ]);
    }

    public function next()
    {
        session(['step-1-round-way-flight' => $this->form->getState()]);

        session(['roundway_flights_data' => [
            'form' => $this->form->getState(),
            'options' => [
                'hotels' => session()->get('roundway_options_hotels_primary') ?? [],
                'cars' => session()->get('roundway_options_cars_primary') ?? [],
                'cruises' => session()->get('roundway_options_cruises_primary') ?? [],
                'transfers' => session()->get('roundway_options_transfers_primary') ?? [],
                'activities' => session()->get('roundway_options_activities_primary') ?? [],
            ]
        ]]);

        Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
        return $this->redirect(route('flight.step-2'), false);
    }

    public function render()
    {
        return view('livewire.forms.round-way-flight-form');
    }
}
