<?php

namespace App\Livewire\Visa;

use App\Models\PassportType as ModelsPassportType;
use Filament\Notifications\Notification;
use Livewire\Component;

class PassportType extends Component
{
    public $passport_types;
    public $selected_type_id;
    public $selected_type;

    public function render()
    {
        return view('livewire.visa.passport-type');
    }

    public function mount() {
        $this->passport_types = ModelsPassportType::where('status', true)->pluck('name', 'id');
    }

    public function type($id, $type) {
        $this->selected_type_id = $id;
        $this->selected_type = $type;
    }

    public function next() {
        session()->put('selected_passport_type', $this->selected_type);
        session()->put('selected_passport_type_id', $this->selected_type_id);

        $this->dispatch('passport-type-selected');

        $this->dispatch('close-modal', id: "add-passport-type-modal");

        Notification::make()->title('Number of visits added successfully.')->success()->send();
    }
}
