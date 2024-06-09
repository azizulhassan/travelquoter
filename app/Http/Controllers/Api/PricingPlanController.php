<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    public function index()
    {
        return response([
            'pricing_plans' => PricingPlan::where('status', true)->orderBy('created_at', 'DESC')->get()
        ], 200);
    }
}
