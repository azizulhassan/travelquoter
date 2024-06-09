<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Cruise;
use App\Models\User;

class CruiseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cruise::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'departure_port' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'destination' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'length_of_cruise' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'any_month_from' => $this->faker->dateTime(),
            'any_month_to' => $this->faker->dateTime(),
            'no_of_travelers' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'additional_info' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'options' => '{}',
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
