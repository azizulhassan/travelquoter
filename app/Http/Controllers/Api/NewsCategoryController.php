<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public function index()
    {
        return response([
            'news_categories' => NewsCategory::where('status', true)->orderBy('order', 'ASC')->get()
        ], 200);
    }
}
