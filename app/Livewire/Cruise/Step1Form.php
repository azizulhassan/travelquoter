<?php

namespace App\Livewire\Cruise;

use App\Forms\Components\cruise\AdditionalInfo;
use App\Forms\Components\cruise\AddTravelers;
use App\Models\Country;
use App\Models\CruiseAdditionalInfo;
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

    #[Url(except:'', keep:true)]
    public $departure_port = '';

    #[Url(except:'', keep:true)]
    public $destination = '';

    #[Url(except:'', keep:true)]
    public $length_of_cruise = '';

    #[Url(except:'', keep:true)]
    public $any_month_from = '';

    #[Url(except:'', keep:true)]
    public $any_month_to = '';

    #[Url(except:'', keep:true)]
    public $no_of_travelers = '';

    #[Url(except:'', keep:true)]
    public $additional_info = '';


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
            $this->form->fill(session()->get('step-1-cruise'));
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

    public function getAdditionalInfoProperty()
    {
        if(session()->has('additional_info')) {
            $additionalInfo = session()->get('additional_info');
            return implode(', ', $additionalInfo);
        }

        return '';
    }

    public function resetForm()
    {
        // if (session()->has('step-1-cruise')) {
        //     session()->forget('step-1-cruise');
        //     $this->form->fill();
        // }

        session()->forget('step-1-cruise');
        session()->forget('no_of_travelers');
        session()->forget('additional_info');

        $this->departure_port = '';
        $this->destination = '';
        $this->length_of_cruise = '';
        $this->any_month_from = '';
        $this->any_month_to = '';
        $this->no_of_travelers = '';
        $this->additional_info = '';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 1,
                'sm' => 3,
                'md' => 4,
                'lg' => 5
            ])->schema([
                Forms\Components\Select::make('departure_port')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required(),

                Forms\Components\Select::make('destination')->translateLabel()->searchable()->getSearchResultsUsing(function (string $search) {
                    $data = $this->googleSearch($search);

                    $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {

                        return [
                            $value["description"] => $value["description"]
                        ];
                    })->toArray();

                    return $suggestions;
                })->required(),

                Forms\Components\TextInput::make('length_of_cruise')->label(__('Length of cruise'))->numeric()->minValue(1)->postfix(__('Days'))->required(),
                Forms\Components\DatePicker::make('any_month_from')->label(__('Any month from'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\DatePicker::make('any_month_to')->label(__('Any month to'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 2,
            ])->schema([
                AddTravelers::make('no_of_travelers')->label(__('Travelers'))->required(),
                AdditionalInfo::make('additional_info')->label(__('Additional info'))->required(),
            ])
        ]);
    }

    public function share() {
        Notification::make()->title('Link copied successfully.')->info()->send();

        $this->js(<<<JS
            navigator.clipboard.writeText(window.location.href);
        JS);
    }

    // public function shareAction(): Action
    // {
    //     return Action::make('share')->label(__('share'))->outlined()->icon('heroicon-m-share')
    //         ->action(function () {
    //             Notification::make()->title('Link Copied')->success()->send();
    //         });
    // }

    public function next()
    {
        if(session()->has('no_of_travelers')) {
            $this->no_of_travelers = session()->get('no_of_travelers');
        }

        if(session()->has('additional_info')) {
            $this->additional_info = session()->get('additional_info');
        }

        session(['step-1-cruise' => $this->form->getState()]);
        Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
        return $this->redirect(route('cruise.step-2'), false);
    }

    public function render()
    {
        return view('livewire.cruise.step1-form');
    }
}
