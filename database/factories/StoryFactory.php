<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Story;
use App\Models\User;

class StoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Story::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'agent_id' => Agent::factory(),
            'client_id' => Client::factory(),
            'category' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'content' => $this->faker->paragraphs(3, true),
            'image' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'video' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
