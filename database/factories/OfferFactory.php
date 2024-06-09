<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Offer;
use App\Models\User;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'agent_id' => Agent::factory(),
            'title' => $this->faker->sentence(4),
            'short_description' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'person' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'category' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'is_featured' => $this->faker->boolean(),
            'previous_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'current_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'valid_from' => $this->faker->date(),
            'valid_till' => $this->faker->date(),
            'thumbnail' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'description' => $this->faker->text(),
            'location' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
