<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\AgentReview;
use App\Models\Client;

class AgentReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentReview::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),
            'client_id' => Client::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'rating' => $this->faker->word(),
            'review' => $this->faker->text(),
            'status' => $this->faker->boolean(),
        ];
    }
}
