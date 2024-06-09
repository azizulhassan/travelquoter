<?php

namespace App\Livewire\Hotel;

use App\Models\AccommodationType;
use App\Models\Amenity;
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

    public $desired_city;
    public $check_in;
    public $check_out;
    public $trip_days;
    public $no_of_travelers;
    public $accommodation_type;
    public $room;
    public $rating;
    public $other;

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
        if (session()->has('step-1-hotel')) {
            $this->session = session()->get('step-1-hotel');
        }
    }

    public function editAction(): Action
    {
        return Action::make('edit')->outlined()->label(__('Itinerary'))->size('lg')->icon('heroicon-o-adjustments-horizontal')->action(function (array $data) {
            session(['step-1-hotel' => $data]);
            Notification::make()->title(__('Itinerary updated.'))->success()->send();
        })->form([
            Forms\Components\Grid::make([
                'default' => 2,
                'sm' => 3,
                'md' => 3,
                'lg' => 6
            ])->schema([
                Forms\Components\Select::make('desired_city')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required()->default($this->session['desired_city'] ?? ''),
                Forms\Components\DatePicker::make('check_in')->label(__('Check in'))->native(false)->required()->default($this->session['check_in'] ?? ''),
                Forms\Components\DatePicker::make('check_out')->label(__('Check out'))->native(false)->required()->default($this->session['check_out'] ?? ''),
                Forms\Components\TextInput::make('trip_days')->label(__('Trip days'))->numeric()->minValue(1)->postfix(__('Days'))->required()->default($this->session['trip_days'] ?? ''),
                Forms\Components\TextInput::make('no_of_travelers')->label(__('No of travelers'))->numeric()->minValue(1)->postfix(__('People'))->required()->default($this->session['no_of_travelers'] ?? ''),
                Forms\Components\Select::make('accommodation_type')->label(__('Accommodation type'))->options(AccommodationType::where('status', true)->pluck('name', 'name'))->preload()->searchable()->placeholder(__('Type'))->required()->default($this->session['accommodation_type'] ?? ''),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 2,
                'md' => 3,
            ])->schema([
                Forms\Components\Select::make('room')->options([
                    'One' => __('One'),
                    'Two' => __('Two'),
                    'Three' => __('Three'),
                    'Four' => __('Four'),
                    'Five' => __('Five')
                ])->preload()->searchable()->placeholder(__('Choose'))->postfix(__('Bedroom'))->required()->default($this->session['room'] ?? ''),
                Forms\Components\Select::make('rating')->options([
                    '⭐⭐⭐⭐⭐ (5 Stars)' => '⭐⭐⭐⭐⭐ ' . __('(5 Stars)'),
                    '⭐⭐⭐⭐ (4 Stars)' => '⭐⭐⭐⭐ ' . __('(4 Stars)'),
                    '⭐⭐⭐ (3 Stars)' => '⭐⭐⭐ ' . __('(3 Stars)'),
                    '⭐⭐ (2 Stars)' => '⭐⭐ ' . __('(2 Stars)'),
                    '⭐ (1 Star)' => '⭐ ' . __('(1 Star)'),
                    'Doesn\'t matter' => __('Doesn\'t matter'),
                ])->preload()->searchable()->placeholder(__('Choose'))->required()->default($this->session['rating'] ?? ''),
                Forms\Components\Select::make('other')->label(__('Other'))->options(Amenity::where('status', true)->pluck('name', 'name'))->multiple()->preload()->searchable()->placeholder(__('Choose'))->required()->default($this->session['other'] ?? ''),
            ])
        ]);
    }

    public function render()
    {
        return view('livewire.hotel.step2-filter-itinerary');
    }
}
