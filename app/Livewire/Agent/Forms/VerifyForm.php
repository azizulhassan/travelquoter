<?php

namespace App\Livewire\Agent\Forms;

use App\Mail\AgentVerificationMail;
use App\Mail\ClientVerificationMail;
use App\Models\Agent;
use App\Models\Client;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyForm extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data;

    public function mount() {
        if (!Auth::guard('agent')->check()) {
            return $this->redirect(route('filament.agent.auth.login'));
        }
    }

    public function form(Form $form): Form {
        return $form->schema([
            Forms\Components\TextInput::make('verification_code')->numeric()->required()
        ])->statePath('data');
    }

    public function authenticate() {
        $data = $this->form->getState();
        $agent = Auth::guard('agent')->user();
        
        $agent = Agent::findorFail($agent->id);

        if ($data["verification_code"] == $agent->verification_code) {
            $agent->verification_code = NULL;
            $agent->verification_code = Carbon::now();
            $agent->save();

            return $this->redirect(route('filament.agent.pages.dashboard'));
        }
        else {
            Notification::make()->title('Verification code is not correct.')->danger()->send();
        }
    }

    public function logout() {
        Auth::guard('agent')->logout();
        return $this->redirect(route('filament.agent.auth.login'));
    }

    public function resendVerificationMail() {
        $agent = Auth::guard('client')->user();
        $agent = Agent::findorFail($agent->id);

        $agent->verification_code = rand(1000, 9999);

        Mail::to($agent->email)->send(new AgentVerificationMail($agent));

        Notification::make()->title('Email sent successfully.')->success()->send();
    }

    public function render()
    {
        return view('livewire.agent.forms.verify-form');
    }
}
