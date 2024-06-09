<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Hotel;
use App\Models\User;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'desired_city' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'check_in' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'check_out' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'trip_days' => $this->faker->word(),
            'no_of_travelers' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'accommodation_type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'room' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'rating' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'other' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'options' => '{}',
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
