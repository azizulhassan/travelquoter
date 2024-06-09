<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Insurance;
use App\Models\User;

class InsuranceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insurance::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'countries' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'departure_date' => $this->faker->date(),
            'arrival_date' => $this->faker->date(),
            'no_of_travelers' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'age_of_travelers' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'options' => '{}',
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
