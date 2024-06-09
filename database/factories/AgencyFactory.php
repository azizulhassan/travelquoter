<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\Country;
use App\Models\State;

class AgencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agency::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),
            'agency_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'mobile_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'abn_acn' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'website_url' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'do_you_operate_outside_australia' => $this->faker->boolean(),
            'do_you_operate_through_your_website' => $this->faker->boolean(),
            'business_description' => $this->faker->text(),
            'country_id' => Country::factory(),
            'state_id' => State::factory(),
            'services' => '{}',
            'street_address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'postcode' => $this->faker->postcode(),
            'status' => $this->faker->boolean(),
        ];
    }
}
