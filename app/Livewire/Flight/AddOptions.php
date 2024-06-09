<?php

namespace App\Livewire\Flight;

use App\Models\AccommodationType;
use App\Models\Amenity;
use App\Models\BedType;
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
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;

class AddOptions extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public $id;

    public $flight_type;

    public $types = [
        'add-hotels' => 'Add Hotels',
        'add-car' => 'Add Car',
        'add-cruises' => 'Add Cruises',
        'add-transfer' => 'Add Transfer',
        'add-activity' => 'Add Activity',
    ];

    public $option_type = '';

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

    public function selectOptionType($type)
    {
        $this->option_type = $type;
    }

    public function editOption(): Action
    {
        return Action::make('editOption')->label('Edit')->outlined()->iconButton()->icon('heroicon-o-pencil-square')->action(function (array $arguments) {
            if (isset($arguments['type'])) {
                if ($arguments['type'] == 'hotel') {
                    $hotelOptions = session($this->flight_type.'_options_hotels_'.$this->id)[(int)$arguments['key']];
                    $this->replaceMountedAction('addHotel', $hotelOptions);
                } elseif ($arguments['type'] == 'car') {
                    $carOptions = session($this->flight_type.'_options_cars_'.$this->id)[(int)$arguments['key']];
                    $this->replaceMountedAction('addCar', $carOptions);
                } elseif ($arguments['type'] == 'cruise') {
                    $cruiseOptions = session($this->flight_type.'_options_cruises_'.$this->id)[(int)$arguments['key']];
                    $this->replaceMountedAction('addCruise', $cruiseOptions);
                } elseif ($arguments['type'] == 'transfer') {
                    $transferOptions = session($this->flight_type.'_options_transfers_'.$this->id)[(int)$arguments['key']];
                    $this->replaceMountedAction('addTransfer', $transferOptions);
                } elseif ($arguments['type'] == 'activity') {
                    $activityOptions = session($this->flight_type.'_options_activities_'.$this->id)[(int)$arguments['key']];
                    $this->replaceMountedAction('addActivity', $activityOptions);
                } else {
                }
            }
        });
    }

    public function deleteOption(): Action
    {
        return Action::make('deleteOption')->label('Delete')->outlined()->iconButton()->icon('heroicon-o-trash')->requiresConfirmation()->action(function (array $arguments) {
            if (isset($arguments['type'])) {
                if ($arguments['type'] == 'hotel') {
                    $hotelOptions = collect(session($this->flight_type.'_options_hotels_'.$this->id));
                    $hotelOptions->forget((int) $arguments['key']);
                    $hotelOptions = $hotelOptions->values()->toArray();
                    session([$this->flight_type.'_options_hotels_'.$this->id => $hotelOptions]);
                    Notification::make()
                        ->title('Option Removed Successfully')
                        ->success()
                        ->send();
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

            if (session()->has($this->flight_type.'_options_hotels_'.$this->id)) {
                $previousArray = session($this->flight_type.'_options_hotels_'.$this->id);
            }

            array_push($previousArray, $data);

            session([$this->flight_type.'_options_hotels_'.$this->id => $previousArray]);

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
                    Forms\Components\Select::make('pick_up_location')->searchable()->getSearchResultsUsing(function (string $search) {
                        $data = $this->googleSearch($search);
    
                        $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {
                            
                            return [
                                $value["description"] => $value["description"]
                            ];
                        })->toArray();
    
                        return $suggestions;
                    })->translateLabel()->prefixIcon('heroicon-o-map-pin')->placeholder(__('Enter pick up location'))->required(),

                    Forms\Components\Select::make('drop_off_location')->searchable()->getSearchResultsUsing(function (string $search) {
                        $data = $this->googleSearch($search);
    
                        $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {
                            
                            return [
                                $value["description"] => $value["description"]
                            ];
                        })->toArray();
    
                        return $suggestions;
                    })->translateLabel()->prefixIcon('heroicon-o-map-pin')->placeholder(__('Enter drop off location'))->required(),
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
            if (session()->has($this->flight_type.'_options_cars_'.$this->id)) {
                $previousArray = session($this->flight_type.'_options_cars_'.$this->id);
            }
            array_push($previousArray, $data);
            session([$this->flight_type.'_options_cars_'.$this->id => $previousArray]);

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
            if (session()->has($this->flight_type.'_options_cruises_'.$this->id)) {
                $previousArray = session($this->flight_type.'_options_cruises_'.$this->id);
            }
            array_push($previousArray, $data);
            session([$this->flight_type.'_options_cruises_'.$this->id => $previousArray]);

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
            Forms\Components\Select::make('dropping_off')->searchable()->getSearchResultsUsing(function (string $search) {
                $data = $this->googleSearch($search);

                $suggestions = collect($data["predictions"])->mapWithKeys(function ($value) {
                    
                    return [
                        $value["description"] => $value["description"]
                    ];
                })->toArray();

                return $suggestions;
            })->translateLabel()->prefixIcon('heroicon-o-map-pin')->placeholder(__('Enter dropping off location'))->required(),
        ])->action(function (array $data) {
            $previousArray = [];
            if (session()->has($this->flight_type.'_options_transfers_'.$this->id)) {
                $previousArray = session($this->flight_type.'_options_transfers_'.$this->id);
            }
            array_push($previousArray, $data);
            session([$this->flight_type.'_options_transfers_'.$this->id => $previousArray]);

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
            if (session()->has($this->flight_type.'_options_activities_'.$this->id)) {
                $previousArray = session($this->flight_type.'_options_activities_'.$this->id);
            }
            array_push($previousArray, $data);
            session([$this->flight_type.'_options_activities_'.$this->id => $previousArray]);

            Notification::make()->title('Activity Option Added Successfully.')->success()->send();
        });
    }

    public function next()
    {
        if ($this->option_type == 'add-hotels') {
            $this->replaceMountedAction('addHotel');
        }
        elseif ($this->option_type == 'add-car') {
            $this->replaceMountedAction('addCar');
        }
        elseif ($this->option_type == 'add-cruises') {
            $this->replaceMountedAction('addCruise');
        }
        elseif ($this->option_type == 'add-transfer') {
            $this->replaceMountedAction('addTransfer');
        }
        elseif ($this->option_type == 'add-activity') {
            $this->replaceMountedAction('addActivity');
        }
        else {
            $this->replaceMountedAction('addHotel');
        }
    }

    public function render()
    {
        return view('livewire.flight.add-options');
    }
}
