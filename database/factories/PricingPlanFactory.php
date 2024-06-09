<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PricingPlan;
use App\Models\User;

class PricingPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PricingPlan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'order' => $this->faker->word(),
            'pricing_type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'icon' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'short_description' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'perks' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
