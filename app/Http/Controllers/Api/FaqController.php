<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return response([
            'faqs' => Faq::where('status', true)->orderBy('question', 'ASC')->paginate(20),
        ], 200);
    }

    public function show($id)
    {
        $faq = Faq::find($id);
        if ($faq) {
            return response([
                'faq' => $faq,
            ], 200);
        }
        return response([
            'exception' => 'Faq not found'
        ], 404);
    }
}
