<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class ChatCard extends Component
{
    public $type = 1;
    public $image;
    public $name;
    public $time;
    public $message;
    public $media;

    public function render()
    {
        return view('livewire.chat.chat-card');
    }
}
