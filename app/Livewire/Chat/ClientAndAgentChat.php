<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class ClientAndAgentChat extends Component
{
    public $icon;
    
    public function render()
    {
        return view('livewire.chat.client-and-agent-chat');
    }
}
