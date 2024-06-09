<?php

namespace App\Livewire\Visa;

use App\Models\VisitPurpose as ModelsVisitPurpose;
use Filament\Notifications\Notification;
use Livewire\Component;

class VisitPurpose extends Component
{
    public $purposes;
    public $selected_purpose;
    public $selected_purpose_id;

    public function render()
    {
        return view('livewire.visa.visit-purpose');
    }

    public function mount() {
        $this->purposes = ModelsVisitPurpose::where('status', true)->pluck('name', 'id');

        if(session()->has('selected_purpose')) {
            $this->selected_purpose = session()->get('selected_purpose');
        }
    }

    public function selectPurpose($id, $purpose) {
        $this->selected_purpose_id = $id;
        $this->selected_purpose = $purpose;
    }

    public function next() {

        session()->put('selected_purpose', $this->selected_purpose);
        session()->put('selected_purpose_id', $this->selected_purpose_id);

        $this->dispatch('purpose-selected', session('selected_purpose_id'), session('selected_purpose'));
        $this->dispatch('close-modal', id: "add-purpose-of-visit-modal");

        Notification::make()->title('Purpose of visit added successfully.')->success()->send();
    }
}
