<?php

namespace App\Livewire\Forms;

use App\Models\AccommodationType;
use App\Models\Airline;
use App\Models\Amenity;
use App\Models\BedType;
use App\Models\CarType;
use App\Models\FlightClass;
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
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;
use Livewire\Attributes\Url;

class OneWayFlightFormForMultiCity extends Component implements HasForms, HasActions
{

    use InteractsWithForms;
    use InteractsWithActions;

    public $identifier = 1;

    public $from = '';
    public $to = '';
    public $departure_date = '';
    public $trip_days = '';
    public $no_of_passenger = '';
    public $flight_type = '';
    public $is_flexible_date = '';
    public $is_visa = '';
    public $airline = '';
    public $is_insurance = '';

    public function deleteOption(): Action
    {
        return Action::make('deleteOption')->label('Delete')->outlined()->iconButton()->icon('heroicon-o-trash')->requiresConfirmation()->action(function (array $arguments) {
            if (isset($arguments['type'])) {
                if ($arguments['type'] == 'hotel') {
                    $hotelOptions = collect(session('multicity_options_'. $this->identifier .'_hotels'));
                    $hotelOptions->forget((int) $arguments['key']);
                    $hotelOptions = $hotelOptions->values()->toArray();
                    session(['multicity_options_'. $this->identifier .'_hotels' => $hotelOptions]);
                    Notification::make()
                        ->title('Option Removed Successfully')
                        ->success()
                        ->send();
                }
            }
        });
    }

    public function editOption(): Action
    {
        return Action::make('editOption')->label('Edit')->outlined()->iconButton()->icon('heroicon-o-pencil-square')->action(function (array $arguments) {
            if (isset($arguments['type'])) {
                if ($arguments['type'] == 'hotel') {
                    $hotelOptions = session('multicity_options_'. $this->identifier .'_hotels')[(int)$arguments['key']];
                    $this->replaceMountedAction('addHotel', $hotelOptions);
                } elseif ($arguments['type'] == 'car') {
                    $carOptions = session('multicity_options_'. $this->identifier .'_cars')[(int)$arguments['key']];
                    $this->replaceMountedAction('addCar', $carOptions);
                } elseif ($arguments['type'] == 'cruise') {
                    $cruiseOptions = session('multicity_options_'. $this->identifier .'_cruises')[(int)$arguments['key']];
                    $this->replaceMountedAction('addCruise', $cruiseOptions);
                } elseif ($arguments['type'] == 'transfer') {
                    $transferOptions = session('multicity_options_'. $this->identifier .'_transfers')[(int)$arguments['key']];
                    $this->replaceMountedAction('addTransfer', $transferOptions);
                } elseif ($arguments['type'] == 'activity') {
                    $activityOptions = session('multicity_options_'. $this->identifier .'_activities')[(int)$arguments['key']];
                    $this->replaceMountedAction('addActivity', $activityOptions);
                } else {
                }
            }
        });
    }

    public function mount()
    {
        if (session()->has('multi-city-flight-'.$this->identifier)) {
            $this->form->fill(session()->get('multi-city-flight-'.$this->identifier));
        }
    }

