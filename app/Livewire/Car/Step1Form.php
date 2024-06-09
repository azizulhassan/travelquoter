<?php

namespace App\Livewire\Car;

use App\Forms\Components\Car\AddCarType;
use App\Forms\Components\Car\AddNoOfCars;
use App\Forms\Components\Car\AddTravelers;
use App\Models\CarType;
use App\Models\State;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Attributes\Url;

class Step1Form extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    #[Url(except: '', keep: true)]
    public $pick_up_location = '';

    #[Url(except: '', keep: true)]
    public $drop_off_location = '';

    #[Url(except: '', keep: true)]
    public $pick_up_date = '';

    #[Url(except: '', keep: true)]
    public $pick_up_time = '';

    #[Url(except: '', keep: true)]
    public $drop_off_date = '';

    #[Url(except: '', keep: true)]
    public $drop_off_time = '';

    #[Url(except: '', keep: true)]
    public $no_of_travelers;

    #[Url(except: '', keep: true)]
    public $car_type = '';

    #[Url(except: '', keep: true)]
    public $no_of_cars = '';

    public $selected_car_types = '';

    public function googleSearch($search)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' . $search . '&key=' . env('GOOGLE_MAPS_API_KEY'),
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


    public function mount()
    {
        if (session()->has('step-1-car')) {
            $this->form->fill(session()->get('step-1-car'));
        }

        if(session()->has('no_of_travelers')) {
            $this->no_of_travelers = session()->get('no_of_travelers');
        }

        if(session()->has('no_of_cars')) {
            $this->no_of_cars = session()->get('no_of_cars');
        }

        if(session()->has('car_type')) {
            $this->car_type = session()->get('car_type');
            $this->selected_car_types = implode(', ', $this->car_type);
        }
    }

    public function getTotalTravelersProperty()
    {
        if(session()->has('no_of_travelers')) {
            $no_of_travelers = session()->get('no_of_travelers');
            return $no_of_travelers['infants'] + $no_of_travelers['adults'] + $no_of_travelers['children'];
        }

        return 0;
    }

    public function resetForm()
    {
        // if (session()->has('step-1-car')) {
        //     session()->forget('step-1-car');
        //     $this->form->fill();
        // }

        session()->forget(['step-1-car', 'car_type', 'no_of_cars', 'no_of_travelers']);

        $this->pick_up_location = '';
        $this->drop_off_location = '';
        $this->pick_up_date = '';
        $this->pick_up_time = '';
        $this->drop_off_date = '';
        $this->drop_off_time = '';
        $this->no_of_travelers = '';
        $this->car_type = '';
        $this->no_of_cars = '';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 2,
                'sm' => 3,
                'md' => 3,
                'lg' => 6
            ])->schema([
                Forms\Components\Select::make('pick_up_location')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required(),
                Forms\Components\Select::make('drop_off_location')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required(),
                Forms\Components\DatePicker::make('pick_up_date')->label(__('Pick up date'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\TimePicker::make('pick_up_time')->label(__('Pick up time'))->native(false)->required()->seconds(false),
                Forms\Components\DatePicker::make('drop_off_date')->label(__('Drop off date'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\TimePicker::make('drop_off_time')->label(__('Drop off time'))->native(false)->required()->seconds(false),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 3,
            ])->schema([
                AddTravelers::make('no_of_travelers')->label(__('No of travelers'))->required(),
                AddCarType::make('car_type')->label(__('Car type'))->required(),
                AddNoOfCars::make('no_of_cars')->label(__('No of cars'))->required(),
            ])
        ]);
    }

    // public function shareAction(): Action
    // {
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

        if(session()->has('car_type')) {
            $this->car_type = session()->get('car_type');
            $this->selected_car_types = implode(', ', $this->car_type);
        }

        if(session()->has('no_of_cars')) {
            $this->no_of_cars = session()->get('no_of_cars');
        }

        session(['step-1-car' => $this->form->getState()]);
        Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
        return $this->redirect(route('car.step-2'), false);
    }

    public function render()
    {
        return view('livewire.car.step1-form');
    }
}
