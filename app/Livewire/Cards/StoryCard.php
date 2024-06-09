<?php

namespace App\Livewire\Cards;

use Livewire\Component;

class StoryCard extends Component
{
    public $story;
    
    public function render()
    {
        return view('livewire.cards.story-card');
    }
}
