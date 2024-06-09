<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Gtrip;
use App\Models\GtripMember;

class GtripMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GtripMember::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'gtrip_id' => Gtrip::factory(),
            'client_id' => Client::factory(),
            'extra_field' => '{}',
            'status' => $this->faker->boolean(),
        ];
    }
}
