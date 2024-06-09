<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function index()
    {
        return response([
            'countries' => Country::where('status', true)->orderBy('name', 'ASC')->get()
        ], 200);
    }

    public function show($id)
    {
        $country = Country::find($id);

        if ($country) {
            return response([
                'country' => $country
            ], 200);
        }

        return response([
            'exception' => 'Country not found'
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string:255',
            'slug' => 'required|unique:countries,slug|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $country = Country::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => true
        ]);

        return response([
            'country' => $country
        ], 200);
    }

    public function search(Request $request)
    {
        $query = Country::query();

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
            'name' => 'nullable|string:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }
        $country = Country::find($id);


        if ($country) {
            if ($request->name) {
                $country->name = $request->name;
            }
            $country->save();

            return response([
                'country' => $country
            ], 200);
        }

        return response([
            'exception' => 'Country not found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = Country::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        return response([
            'exception' => 'Country not found'
        ], 404);
    }
}
