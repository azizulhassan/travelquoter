<?php

namespace App\Livewire\Forms;

use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class MultiCityFlightForm extends Component
{
    public $multicity_flight_numbers = [1,2];

    #[On('refreshComponent')]
    public function mount() {
        if (session()->has('multicity_flight_numbers')) {
            $this->multicity_flight_numbers = session()->get('multicity_flight_numbers');
        }
    }

    public function addDestination() {
        $last_id = end($this->multicity_flight_numbers);
        array_push($this->multicity_flight_numbers, (int) $last_id + 1);

        session()->put(['multicity_flight_numbers' => $this->multicity_flight_numbers]);
    }

    public function remove($key) {
        unset($this->multicity_flight_numbers[$key]);
        session()->put(['multicity_flight_numbers' => $this->multicity_flight_numbers]);
        $this->dispatch('refreshComponent');
    }

    public function resetForm() {}

    public function next() {
        session(['step-1-multicity-flight' => []]);
        Notification::make()->title('Choose agents you would like to send quote.')->info()->send();
        return $this->redirect(route('flight.step-2'), false);
    }

    public function render()
    {
        return view('livewire.forms.multi-city-flight-form');
    }
}
