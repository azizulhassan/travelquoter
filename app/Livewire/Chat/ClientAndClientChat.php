<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class ClientAndClientChat extends Component
{
    public $icon;
    
    public function render()
    {
        return view('livewire.chat.client-and-client-chat');
    }
}
