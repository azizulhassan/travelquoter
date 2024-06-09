<?php

namespace App\Livewire;

use Livewire\Attributes\Js;
use Livewire\Attributes\On;
use Livewire\Component;

class WorkingWithTestComponent extends Component
{
    public $data = [];

    public function remove($key) {
        unset($this->data[$key]);
    }

    public function mount() {
        $this->data = [0,1,2];
    }

    public function addDestination() {
        array_push($this->data, end($this->data) + 1);
    }

    public function render()
    {
        return view('livewire.working-with-test-component');
    }
}
