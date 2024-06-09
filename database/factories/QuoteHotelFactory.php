<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Hotel;
use App\Models\Quote;
use App\Models\QuoteHotel;

class QuoteHotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuoteHotel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quote_id' => Quote::factory(),
            'hotel_id' => Hotel::factory(),
        ];
    }
}
