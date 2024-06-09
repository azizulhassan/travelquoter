<?php

namespace App\Livewire\Gtrip;

use App\Models\Gtrip;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class Step1Form extends Component
{
    public $name;
    public $icon;
    public $email;
    public $emails = [];

    public function mount()
    {
        if (session()->has('gtrip_invite_emails')) {
            $this->emails = session()->get('gtrip_invite_emails');
        }
    }

    public function toggleAdmin($key, $value) {
        $emails = $this->emails;

        $emails[$key] = [
            "email" => $emails[$key]["email"],
            "role" => $value
        ];

        session()->put(['gtrip_invite_emails' => $emails]);

        $this->mount();
    }

    public function addEmail()
    {
        if (session()->has('gtrip_invite_emails')) {
            $this->emails = session()->get('gtrip_invite_emails');
        }

        array_push($this->emails, [
            'email' => $this->email,
            'role' => ''
        ]);

        session()->put(['gtrip_invite_emails' => $this->emails]);

        $this->email = NULL;

        Notification::make()->title(__('Email added to invite list'))->success()->send();
    }

    public function remove($id)
    {
        if (session()->has('gtrip_invite_emails')) {
            $this->emails = session()->get('gtrip_invite_emails');
            unset($this->emails[$id]);
            session()->put(['gtrip_invite_emails' => $this->emails]);
        }
    }

    public function share()
    {
        Notification::make()->title('Link copied successfully.')->info()->send();

        $this->js(<<<JS
            navigator.clipboard.writeText(window.location.href);
        JS);
    }

    public function createRoom()
    {
        $this->validate([
            'emails' => 'required',
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $gtrip = Gtrip::create([
            'icon' => $this->icon,
            'title' => $this->name,
            'extra_field' => [
                'invited_emails' => $this->emails,
            ],
            'client_id' => Auth::guard('client')->user()->id,
            'status' => true
        ]);

        Notification::make()->title(__('New room created successfully'))->success()->send();

        return $this->redirect(route('gtrip.step-2', ['trip' => Str::slug($gtrip->title).'-'.$gtrip->id]));
    }

    public function render()
    {
        return view('livewire.gtrip.step1-form');
    }
}
