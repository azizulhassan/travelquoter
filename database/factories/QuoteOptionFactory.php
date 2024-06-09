<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Option;
use App\Models\Quote;
use App\Models\QuoteOption;

class QuoteOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuoteOption::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quote_id' => Quote::factory(),
            'option_id' => Option::factory(),
        ];
    }
}
