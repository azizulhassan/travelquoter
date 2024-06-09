<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Faq;
use App\Models\User;

class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'account_type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'question' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'answer' => $this->faker->text(),
            'status' => $this->faker->boolean(),
            'user_id' => User::factory(),
            'agent_id' => Agent::factory(),
        ];
    }
}
