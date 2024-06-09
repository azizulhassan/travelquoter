<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Gtrip;
use App\Models\User;

class GtripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gtrip::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'icon' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'title' => $this->faker->sentence(4),
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
