<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Cruise;
use App\Models\CruiseAgent;

class CruiseAgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CruiseAgent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cruise_id' => Cruise::factory(),
            'agent_id' => Agent::factory(),
        ];
    }
}
