<?php

namespace App\Livewire\Agent\Forms;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Forms;

class LoginForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        if (Auth::guard('agent')->check()) {
            redirect()->route('filament.agent.pages.dashboard');
        }

        $this->form->fill();
    }

    public function authenticate()
    {
        $this->validate([
            'data.email' => 'required|email',
            'data.password' => 'required|min:6',
        ]);

        if (Auth::guard('agent')->attempt(['email' => $this->data['email'], 'password' => $this->data['password']])) {
            return redirect()->route('filament.agent.pages.dashboard');
        }

        session()->flash('error', 'The provided credentials do not match our records.');
    }
    
    public function form(Form $form): Form {
        return $form->schema([
            Forms\Components\TextInput::make('email')->placeholder(__('Enter email'))->email()->required()->columnSpanFull()->translateLabel(),
            Forms\Components\TextInput::make('password')->placeholder(__('Enter password'))->password()->required()->columnSpanFull()->translateLabel()
        ])->statePath('data');
    }

    public function socialMedia($type) {
        return $this->redirect(route('filament.agent.auth.login'));
    }


    public function render()
    {
        return view('livewire.agent.forms.login-form');
    }
}
