<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Story;
use App\Models\StoryComment;

class StoryCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoryComment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'story_id' => Story::factory(),
            'agent_id' => Agent::factory(),
            'client_id' => Client::factory(),
            'comment' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
