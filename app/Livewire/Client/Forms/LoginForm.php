<?php

namespace App\Livewire\Client\Forms;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Form;
use Filament\Forms;

class LoginForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        if (Auth::guard('client')->check()) {
            redirect()->route('filament.client.pages.dashboard');
        }

        $this->form->fill();
    }

    public function form(Form $form): Form {
        return $form->schema([
            Forms\Components\TextInput::make('email')->placeholder(__('Enter email'))->email()->required()->columnSpanFull()->translateLabel(),
            Forms\Components\TextInput::make('password')->placeholder(__('Enter password'))->password()->required()->columnSpanFull()->translateLabel()
        ])->statePath('data');
    }

    public function authenticate() {
        $data = $this->form->getState();
        $data["status"] = true;
        
        if (Auth::guard('client')->attempt($data, true)) {
            return $this->redirect(route('filament.client.pages.dashboard'));
        }
    }

    public function socialMedia($type) {
        return $this->redirect(route('filament.client.auth.login'));
    }

    public function render()
    {
        return view('livewire.client.forms.login-form');
    }
}
