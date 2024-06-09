<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Gtrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SharedPackageController extends Controller
{
    public function index()
    {
        return response([
            'shared_packages' => Gtrip::where('status', true)->orderBy('created_at', 'ASC')->get()
        ], 200);
    }

    public function show($id)
    {
        $state = Gtrip::find($id);
        if ($state) {
            return response([
                'shared_package' => $state
            ], 200);
        }
        return response([
            'exception' => 'Shared package not found'
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'extra_field' => 'required|array',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $shared_package = Gtrip::create($request->all());

        return response([
            'shared_package' => $shared_package
        ], 200);
    }

    public function search(Request $request)
    {
        $query = Gtrip::query();

        if ($request->search) {
            $query = $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->sorting) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('created_at', 'ASC')->get();
            } else {
                $query = $query->orderBy('created_at', 'ASC')->get();
            }
        } else {
            $query = $query->orderBy('created_at', 'DESC')->get();
        }

        return response([
            'search' => $query
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'extra_field' => 'required|array',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $shared_package = Gtrip::find($id);

        if ($shared_package) {

            $shared_package = $shared_package->update($request->all());

            return response([
                'shared_package' => $shared_package
            ], 200);
        }
        return response([
            'exception' => 'shared package not found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = Gtrip::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        
        return response([
            'exeception' => 'Shared package not found'
        ], 404);
    }
}
