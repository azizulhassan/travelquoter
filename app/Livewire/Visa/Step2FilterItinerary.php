<?php

namespace App\Livewire\Visa;

use App\Models\Country;
use App\Models\PassportType;
use App\Models\VisitPurpose;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;

class Step2FilterItinerary extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $country_of_passport;
    public $passport_type;
    public $country_to_visit;
    public $pick_up_date;
    public $drop_off_date;
    public $no_of_travelers;
    public $visit_purpose;
    public $number_of_visits;

    public $session = [];

    public function mount()
    {
        if (session()->has('step-1-visa')) {
            $this->session = session()->get('step-1-visa');
        }
    }

    public function editAction(): Action {
        return Action::make('edit')->outlined()->label(__('Itinerary'))->size('lg')->icon('heroicon-o-adjustments-horizontal')->action(function (array $data) {
            session(['step-1-visa' => $data]);
            Notification::make()->title(__('Itinerary updated.'))->success()->send();
        })->form([
            Forms\Components\Grid::make([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
            ])->schema([
                Forms\Components\Select::make('country_of_passport')->label(__('Country of passport'))->options(Country::where('status', true)->orderBy('name', 'ASC')->pluck('name', 'name'))->placeholder('Country')->searchable()->preload()->required()->default($this->session['country_of_passport'] ?? ''),

                Forms\Components\Select::make('passport_type')->label(__('Passport type'))->options(PassportType::where('status', true)->pluck('name', 'name'))->placeholder('Choose')->native(false)->preload()->required()->default($this->session['passport_type'] ?? ''),

                Forms\Components\Select::make('country_to_visit')->label(__('Country to visit'))->options(Country::where('status', true)->orderBy('name', 'ASC')->pluck('name', 'name'))->placeholder('Country')->searchable()->preload()->required()->default($this->session['country_to_visit'] ?? ''),

                Forms\Components\DatePicker::make('pick_up_date')->label(__('Pick up date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->default($this->session['pick_up_date'] ?? ''),

                Forms\Components\DatePicker::make('drop_off_date')->label(__('Drop off date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->default($this->session['drop_off_date'] ?? ''),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 3,
            ])->schema([
                Forms\Components\TextInput::make('no_of_travelers')->label(__('No of travelers'))->numeric()->required()->suffixIcon('heroicon-o-user-group')->default($this->session['no_of_travelers'] ?? ''),
                Forms\Components\Select::make('visit_purpose')->label(__('Visit purpose'))->required()->options(VisitPurpose::where('status', true)->pluck('name', 'name'))->searchable()->native(false)->placeholder('Choose')->default($this->session['visit_purpose'] ?? ''),
                Forms\Components\Select::make('number_of_visits')->label(__('Number of visits'))->required()->options([
                    'Once' => 'Once',
                    'Multiple' => 'Multiple'
                ])->native(false)->placeholder('Choose')->default($this->session['number_of_visits'] ?? ''),
            ])
        ]);
    }

    public function render()
    {
        return view('livewire.visa.step2-filter-itinerary');
    }
}
