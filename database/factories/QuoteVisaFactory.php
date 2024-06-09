<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Quote;
use App\Models\QuoteVisa;
use App\Models\Visa;

class QuoteVisaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuoteVisa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quote_id' => Quote::factory(),
            'visa_id' => Visa::factory(),
        ];
    }
}
