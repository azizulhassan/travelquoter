<?php

namespace App\Livewire;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;

class BlogPage extends Component
{
    public $search;
    public $category = [];

    public function refresh() {
        $this->search = NULL;
        $this->category = [];
    }

    public function querySearch() {
        return [
            'search',
            'category'
        ];
    }

    public function render()
    {
        $data = News::where('status', true)->where('title', 'like', '%'. $this->search .'%');

        if (count($this->category) > 0) {
            $category = $this->category;

            $data = $data->whereHas('newsCategories', function (Builder $query) use ($category) {
                $query->whereIn('news_category_id', $category);
            });
        }

        $data = $data->orderBy('created_at', 'DESC')->get();

        return view('livewire.blog-page', [
            'featured_articles' => News::where('status', true)->where('is_featured', true)->orderBy('created_at', 'DESC')->limit(3)->get(),
            'trending' => News::where('status', true)->where('is_featured', true)->orderBy('created_at', 'DESC')->skip(3)->limit(8)->get(),
            'categories' => NewsCategory::where('status', true)->orderBy('created_at', 'DESC')->get(),
            'data' => $data
        ]);
    }
}
