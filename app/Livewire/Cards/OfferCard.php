<?php

namespace App\Livewire\Cards;

use App\Models\OfferLike;
use Livewire\Component;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class OfferCard extends Component
{
    public $item;
    public $offer_days;
    public $likes;
    public $like_status = false;
    public $slug;

    public function mount() {
        $this->likes = OfferLike::where('offer_id', $this->item->id)->count();
        $this->slug = Str::slug($this->item->title).'-'.$this->item->id;

        if (auth()->guard('client')->check()) {
            $client = auth()->guard('client')->user();

            if (OfferLike::where('offer_id', $this->item->id)->where('client_id', $client->id)->first()) {
                $this->like_status = true;
            }
            else {
                $this->like_status = false;
            }
        }

        if (isset($this->item->valid_till)) {
            $currentDate = Carbon::now();
            $validTill = Carbon::parse($this->item->valid_till);
            $this->offer_days = $validTill->diffInDays($currentDate);
        }
        else {
            $this->offer_days = '-';
        }
    }

    public function addLikes() {
        if (auth()->guard('client')->check()) {
            $client = auth()->guard('client')->user();

            if ($this->like_status) {
                Notification::make()->title(__('Already liked package.'))->info()->send();
            }
            else {
                OfferLike::create([
                    'offer_id' => $this->item->id,
                    'client_id' => $client->id,
                ]);
                Notification::make()->title(__('Package liked successfully.'))->success()->send();
            }
        }
        else {
            Notification::make()->title(__('Required you to login first.'))->info()->send();
        }
    }

    public function render()
    {
        return view('livewire.cards.offer-card');
    }
}
