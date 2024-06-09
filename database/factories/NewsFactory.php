<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\News;
use App\Models\User;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(),
            'thumbnail' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'short_description' => $this->faker->text(),
            'description' => $this->faker->text(),
            'is_featured' => $this->faker->boolean(),
            'featured_video' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'written_by' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'status' => $this->faker->boolean(),
        ];
    }
}
