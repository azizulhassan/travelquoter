<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function famousPlaces() {
        $home = Page::where('title', 'Home')->first();
        if (isset($home->page_content['famous_place_section'])) {
            return response([
                'data' => $home->page_content['famous_place_section']
            ], 200);
        }
        else {
            return response([
                'exception' => 'Famouse place data not found'
            ], 404);
        }
    }
}
