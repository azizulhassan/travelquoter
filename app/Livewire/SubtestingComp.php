<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;

class SubtestingComp extends Component implements HasForms
{
    use InteractsWithForms;

    public $id;
    public $name;
    public $address;

    public function form(Form $form):Form {
        return $form->schema([
            Forms\Components\TextInput::make('name'),
            Forms\Components\TextInput::make('address'),
        ]);
    }
    
    public function render()
    {
        return view('livewire.subtesting-comp');
    }
}
