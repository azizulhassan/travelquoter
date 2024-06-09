<?php

namespace App\Livewire\Cards;

use Livewire\Component;

class BlogCard extends Component
{
    public $item;
    
    public function render()
    {
        return view('livewire.cards.blog-card');
    }
}
