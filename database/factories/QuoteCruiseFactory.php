<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Cruise;
use App\Models\Quote;
use App\Models\QuoteCruise;

class QuoteCruiseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuoteCruise::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quote_id' => Quote::factory(),
            'cruise_id' => Cruise::factory(),
        ];
    }
}
