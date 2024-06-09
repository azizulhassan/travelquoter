<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Insurance;
use App\Models\InsuranceAgent;

class InsuranceAgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InsuranceAgent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'insurance_id' => Insurance::factory(),
            'agent_id' => Agent::factory(),
        ];
    }
}
