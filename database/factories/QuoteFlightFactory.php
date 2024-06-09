<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Flight;
use App\Models\Quote;
use App\Models\QuoteFlight;

class QuoteFlightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuoteFlight::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quote_id' => Quote::factory(),
            'flight_id' => Flight::factory(),
        ];
    }
}
