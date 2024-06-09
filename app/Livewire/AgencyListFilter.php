<?php

namespace App\Livewire;

use App\Models\Agency;
use Livewire\Component;

class AgencyListFilter extends Component
{
    public $search;

    public function render()
    {
        return view('livewire.agency-list-filter', [
            'agencies' => Agency::where('status', true)->orderBy('created_at', 'DESC')->where('agency_name', 'like', '%'.$this->search.'%')->get(),
        ]);
    }
}
