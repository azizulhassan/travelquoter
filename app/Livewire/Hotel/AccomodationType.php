<?php

namespace App\Livewire\Hotel;

use App\Models\AccommodationType;
use Filament\Notifications\Notification;
use Livewire\Component;

class AccomodationType extends Component
{
    public $types;
    public $selectedTypes = [];

    public function render()
    {
        return view('livewire.hotel.accomodation-type');
    }

    public function mount() {
        $this->types = AccommodationType::where('status', true)->pluck('name', 'name');
    }

    public function toggle($type, $checked) {
        if($checked === true) {
            array_push($this->selectedTypes, $type);
        } else {
            $key = array_search($type, $this->selectedTypes);
            if($key !== false) {
                unset($this->selectedTypes[$key]);
            }
        }
    }

    public function next() {
        session()->put('accommodation_types', $this->selectedTypes);

        $this->dispatch('update-accommodation-types');
        $this->dispatch('close-modal', id: "add-accomodation-type-modal");

        Notification::make()->title('Accommodation types added successfully.')->success()->send();
    }
}
