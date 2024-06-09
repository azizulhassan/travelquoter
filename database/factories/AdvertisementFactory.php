<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Advertisement;

class AdvertisementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Advertisement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'section' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'order' => $this->faker->word(),
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'banner' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'alt' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'quick_preview' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'status' => $this->faker->boolean(),
        ];
    }
}
