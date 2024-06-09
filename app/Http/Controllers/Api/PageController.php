<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return response([
            'pages' => PageResource::collection(Page::where('status', true)->get())
        ], 200);
    }

    public function show($id)
    {
        $page = Page::find($id);

        if ($page) {
            return response([
                'page' => new PageResource($page)
            ], 200);
        }
        return response([
            'exception' => 'Page not found'
        ], 404);
    }
}
