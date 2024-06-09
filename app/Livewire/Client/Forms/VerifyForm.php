<?php

namespace App\Livewire\Client\Forms;

use App\Mail\ClientVerificationMail;
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
        if (!Auth::guard('client')->check()) {
            return $this->redirect(route('filament.client.auth.login'));
        }
    }

    public function form(Form $form): Form {
        return $form->schema([
            Forms\Components\TextInput::make('verification_code')->numeric()->required()
        ])->statePath('data');
    }

    public function authenticate() {
        $data = $this->form->getState();
        $client = Auth::guard('client')->user();
        
        $client = Client::findorFail($client->id);

        if ($data["verification_code"] == $client->verification_code) {
            $client->verification_code = NULL;
            $client->email_verified_at = Carbon::now();
            $client->save();

            return $this->redirect(route('filament.client.pages.dashboard'));
        }
        else {
            Notification::make()->title('Verification code is not correct.')->danger()->send();
        }
    }

    public function logout() {
        Auth::guard('client')->logout();
        return $this->redirect(route('filament.client.auth.login'));
    }

    public function resendVerificationMail() {
        $client = Auth::guard('client')->user();
        $client = Client::findorFail($client->id);

        $client->verification_code = rand(1000, 9999);

        $client->save();

        Mail::to($client->email)->send(new ClientVerificationMail($client));

        Notification::make()->title('Email sent successfully.')->success()->send();
    }

    public function render()
    {
        return view('livewire.client.forms.verify-form');
    }
}
