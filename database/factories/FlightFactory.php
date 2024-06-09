<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Airline;
use App\Models\Client;
use App\Models\Flight;
use App\Models\FlightClass;
use App\Models\User;

class FlightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Flight::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'flight_type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'from' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'to' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'departure_date' => $this->faker->date(),
            'returning_date' => $this->faker->date(),
            'trip_days' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'no_of_passenger' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'flight_class_id' => FlightClass::factory(),
            'is_flexible_date' => $this->faker->boolean(),
            'flexible_date' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'is_visa' => $this->faker->boolean(),
            'airline_id' => Airline::factory(),
            'is_insurance' => $this->faker->boolean(),
            'options' => '{}',
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
