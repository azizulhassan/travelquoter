<?php

namespace App\Livewire\Cruise;

use App\Models\CruiseAdditionalInfo;
use Filament\Notifications\Notification;
use Livewire\Component;

class AdditionalInfo extends Component
{
    public $additionalInfo;
    public $selectedInfo = [];

    public function render()
    {
        return view('livewire.cruise.additional-info');
    }

    public function mount() {
        $this->additionalInfo = CruiseAdditionalInfo::where('status', true)->pluck('name', 'name');
    }

    public function toggle($info, $checked) {
        if($checked === true) {
            array_push($this->selectedInfo, $info);
        } else {
            $key = array_search($info, $this->selectedInfo);
            if($key !== false) {
                unset($this->selectedInfo[$key]);
            }
        }
    }

    public function next() {
        session()->put('additional_info', $this->selectedInfo);

        $this->dispatch('close-modal', id: "cruise-additional-info");

        Notification::make()->title('Additional information added successfully.')->success()->send();
    }
}
