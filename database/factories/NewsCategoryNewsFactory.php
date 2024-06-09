<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsCategoryNews;

class NewsCategoryNewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsCategoryNews::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'news_id' => News::factory(),
            'news_category_id' => NewsCategory::factory(),
        ];
    }
}
