<?php

namespace App\Livewire\Cruise;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class AddTravelers extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public $adults = 0;
    public $children = 0;
    public $infants = 0;

    public function render()
    {
        return view('livewire.cruise.add-travelers');
    }

    public function mount() {
        if(session()->has('no_of_travelers')) {
            $no_of_travelers = session()->get('no_of_travelers');
            
            $this->children = $no_of_travelers['children'];
            $this->infants = $no_of_travelers['infants'];
            $this->adults = $no_of_travelers['adults'];
        }
    }

    public function getTotalTravelersProperty()
    {
        return $this->adults + $this->children + $this->infants;
    }

    public function incrementChildren() {
        $this->children++;
    }

    public function decrementChildren() {
        $this->children > 0 ? $this->children-- : 0;
    }

    public function incrementInfants() {
        $this->infants++;
    }

    public function decrementInfants() {
        $this->infants > 0 ? $this->infants-- : 0;
    }

    public function incrementAdults() {
        $this->adults++;
    }

    public function decrementAdults() {
        $this->adults > 0 ? $this->adults-- : 0;
    }

    public function next()
    {
        session(['no_of_travelers' => [
            'children' => $this->children,
            'infants'  => $this->infants,
            'adults'   => $this->adults,
        ]]);

        $this->dispatch('close-modal', id: "add-travelers-modal");

        Notification::make()->title('No. and age of travelers added successfully.')->success()->send();
    }
}