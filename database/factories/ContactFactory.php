<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\User;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'enquiry_type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'full_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'mobile_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'email' => $this->faker->safeEmail(),
            'message' => $this->faker->text(),
            'status' => $this->faker->word(),
            'reason' => $this->faker->text(),
            'user_id' => User::factory(),
        ];
    }
}
