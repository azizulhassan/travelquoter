<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AdvertiseWithUs;
use App\Models\User;

class AdvertiseWithUsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvertiseWithUs::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'mobile_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'email' => $this->faker->safeEmail(),
            'company_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'message' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'status' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'reason' => $this->faker->text(),
            'user_id' => User::factory(),
        ];
    }
}
