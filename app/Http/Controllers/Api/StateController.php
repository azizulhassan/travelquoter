<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        return response([
            'states' => State::where('status', true)->orderBy('name', 'ASC')->get()
        ], 200);
    }

    public function show($id)
    {
        $state = State::find($id);
        if ($state) {
            return response([
                'state' => $state
            ], 200);
        }
        return response([
            'exception' => 'State not found'
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',
            'name' => 'required|string:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $checkCountry = Country::find($request->country_id);

        if (!$checkCountry) {
            return response([
                'errors' => [
                    'country' => 'Country id not found'
                ]
            ], 404);
        }

        $state = State::create([
            'country_id' => $request->country_id,
            'name' => $request->name,
            'status' => true
        ]);

        return response([
            'state' => $state
        ], 200);
    }

    public function search(Request $request)
    {
        $query = State::query();

        if ($request->search) {
            $query = $query->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $request->search . '%');
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'nullable|integer',
            'name' => 'nullable|string:255',
            'slug' => 'nullable|unique:countries,slug|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $state = State::find($id);

        if ($state) {

            if ($request->country_id) {
                $state->country_id = $request->country_id;
            }

            if ($request->name) {
                $state->name = $request->name;
            }

            if ($request->slug) {
                $state->slug = $request->slug;
            }

            $state->save();

            return response([
                'state' => $state
            ], 200);
        }
        return response([
            'exception' => 'State not found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = State::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        
        return response([
            'exeception' => 'State not found'
        ], 404);
    }
}
