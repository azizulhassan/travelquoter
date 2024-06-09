<?php

namespace App\Livewire\Car;

use App\Models\CarType;
use Filament\Notifications\Notification;
use Livewire\Component;

class AddCarType extends Component
{
    public $carTypes;
    public $noOfCars = 0;
    public $selectedCarTypes = [];

    public function render()
    {
        return view('livewire.car.add-car-type');
    }

    public function mount() {
        $this->carTypes = CarType::where('status', true)->pluck('name', 'slug');
    }

    public function increaseCars() {
        $this->noOfCars++;
    }

    public function decreaseCars() {
        $this->noOfCars > 0 ? $this->noOfCars-- : 0;
    }

    public function toggle($type, $checked) {
        if($checked === true) {
            array_push($this->selectedCarTypes, $type);
        } else {
            $key = array_search($type, $this->selectedCarTypes);
            if($key !== false) {
                unset($this->selectedCarTypes[$key]);
            }
        }
    }

    public function next() {
        session()->put('no_of_cars', $this->noOfCars);
        session()->put('car_type', $this->selectedCarTypes);

        $this->dispatch('close-modal', id: "add-car-type-modal");

        Notification::make()->title('Car types and number added successfully.')->success()->send();
    }
}
