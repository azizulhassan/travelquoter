<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\SubscribeAgent;
use Filament\Notifications\Notification;
use Filament\Support\Assets\Js;

class SubscriberCard extends Component
{
    public $item;
    public $has_subscribed = false;
    public $client;

    public function mount() {
        if (auth()->guard('client')->check()) {
            $this->client = auth()->guard('client')->user();
            
            if (SubscribeAgent::where('client_id', $this->client->id)->where('agent_id', $this->item->agent->id)->first()) {
                $this->has_subscribed = true;
            }
            else {
                $this->has_subscribed = false;
            }
        }
    }

    public function subscribeToggle() {
        if (auth()->guard('client')->check()) {
            $subscribeAgent = SubscribeAgent::where('client_id', $this->client->id)->where('agent_id', $this->item->agent->id)->first();
            if ($subscribeAgent) {
                $subscribeAgent->delete();
                Notification::make()->title(__('You have unsubscribed.'))->success()->send();
                $this->has_subscribed = false;
            }
            else {
                SubscribeAgent::create([
                    'client_id' => $this->client->id,
                    'agent_id' => $this->item->agent->id,
                ]);
                Notification::make()->title(__('You have subscribed.'))->success()->send();
                $this->has_subscribed = true;
            }
        }
        else {
            Notification::make()->title(__('Login to your account first.'))->info()->send();
        }
        
        $this->dispatch('refresh-alert-page');
    }
    
    public function render()
    {
        return view('livewire.cards.subscriber-card');
    }
}
