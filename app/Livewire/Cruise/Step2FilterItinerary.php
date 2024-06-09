<?php

namespace App\Livewire\Cruise;

use App\Models\Country;
use App\Models\CruiseAdditionalInfo;
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

    public $departure_port;
    public $destination;
    public $length_of_cruise;
    public $any_month_from;
    public $any_month_to;
    public $travelers;
    public $additional_info;

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
        if (session()->has('step-1-cruise')) {
            $this->session = session()->get('step-1-cruise');
        }
    }

    public function editAction(): Action {
        return Action::make('edit')->outlined()->label(__('Itinerary'))->size('lg')->icon('heroicon-o-adjustments-horizontal')->action(function (array $data) {
            session(['step-1-cruise' => $data]);
            Notification::make()->title(__('Itinerary updated.'))->success()->send();
        })->form([
            Forms\Components\Grid::make([
                'default' => 1,
                'sm' => 3,
                'md' => 4,
                'lg' => 5
            ])->schema([
                // Forms\Components\Select::make('departure_port')->label(__('Departure port'))->options(Country::where('status', true)->pluck('name', 'name'))->preload()->searchable()->placeholder('Choose port')->required()->default($this->session['departure_port'] ?? ''),

                Forms\Components\Select::make('departure_port')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required()->default($this->session['departure_port'] ?? ''),

                // Forms\Components\Select::make('destination')->label(__('Destination'))->options(Country::where('status', true)->pluck('name', 'name'))->preload()->searchable()->placeholder(__('Choose port'))->required()->default($this->session['destination'] ?? ''),

                Forms\Components\Select::make('destination')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required()->default($this->session['destination'] ?? ''),

                Forms\Components\TextInput::make('length_of_cruise')->label(__('Length of cruise'))->numeric()->minValue(1)->postfix(__('Days'))->required()->default($this->session['length_of_cruise'] ?? ''),

                Forms\Components\DatePicker::make('any_month_from')->label(__('Any month from'))->native(false)->required()->default($this->session['any_month_from'] ?? ''),

                Forms\Components\DatePicker::make('any_month_to')->label(__('Any month to'))->native(false)->required()->default($this->session['any_month_to'] ?? ''),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 2,
            ])->schema([
                Forms\Components\TextInput::make('travelers')->label(__('Travelers'))->numeric()->minValue(1)->postfix(__('People'))->required()->default($this->session['travelers'] ?? ''),

                Forms\Components\Select::make('additional_info')->label(__('Additional info'))->options(CruiseAdditionalInfo::where('status', true)->pluck('name', 'name'))->preload()->searchable()->placeholder(__('Choose'))->required()->default($this->session['additional_info'] ?? ''),
            ])
        ]);
    }

    public function render()
    {
        return view('livewire.cruise.step2-filter-itinerary');
    }
}
