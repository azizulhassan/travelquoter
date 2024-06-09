<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Story;
use App\Models\StoryTag;
use App\Models\StoryTagStory;

class StoryTagStoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoryTagStory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'story_tag_id' => StoryTag::factory(),
            'story_id' => Story::factory(),
        ];
    }
}
