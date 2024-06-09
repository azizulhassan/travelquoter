<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NewsResource;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        return response([
            'news' => NewsResource::collection(News::where('status', true)->orderBy('title', 'ASC')->paginate(20)),
        ], 200);
    }

    public function show($id)
    {
        $news = News::find($id);
        if ($news) {
            return response([
                'news' => new NewsResource($news),
            ], 200);
        }
        return response([
            'exception' => 'News not found'
        ], 404);
    }

    public function search(Request $request)
    {
        $query = News::query();

        if ($request->search) {
            $query = $query->where('title', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $category_id = $request->category_id;
            $query = $query->whereHash('newsCategories', function ($query) use ($category_id) {
                $query->where('id', $category_id);
            });
        }

        if ($request->sorting) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('created_at', 'ASC')->paginate(12);
            } else {
                $query = $query->orderBy('created_at', 'ASC')->paginate(12);
            }
        } else {
            $query = $query->orderBy('created_at', 'DESC')->paginate(12);
        }

        return response([
            'data' => NewsResource::collection($query)
        ], 200);
    }

    public function featured() {
        return response([
            'news' => NewsResource::collection(News::where('status', true)->where('is_featured', true)->orderBy('title', 'ASC')->limit(20)->get()),
        ], 200);
    }
}
