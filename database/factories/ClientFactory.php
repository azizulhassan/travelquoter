<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Country;
use App\Models\State;
use App\Models\User;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cover' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'profile_picture' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'country_id' => Country::factory(),
            'state_id' => State::factory(),
            'street_address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'postcode' => $this->faker->postcode(),
            'name' => $this->faker->name(),
            'contact_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'password' => $this->faker->password(),
            'email' => $this->faker->safeEmail(),
            'token' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'verification_code' => $this->faker->word(),
            'email_verified_at' => $this->faker->dateTime(),
            'status' => $this->faker->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