    public function swap() {
        $temp = $this->from;
        $this->from = $this->to;
        $this->to = $temp;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make([
                'default' => 2,
                'sm' => 2,
                'md' => 3,
            ])->schema([
                Forms\Components\Select::make('from')->live()->label(__('From'))->options(function () {
                    $data = State::with('country')->get()
                        ->mapWithKeys(function ($state) {
                            return ["{$state->name}, {$state->country->name}" => "{$state->name}, {$state->country->name}"];
                        })
                        ->toArray();
                    return $data;
                })->preload()->searchable()->placeholder(__('Location'))->required(),
                Forms\Components\Select::make('to')->live()->label(__('To'))->options(function () {
                    $data = State::with('country')->get()
                        ->mapWithKeys(function ($state) {
                            return ["{$state->name}, {$state->country->name}" => "{$state->name}, {$state->country->name}"];
                        })
                        ->toArray();
                    return $data;
                })->preload()->searchable()->placeholder(__('Location'))->required(),
                Forms\Components\DatePicker::make('departure_date')->live()->label(__('Departure date'))->native(false)->required()->minDate(now())->closeOnDateSelection(),
            ]),
            Forms\Components\Grid::make([
                'default' => 2,
                'sm' => 2,
                'md' => 3,
                'lg' => 6,
            ])->schema([
                Forms\Components\TextInput::make('no_of_passenger')->label(__('Passengers'))->numeric()->required()->suffixIcon('heroicon-o-user-group'),
                Forms\Components\Select::make('flight_type')->label(__('Cabin class'))->options(FlightClass::where('status', true)->pluck('name', 'name'))->preload()->searchable()->placeholder(__('Choose'))->required(),
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

    public function shareAction(): Action
    {
        return Action::make('share')->label(__('share'))->outlined()->icon('heroicon-m-share')
            ->action(function () {
                Notification::make()->title('Link Copied')->success()->send();
            });
    }

    // public function next()
    // {
    //     session(['step-1-one-way-flight' => $this->form->getState()]);
    //     Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
    //     return $this->redirect(route('flight.step-2'), false);
    // }

    public function addOptions(): Action
    {
        return Action::make('addOptions')->label('Add Options')->outlined()->form([
            Forms\Components\Radio::make('add_options')->options([
                'Add Hotel' => 'Add Hotel',
                'Add Car' => 'Add Car',
                'Add Cruise' => 'Add Cruise',
                'Add Transfer' => 'Add Transfer',
                'Add Activity' => 'Add Activity'
            ])->label('')->extraAttributes([
                'class' => 'add-options-step-1'
            ])
        ])->icon('heroicon-o-plus-circle')->action(function (array $data) {
            if (isset($data['add_options'])) {
                if ($data['add_options'] == 'Add Hotel') {
                    $this->replaceMountedAction('addHotel');
                } elseif ($data['add_options'] == 'Add Car') {
                    $this->replaceMountedAction('addCar');
                } elseif ($data['add_options'] == 'Add Cruise') {
                    $this->replaceMountedAction('addCruise');
                } elseif ($data['add_options'] == 'Add Transfer') {
                    $this->replaceMountedAction('addTransfer');
                } elseif ($data['add_options'] == 'Add Activity') {
                    $this->replaceMountedAction('addActivity');
                } else {
                }
            }
        });
    }

    public function addHotel(): Action
    {
        return Action::make('addHotel')->fillForm(function (array $arguments): array {
            if ($arguments) {
                return [
                    'accommodation_type' => $arguments['accommodation_type'] ?? [],
                    'number_of_bedrooms' => $arguments['number_of_bedrooms'] ?? [],
                    'bed_type' => $arguments['bed_type'] ?? [],
                    'accommodation_rating' => $arguments['accommodation_rating'] ?? [],
                    'other_information' => $arguments['other_information'] ?? []
                ];
            } else {
                return [];
            }
        })->steps([
            Step::make('Type')
                ->schema([
                    Forms\Components\CheckboxList::make('accommodation_type')->options(function () {
                        $accommodation_type = AccommodationType::where('status', true)->pluck('name', 'name');
                        return $accommodation_type;
                    })->label('Select your accommodation type:')
                ]),
            Step::make('Room')
                ->schema([
                    Forms\Components\CheckboxList::make('number_of_bedrooms')->options([
                        '1 Bedroom' => '1 Bedroom',
                        '2 Bedroom' => '2 Bedroom',
                        '3 Bedroom' => '3 Bedroom',
                        'Other' => 'Other'
                    ])->label('Select the number of bedrooms:'),
                    Forms\Components\CheckboxList::make('bed_type')->options(function () {
                        $bed_types = BedType::where('status', true)->pluck('name', 'name');
                        return $bed_types;
                    })->label('Select bed type:')
                ]),
            Step::make('Stars')
                ->schema([
                    Forms\Components\CheckboxList::make('accommodation_rating')->options([
                        '⭐⭐⭐⭐⭐' => '⭐⭐⭐⭐⭐',
                        '⭐⭐⭐⭐' => '⭐⭐⭐⭐',
                        '⭐⭐⭐' => '⭐⭐⭐',
                        '⭐⭐' => '⭐⭐',
                        '⭐' => '⭐',
                        'Doesn\'t matter' => 'Doesn\'t matter'
                    ])->label('Select the stars for your accommodation:'),
                ]),
            Step::make('Other')
                ->schema([
                    Forms\Components\CheckboxList::make('other_information')->options(function () {
                        $amenities = Amenity::where('status', true)->pluck('name', 'name');
                        return $amenities;
                    }),
                ]),
        ])->action(function (array $data) {
            $previousArray = [];

            if (session()->has('multicity_options_'. $this->identifier .'_hotels')) {
                $previousArray = session('multicity_options_'. $this->identifier .'_hotels');
            }

            array_push($previousArray, $data);

            
            session(['multicity_options_'. $this->identifier .'_hotels' => $previousArray]);
            $this->mount();
            $this->render();

            Notification::make()->title('Hotel Option Added Successfully.')->success()->send();
        });
    }

    public function addCar(): Action
    {
        return Action::make('addCar')->fillForm(function (array $arguments): array {
            if ($arguments) {
                return [
                    'pick_up_location' => $arguments['pick_up_location'] ?? [],
                    'drop_off_location' => $arguments['drop_off_location'] ?? [],
                    'pick_up_date' => $arguments['pick_up_date'] ?? [],
                    'pick_up_time' => $arguments['pick_up_time'] ?? [],
                    'drop_off_date' => $arguments['drop_off_date'] ?? [],
                    'drop_off_time' => $arguments['drop_off_time'] ?? [],
                    'car_type' => $arguments['car_type'] ?? [],
                    'no_of_car' => $arguments['no_of_car'] ?? [],
                    'adult' => $arguments['adult'] ?? [],
                    'youths' => $arguments['youths'] ?? [],
                    'child' => $arguments['child'] ?? [],
                    'infant' => $arguments['infant'] ?? [],
                ];
            } else {
                return [];
            }
        })->steps([
            Step::make('Location')
                ->schema([
                    Forms\Components\Placeholder::make('')->dehydrated()->content('Select your location:'),
                    Forms\Components\Select::make('pick_up_location')->options(function () {
                        $data = State::with('country')->get()
                            ->mapWithKeys(function ($state) {
                                return ["{$state->name}, {$state->country->name}" => "{$state->name}, {$state->country->name}"];
                            })
                            ->toArray();
                        return $data;
                    })->prefixIcon('heroicon-o-map-pin')->placeholder('Enter pick up location')->required()->searchable()->preload(),
                    Forms\Components\Select::make('drop_off_location')->options(function () {
                        $data = State::with('country')->get()
                            ->mapWithKeys(function ($state) {
                                return ["{$state->name}, {$state->country->name}" => "{$state->name}, {$state->country->name}"];
                            })
                            ->toArray();
                        return $data;
                    })->prefixIcon('heroicon-o-map-pin')->placeholder('Enter drop off location')->required()->searchable()->preload()
                ]),
            Step::make('Date')
                ->schema([
                    Forms\Components\Placeholder::make('')->dehydrated()->content('Select date and time:')->columnSpanFull(),
                    Forms\Components\DatePicker::make('pick_up_date')->native(false),
                    Forms\Components\TimePicker::make('pick_up_time')->native(false),
                    Forms\Components\DatePicker::make('drop_off_date')->native(false),
                    Forms\Components\TimePicker::make('drop_off_time')->native(false),
                ])->columns(2),
            Step::make('Type')
                ->schema([
                    Forms\Components\CheckboxList::make('car_type')->options(function () {
                        $car_types = CarType::where('status', true)->pluck('name', 'name');
                        return $car_types;
                    })->label('Select car type:'),
                    Forms\Components\TextInput::make('no_of_car')->numeric()->minLength(1),
                ]),
            Step::make('Travelers')
                ->schema([
                    Forms\Components\Placeholder::make('')->content('Number of travelers:'),
                    Forms\Components\TextInput::make('adult')->numeric()->columnSpanFull()->inlineLabel()->minLength(1),
                    Forms\Components\TextInput::make('youths')->numeric()->columnSpanFull()->inlineLabel()->minLength(1)->placeholder('Youths (Age 12-17)'),
                    Forms\Components\TextInput::make('child')->numeric()->columnSpanFull()->inlineLabel()->minLength(1)->placeholder('child (Age 2-11)'),
                    Forms\Components\TextInput::make('infant')->numeric()->columnSpanFull()->inlineLabel()->minLength(1)->placeholder('Infant (Under 2)'),
                ]),
        ])->action(function (array $data) {
            $previousArray = [];
            if (session()->has('multicity_options_'. $this->identifier .'_cars')) {
                $previousArray = session('multicity_options_'. $this->identifier .'_cars');
            }
            array_push($previousArray, $data);
            session(['multicity_options_'. $this->identifier .'_cars' => $previousArray]);

            Notification::make()->title('Car Option Added Successfully.')->success()->send();
        });
    }

    public function addCruise(): Action
    {
        return Action::make('addCruise')->fillForm(function (array $arguments): array {
            if ($arguments) {
                return [
                    'pick_up_location' => $arguments['pick_up_location'] ?? [],
                    'drop_off_location' => $arguments['drop_off_location'] ?? [],
                    'pick_up_date' => $arguments['pick_up_date'] ?? [],
                    'drop_off_date' => $arguments['drop_off_date'] ?? [],
                    'duration' => $arguments['duration'] ?? [],
                    'other_information' => $arguments['other_information'] ?? [],
                ];
            } else {
                return [];
            }
        })->steps([
            Step::make('Location')
                ->schema([
                    Forms\Components\Placeholder::make('')->dehydrated()->content('Select your location:'),
                    Forms\Components\Select::make('pick_up_location')->options(function () {
                        $data = State::with('country')->get()
                            ->mapWithKeys(function ($state) {
                                return ["{$state->name}, {$state->country->name}" => "{$state->name}, {$state->country->name}"];
                            })
                            ->toArray();
                        return $data;
                    })->prefixIcon('heroicon-o-map-pin')->placeholder('Enter pick up location')->required()->searchable()->preload(),
                    Forms\Components\Select::make('drop_off_location')->options(function () {
                        $data = State::with('country')->get()
                            ->mapWithKeys(function ($state) {
                                return ["{$state->name}, {$state->country->name}" => "{$state->name}, {$state->country->name}"];
                            })
                            ->toArray();
                        return $data;
                    })->prefixIcon('heroicon-o-map-pin')->placeholder('Enter drop off location')->required()->searchable()->preload()
                ]),
            Step::make('Date')
                ->schema([
                    Forms\Components\Placeholder::make('')->dehydrated()->content('Select date:')->columnSpanFull(),
                    Forms\Components\DatePicker::make('pick_up_date')->native(false),
                    Forms\Components\DatePicker::make('drop_off_date')->native(false),
                ]),
            Step::make('Duration')
                ->schema([
                    Forms\Components\Radio::make('duration')->options([
                        'Any Duration' => 'Any Duration',
                        '1-3 Nights' => '1-3 Nights',
                        '1-6 Nights' => '1-6 Nights',
                        '7-9 Nights' => '7-9 Nights',
                        'Over 9 Nights' => 'Over 9 Nights'
                    ])->label('Enter your duration:'),
                ]),
            Step::make('Other')
                ->schema([
                    Forms\Components\CheckboxList::make('other_information')->options(function () {
                        $amenities = Amenity::where('status', true)->pluck('name', 'name');
                        return $amenities;
                    }),
                ]),
        ])->action(function (array $data) {
            $previousArray = [];
            if (session()->has('multicity_options_'. $this->identifier .'_cruises')) {
                $previousArray = session('multicity_options_'. $this->identifier .'_cruises');
            }
            array_push($previousArray, $data);
            session(['multicity_options_'. $this->identifier .'_cruises' => $previousArray]);

            Notification::make()->title('Cruise Option Added Successfully.')->success()->send();
        });
    }

    public function addTransfer(): Action
    {
        return Action::make('addTransfer')->fillForm(function (array $arguments): array {
            if ($arguments) {
                return [
                    'dropping_off' => $arguments['dropping_off'] ?? [],
                ];
            } else {
                return [];
            }
        })->form([
            Forms\Components\Placeholder::make('')->dehydrated()->content('Select your drop off:')->extraAttributes(['class' => 'font-bold']),
            Forms\Components\Select::make('dropping_off')->options(function () {
                $data = State::with('country')->get()
                    ->mapWithKeys(function ($state) {
                        return ["{$state->name}, {$state->country->name}" => "{$state->name}, {$state->country->name}"];
                    })
                    ->toArray();
                return $data;
            })->prefixIcon('heroicon-o-map-pin')->placeholder('Enter dropping off location')->required()->searchable()->preload(),
        ])->action(function (array $data) {
            $previousArray = [];
            if (session()->has('multicity_options_'. $this->identifier .'_transfers')) {
                $previousArray = session('multicity_options_'. $this->identifier .'_transfers');
            }
            array_push($previousArray, $data);
            session(['multicity_options_'. $this->identifier .'_transfers' => $previousArray]);

            Notification::make()->title('Transfer Option Added Successfully.')->success()->send();
        });
    }

    public function addActivity(): Action
    {
        return Action::make('addActivity')->fillForm(function (array $arguments): array {
            if ($arguments) {
                return [
                    'activity_summary' => $arguments['activity_summary'] ?? [],
                ];
            } else {
                return [];
            }
        })->form([
            Forms\Components\Placeholder::make('')->dehydrated()->content('Enter your activity summary:')->extraAttributes(['class' => 'font-bold']),
            Forms\Components\Textarea::make('activity_summary')->required()->placeholder('Enter a brief description')
        ])->action(function (array $data) {
            $previousArray = [];
            if (session()->has('multicity_options_'. $this->identifier .'_activities')) {
                $previousArray = session('multicity_options_'. $this->identifier .'_activities');
            }
            array_push($previousArray, $data);
            session(['multicity_options_'. $this->identifier .'_activities' => $previousArray]);

            Notification::make()->title('Activity Option Added Successfully.')->success()->send();
        });
    }

    public function render()
    {
        return view('livewire.forms.one-way-flight-form-for-multi-city');
    }
}
