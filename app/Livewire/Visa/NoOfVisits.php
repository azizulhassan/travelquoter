<?php

namespace App\Livewire\Visa;

use Filament\Notifications\Notification;
use Livewire\Component;

class NoOfVisits extends Component
{
    public $no_of_visits = [
        'single' => 'Single',
        'multiple' => 'Multiple'
    ];

    public $selected_no;

    public function render()
    {
        return view('livewire.visa.no-of-visits');
    }

    public function mount() {
        if(session()->has('selected_no')) {
            $this->selected_no = session()->get('selected_no');
        }
    }

    public function selectNumber($number) {
        $this->selected_no = $number;
    }

    public function next() {
        session()->put('selected_no', $this->selected_no);

        $this->dispatch('number-selected', session('selected_no'));

        $this->dispatch('close-modal', id: "add-no-of-visit-modal");

        Notification::make()->title('Number of visits added successfully.')->success()->send();
    }
}
