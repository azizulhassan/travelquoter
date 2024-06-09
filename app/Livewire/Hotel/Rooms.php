<?php

namespace App\Livewire\Hotel;

use App\Models\BedType;
use Filament\Notifications\Notification;
use Livewire\Component;

class Rooms extends Component
{
    public $rooms = [
        'One' => 1,
        'Two' => 2,
        'Three' => 3,
        'Four' => 4,
        'Other' => 'Other'
    ];

    public $bed_types;

    public $selected_room;
    public $selected_bedtype;

    public function render()
    {
        return view('livewire.hotel.rooms');
    }

    public function mount() {
        $this->bed_types = BedType::where('status', true)->pluck('name', 'slug');

        if(session()->has('selected_room')) {
            $this->selected_room = session()->get('selected_room');
        }

        if(session()->has('selected_bedtype')) {
            $this->selected_bedtype = session()->get('selected_bedtype');
        }
    }

    public function selectRoom($type) {
        $this->selected_room = $type;
    }

    public function selectBedType($type) {
        $this->selected_bedtype = $type;
    }

    public function next()
    {
        session()->put('selected_room', $this->selected_room);
        session()->put('selected_bedtype', $this->selected_bedtype);

        $this->dispatch('rooms-added');
        $this->dispatch('close-modal', id: "add-rooms-modal");

        Notification::make()->title('Rooms added successfully.')->success()->send();
    }
}
