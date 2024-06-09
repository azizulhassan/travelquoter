<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index() {
        $states = State::with('country')->get();

        $locations = $states->map(function ($item) {
            return [
                'name' => $item->name,
                'country' => [
                    'name' => $item->country->name,
                ]
            ];
        })->toArray();
        
        return response([
            'locations' => $locations
        ], 200);
    }

    public function search(Request $request) {
        $searchTerm = $request->search;

        $states = State::with('country')->where('name', 'like', '%' . $searchTerm . '%')->whereHas('country', function ($query) use ($searchTerm) {
            return $query->where('name', 'like', '%'. $searchTerm .'%');
        })->get();

        $locations = $states->map(function ($item) {
            return [
                'name' => $item->name,
                'country' => [
                    'name' => $item->country->name,
                ]
            ];
        })->toArray();

        return response([
            'locations' => $locations
        ], 200);
    }
}
