<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\Visa;
use App\Models\VisaAgent;

class VisaAgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VisaAgent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'visa_id' => Visa::factory(),
            'agent_id' => Agent::factory(),
        ];
    }
}
