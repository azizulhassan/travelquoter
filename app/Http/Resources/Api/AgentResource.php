<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        if ($this->cover) {
            if (str_contains($this->cover, 'https://')) {
                $cover = $this->cover;
            } else {
                $cover = env('APP_URL') . '/uploads/' . $this->cover;
            }
        } else {
            $cover = NULL;
        }

        if ($this->profile_picture) {
            if (str_contains($this->profile_picture, 'https://')) {
                $profile_picture = $this->profile_picture;
            } else {
                $profile_picture = env('APP_URL') . '/uploads/' . $this->profile_picture;
            }
        } else {
            $profile_picture = NULL;
        }

        return [
            'id' => $this->id,
            'cover' => $cover,
            'profile_picture' => $profile_picture,
            'profession' => $this->profession,
            'name' => $this->name,
            'agent_consultant' => $this->name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'total_received_quotes' => 0,
            'total_actioned_quotes' => 0,
            'quotes' => $this->quotes,
            
            // Agency Part
            'agency_id' => $this->agency->id ?? NULL,
            'agency_name' => $this->agency->agency_name ?? NULL,
            'mobile_number' => $this->agency->mobile_number ?? NULL,
            'abn_acn' => $this->agency->abn_acn ?? NULL,
            'website_url' => $this->agency->website_url ?? NULL,
            'do_you_operate_outside_australia' => $this->agency->do_you_operate_outside_australia ?? NULL,
            'do_you_sale_through_your_website' => $this->agency->do_you_sale_through_your_website ?? NULL,
            'business_description' => $this->agency->business_description ?? NULL,
            'country_id' => $this->agency->country_id ?? NULL,
            'country' => $this->agency->country->name ?? NULL,
            'state_id' => $this->agency->state_id ?? NULL,
            'state' => $this->agency->state->name ?? NULL,
            'services' => $this->agency->services ?? NULL,
            'street_address' => $this->agency->street_address ?? NULL,
            'postcode' => $this->agency->postcode ?? NULL,
            'token' => $this->token,
            'total_earning' => 0,
            'earnings_this_month' => 0,
            
            'created_at' => $this->created_at,
        ];
    }
}
