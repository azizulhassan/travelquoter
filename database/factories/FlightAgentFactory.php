<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Flight;
use App\Models\FlightAgent;

class FlightAgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FlightAgent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'flight_id' => Flight::factory(),
            'agent_id' => Agent::factory(),
        ];
    }
}
