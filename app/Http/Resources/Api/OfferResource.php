<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        if (isset($this->valid_till)) {
            $currentDate = Carbon::now();
            $validTill = Carbon::parse($this->valid_till);
            
            $offer_days = $validTill->diffInDays($currentDate);
        }
        else {
            $offer_days = null;
        }

        return [
            'user_id' => $this->user_id,
            'agent_id' => $this->agent_id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'person' => $this->person,
            'category' => $this->category,
            'previous_price' => $this->previous_price,
            'current_price' => $this->current_price,
            'is_featured' => true,
            'valid_from' => isset($this->valid_from) ? Carbon::parse($this->valid_from)->format('d M Y')  : '',
            'valid_till' => isset($this->valid_till) ? Carbon::parse($this->valid_till)->format('d M Y')  : '',
            'offer_days' => $offer_days,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'location' => $this->location,
            'extra_field' => $this->extra_field,
            'likes' => rand(20, 500),
            'status' => $this->status
        ];
    }
}