<?php

namespace App\Livewire;

use App\Models\Agency;
use App\Models\Story;
use App\Models\SubscribeAgent;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class AlertPage extends Component
{
    #[Url(except:'', keep:true)]
    public $type = 'all-alerts';

    #[Url(except:'', keep:true)]
    public $search = '';

    public function swapAlertType($type) {
        $this->type = $type;
    }
    
    public function favourate() {}

    public function subscribeToggle($agent_id, $client_id) {
        if (auth()->guard('client')->check()) {
            $subscribeAgent = SubscribeAgent::where('client_id', $client_id)->where('agent_id', $agent_id)->first();
            if ($subscribeAgent) {
                $subscribeAgent->delete();
                Notification::make()->title(__('You have unsubscribed.'))->success()->send();
            }
            else {
                SubscribeAgent::create([
                    'client_id' => $client_id,
                    'agent_id' => $agent_id,
                ]);
                Notification::make()->title(__('You have subscribed.'))->success()->send();
            }
        }
        else {
            Notification::make()->title(__('Login to your account first.'))->info()->send();
        }
    }

    #[On('refresh-alert-page')]
    public function render()
    {
        $stories = Story::where('status', true);
        if ($this->search) {
            $stories = $stories->where('content', 'like', '%'. $this->search .'%');
        }
        if ($this->type) {
            if ($this->type != 'all-alerts') {
                $stories = $stories->where('category', $this->type);
            }
        }
        $stories = $stories->orderBy('created_at', 'DESC')->get();
        Story::where('status', true)->orderBy('created_at', 'DESC')->get();

        return view('livewire.alert-page', [
            'agencies' => Agency::where('status', true)->orderBy('created_at', 'DESC')->limit(3)->get(),
            'stories' => $stories,
        ]);
    }
}
