<?php

namespace App\Livewire\Car;

use App\Models\CarType;
use App\Models\State;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms;
use Filament\Notifications\Notification;

class Step2FilterItinerary extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $pick_up_location;
    public $drop_off_location;
    public $pick_up_date;
    public $pick_up_time;
    public $drop_off_date;
    public $drop_off_time;
    public $no_of_travelers;
    public $car_type;
    public $no_of_cars;

    public $session = [];

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
            $this->session = session()->get('step-1-car');
        }
    }

    public function editAction(): Action {
        return Action::make('edit')->outlined()->label(__('Itinerary'))->size('lg')->icon('heroicon-o-adjustments-horizontal')->action(function (array $data) {
            session(['step-1-car' => $data]);
            Notification::make()->title(__('Itinerary updated.'))->success()->send();
        })->form([
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
                })->required()->default($this->session['pick_up_location'] ?? ''),
                Forms\Components\Select::make('drop_off_location')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required()->default($this->session['drop_off_location'] ?? ''),
                Forms\Components\DatePicker::make('pick_up_date')->label(__('Pick up date'))->native(false)->required()->default($this->session['pick_up_date'] ?? ''),
                Forms\Components\TimePicker::make('pick_up_time')->label(__('Pick up time'))->native(false)->required()->default($this->session['pick_up_time'] ?? ''),
                Forms\Components\DatePicker::make('drop_off_date')->label(__('Drop off date'))->native(false)->required()->default($this->session['drop_off_date'] ?? ''),
                Forms\Components\TimePicker::make('drop_off_time')->label(__('Drop off time'))->native(false)->required()->default($this->session['drop_off_time'] ?? ''),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 3,
            ])->schema([
                Forms\Components\TextInput::make('no_of_travelers')->label(__('No of travelers'))->numeric()->required()->suffixIcon('heroicon-o-user-group')->default($this->session['no_of_travelers'] ?? ''),
                Forms\Components\Select::make('car_type')->label(__('Car type'))->options(CarType::where('status', true)->pluck('name', 'name'))->preload()->searchable()->placeholder(__('Type'))->required()->default($this->session['car_type'] ?? ''),
                Forms\Components\TextInput::make('no_of_cars')->label(__('No of cars'))->numeric()->required()->default($this->session['no_of_cars'] ?? ''),
            ])
        ]);
    }

    public function render()
    {
        return view('livewire.car.step2-filter-itinerary');
    }
}
