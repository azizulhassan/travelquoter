<?php

namespace App\Livewire;

use App\Forms\Components\GoogleMapPlaceSearch;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;

class TestingOutSearchApi extends Component implements HasForms
{
    use InteractsWithForms;

    public function form(Form $form): Form {
        return $form->schema([
            GoogleMapPlaceSearch::make('location'),
        ]);
    }

    public function submit() {
        $data = $this->form->getState();
        dd($data);
    }

    public function render()
    {
        return view('livewire.testing-out-search-api');
    }
}
