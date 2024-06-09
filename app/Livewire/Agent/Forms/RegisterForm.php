<?php

namespace App\Livewire\Agent\Forms;

use App\Mail\AgentVerificationMail;
use App\Models\Agent;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class RegisterForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data;

    public function mount(): void
    {
        if (Auth::guard('agent')->check()) {
            redirect()->route('filament.agent.pages.dashboard');
        }

        $this->form->fill();
    }

    public function form (Form $form): Form {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label(__('Full Name'))->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->unique(ignoreRecord:true)->translateLabel()->required()->maxLength(255),
            Forms\Components\TextInput::make('password')->maxLength(255)->password()->required(),
            Forms\Components\Checkbox::make('terms_and_conditions')->label(function () {
                return new HtmlString(__('I accept Audit\'s Terms\'s of Service & Privacy Policy.'));
            })->required(),
        ])->statePath('data');
    }

    public function authenticate() {
        $data = $this->form->getState();
        $data["password"] = Hash::make($data["password"]);
        $data["status"] = true;
        $data["verification_code"] = rand(1000, 9999);

        $agent = Agent::create($data);

        Mail::to($agent->email)->send(new AgentVerificationMail($agent));
        
        Notification::make()->title('Registered Successfully.')->success()->send();
        return $this->redirect(route('filament.agent.auth.login'));
    }

    public function socialMedia($type) {
        return $this->redirect(route('filament.client.auth.register'));
    }

    public function render()
    {
        return view('livewire.agent.forms.register-form');
    }
}
