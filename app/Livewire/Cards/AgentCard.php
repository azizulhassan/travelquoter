<?php

namespace App\Livewire\Cards;

use Livewire\Component;

class AgentCard extends Component
{
    public $item;
    public $reviews;
    public $rating;
    public $totalQuote;

    public function mount() {
        $reviewArr = $this->item->agent->reviews;
        $rating = $reviewArr->sum('rating');
        $this->reviews = count($reviewArr);
        $this->totalQuote = $this->item->agent->quotes->count();

        if ($rating > 0) {
            $this->rating = $rating / $this->reviews;
        }
    }
    
    public function render()
    {
        return view('livewire.cards.agent-card');
    }
}
