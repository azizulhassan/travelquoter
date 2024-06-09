<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\BookmarkNews;
use App\Models\Client;
use App\Models\News;

class BookmarkNewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookmarkNews::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),
            'client_id' => Client::factory(),
            'news_id' => News::factory(),
        ];
    }
}
