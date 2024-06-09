<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\Client;
use App\Models\User;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'car_type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'pick_up_location' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'drop_off_location' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'pick_up_datetime' => $this->faker->dateTime(),
            'drop_off_datetime' => $this->faker->dateTime(),
            'no_of_travelers' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'no_of_cars' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'options' => '{}',
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
