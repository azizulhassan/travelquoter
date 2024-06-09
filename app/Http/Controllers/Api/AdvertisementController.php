<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        return response([
            'ads' => Advertisement::where('status', true)->orderBy('name', 'ASC')->paginate(20),
        ], 200);
    }

    public function show($id)
    {
        $ad = Advertisement::find($id);

        if ($ad) {
            return response([
                'ad' => $ad,
            ], 200);
        }

        return response([
            'exception' => 'Ad not found'
        ], 404);
    }

    public function search(Request $request)
    {
        $query = Advertisement::query();

        if ($request->search) {
            $query = $query->where('name', 'like', '%' . $request->search . '%')->orWhere('section', 'like', '%' . $request->search . '%');
        }

        if ($request->sorting) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('name', 'ASC')->get();
            } else {
                $query = $query->orderBy('name', 'ASC')->get();
            }
        } else {
            $query = $query->orderBy('name', 'DESC')->get();
        }

        return response([
            'search' => $query
        ], 200);
    }
}
