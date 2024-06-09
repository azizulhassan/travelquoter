<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\PassportType;
use App\Models\User;
use App\Models\Visa;
use App\Models\VisitPurpose;

class VisaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'country_of_passport' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'country_to_visit' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'passport_type_id' => PassportType::factory(),
            'pick_up_date' => $this->faker->date(),
            'drop_off_date' => $this->faker->date(),
            'no_of_travelers' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'visit_purpose_id' => VisitPurpose::factory(),
            'no_of_visit' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'options' => '{}',
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
