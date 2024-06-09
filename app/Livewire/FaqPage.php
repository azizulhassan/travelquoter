<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faq;

class FaqPage extends Component
{
    public $account_type = 'Traveller';
    public $page;

    public function changeAccountType($value) {
        $this->account_type = $value;
    }

    public function render()
    {
        return view('livewire.faq-page', [
            'data' => Faq::where('status', true)
            ->where('account_type', $this->account_type)
            ->groupBy('category')
            ->selectRaw('category, COUNT(*) as total_faqs')
            ->get()
        ]);
    }
}
