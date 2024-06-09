<?php

namespace App\Livewire\Visa;

use App\Forms\Components\Visa\AddTravelers;
use App\Forms\Components\Visa\NoOfVisits;
use App\Forms\Components\Visa\PassportType as VisaPassportType;
use App\Forms\Components\Visa\VisitPurpose as VisaVisitPurpose;
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
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class Step1Form extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    #[Url(except:'', keep:true)]
    public $country_of_passport = '';

    #[Url(except:'', keep:true)]
    public $passport_type = '';
    public $passport_type_id;

    #[Url(except:'', keep:true)]
    public $country_to_visit = '';

    #[Url(except:'', keep:true)]
    public $pick_up_date = '';

    #[Url(except:'', keep:true)]
    public $drop_off_date = '';

    #[Url(except:'', keep:true)]
    public $no_of_travelers = '';

    // #[Url(except:'', keep:true)]
    public $visit_purpose_id = '';

    #[Url(except:'', keep:true)]
    public $visit_purpose_string = '';
    
    #[Url(except:'', keep:true)]
    public $no_of_visit = '';

    public $totalTravelers = 0;

    #[On('travelers-added')]
    public function updateTravelers($no_of_travelers) {
        $this->totalTravelers = $no_of_travelers['adults'] + $no_of_travelers['infants'] + $no_of_travelers['children'];

        $this->no_of_travelers = '';
        if($this->totalTravelers > 0) {
            $this->no_of_travelers = $no_of_travelers;
        }
    }

    #[On('purpose-selected')]
    public function selectPurpose($id, $purpose) {
        // dd($id);
        $this->visit_purpose_id = $id;
        $this->visit_purpose_string = $purpose;
    }

    #[On('number-selected')]
    public function selectNumber($number) {
        $this->no_of_visit = $number;
    }

    #[On('passport-type-selected')]
    public function selectPassportType() {
        $this->passport_type = session()->get('selected_passport_type');
        $this->passport_type_id = session()->get('selected_passport_type_id');
    }

    public function mount()
    {
        if (session()->has('step-1-visa')) {
            $this->form->fill(session()->get('step-1-visa'));
        }

        if(session()->has('no_of_travelers')) {
            $this->no_of_travelers = session()->get('no_of_travelers');
            $this->totalTravelers = $this->no_of_travelers['adults'] + $this->no_of_travelers['infants'] + $this->no_of_travelers['children'];
        }
        
        if(session()->has('selected_purpose_id')) {
            $this->visit_purpose_id = session()->get('selected_purpose_id');
        }

        if(session()->has('selected_purpose')) {
            $this->visit_purpose_string = session()->get('selected_purpose');
        }
    }

    public function resetForm() {
        // if (session()->has('step-1-visa')) {
        //     session()->forget('step-1-visa');
        //     $this->form->fill();
        // }

        session()->forget(['step-1-visa', 'no_of_travelers', 'selected_no', 'selected_purpose', 'selected_purpose_id']);

        $this->country_of_passport = '';
        $this->passport_type = '';
        $this->country_to_visit = '';
        $this->pick_up_date = '';
        $this->drop_off_date = '';
        $this->no_of_travelers = '';
        $this->visit_purpose_id = '';
        $this->no_of_visit = '';
        $this->visit_purpose_string = '';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 3,
                'md' => 4,
                'lg' => 5
            ])->schema([
                Forms\Components\Select::make('country_of_passport')->label(__('Country of passport'))->options(Country::where('status', true)->orderBy('name', 'ASC')->pluck('name', 'name'))->placeholder('Country')->searchable()->preload()->required(),
                VisaPassportType::make('passport_type_id')->label(__('Passport type'))->required(),
                Forms\Components\Select::make('country_to_visit')->label(__('Country to visit'))->options(Country::where('status', true)->orderBy('name', 'ASC')->pluck('name', 'name'))->placeholder('Country')->searchable()->preload()->required(),
                Forms\Components\DatePicker::make('pick_up_date')->label(__('Pick up date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->minDate(now())->closeOnDateSelection(),
                Forms\Components\DatePicker::make('drop_off_date')->label(__('Drop off date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->minDate(now())->closeOnDateSelection(),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 3,
            ])->schema([
                AddTravelers::make('no_of_travelers')->label(__('No of travelers'))->required(),
                VisaVisitPurpose::make('visit_purpose_id')->label(__('Visit purpose'))->required(),
                NoOfVisits::make('no_of_visit')->label(__('Number of visits'))->required(),
            ])
        ]);
    }

    // public function shareAction(): Action {
    //     return Action::make('share')->label(__('share'))->outlined()->icon('heroicon-m-share')
    //         ->action(function () {
    //             Notification::make()->title('Link Copied')->success()->send();
    //             // return <<<'JS'
    //             //     var text = "Example text to appear on clipboard";
    //             //     navigator.clipboard.writeText(text).then(function() {
    //             //     console.log('Async: Copying to clipboard was successful!');
    //             //     }, function(err) {
    //             //     console.error('Async: Could not copy text: ', err);
    //             //     });
    //             // JS;
    //         });
    // }

    public function share()
    {
        Notification::make()->title('Link copied successfully.')->info()->send();

        $this->js(<<<JS
            navigator.clipboard.writeText(window.location.href);
        JS);
    }

    public function next() {
        session(['step-1-visa' => $this->form->getState()]);
        Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
        return $this->redirect(route('visa.step-2') , false);
    }

    public function render()
    {
        return view('livewire.visa.step1-form');
    }
}
