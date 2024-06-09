<?php

namespace App\Livewire\Client;

use Livewire\Attributes\Url;
use Livewire\Component;

class DashboardPage extends Component
{
    #[Url(except:'', keep:true)]
    public $tab = 'my-information';

    public function changeTab($value) {
        $this->tab = $value;
    }

    public function render()
    {
        return view('livewire.client.dashboard-page');
    }
}
