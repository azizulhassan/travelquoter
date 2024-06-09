<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Quote;
use App\Models\User;

class QuoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quote::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'mobile_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'email' => $this->faker->safeEmail(),
            'budget' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'receive_quote_via_call' => $this->faker->boolean(),
            'receive_quote_via_email' => $this->faker->boolean(),
            'receive_quote_via_sms' => $this->faker->boolean(),
            'suitable_time' => '{}',
            'comment' => $this->faker->text(),
            'status' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'reason' => $this->faker->text(),
            'extra_field' => '{}',
            'agent_id' => Agent::factory(),
            'user_id' => User::factory(),
        ];
    }
}
