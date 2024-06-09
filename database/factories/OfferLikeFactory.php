<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Offer;
use App\Models\OfferLike;

class OfferLikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OfferLike::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'offer_id' => Offer::factory(),
            'client_id' => Client::factory(),
            'agent_id' => Agent::factory(),
        ];
    }
}
