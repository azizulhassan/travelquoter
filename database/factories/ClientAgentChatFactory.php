<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Client;
use App\Models\ClientAgentChat;

class ClientAgentChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientAgentChat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'agent_id' => Agent::factory(),
            'attachment' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'image' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'message' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'is_seen' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}
