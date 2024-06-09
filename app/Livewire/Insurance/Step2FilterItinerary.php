<?php

namespace App\Livewire\Insurance;

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

    public $country;
    public $departure_date;
    public $arrival_date;
    public $no_of_travelers;
    public $age_of_travelers;

    public $session = [];

    public function mount()
    {
        if (session()->has('step-1-insurance')) {
            $this->session = session()->get('step-1-insurance');
        }
    }

    public function editAction(): Action {
        return Action::make('edit')->outlined()->label(__('Itinerary'))->size('lg')->icon('heroicon-o-adjustments-horizontal')->action(function (array $data) {
            session(['step-1-insurance' => $data]);
            Notification::make()->title(__('Itinerary updated.'))->success()->send();
        })->form([
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 3,
            ])->schema([
                Forms\Components\Select::make('country')->label(__('Country'))->options(Country::where('status', true)->orderBy('name', 'ASC')->pluck('name', 'name'))->placeholder('Country')->searchable()->preload()->required()->default($this->session['country'] ?? ''),

                Forms\Components\DatePicker::make('departure_date')->label(__('Departure date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->default($this->session['departure_date'] ?? ''),

                Forms\Components\DatePicker::make('arrival_date')->label(__('Arrival date'))->native(false)->suffixIcon('heroicon-o-calendar-days')->required()->default($this->session['arrival_date'] ?? ''),
            ]),
            Forms\Components\Grid::make([
                'default' => 1,
                'xs' => 2,
                'sm' => 2,
            ])->schema([
                Forms\Components\TextInput::make('no_of_travelers')->label(__('No of travelers'))->numeric()->required()->suffixIcon('heroicon-o-user-group')->default($this->session['no_of_travelers'] ?? ''),

                Forms\Components\TextInput::make('age_of_travelers')->label(__('Age of travelers'))->numeric()->required()->suffix('years')->default($this->session['age_of_travelers'] ?? ''),
            ])
        ]);
    }

    public function render()
    {
        return view('livewire.insurance.step2-filter-itinerary');
    }
}
