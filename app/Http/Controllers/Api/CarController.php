<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index()
    {
        return response([
            'cars' => Car::where('status', true)->get()
        ], 200);
    }

    public function show($id)
    {
        $car = Car::find($id);
        if ($car) {
            return response([
                'car' => $car
            ], 200);
        }
        return response([
            'exception' => 'Car not found'
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'nullable|integer|exists:clients,id',
            'car_type' => 'nullable|string|max:255',
            'pick_up_location' => 'nullable|string|max:255',
            'drop_off_location' => 'nullable|string|max:255',
            'pick_up_datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'drop_off_datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'no_of_travelers' => 'nullable|string|max:255',
            'no_of_cars' => 'nullable|string|max:255',
            'options' => 'nullable|array',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $car = Car::create($request->all());

        return response([
            'car' => $car
        ], 200);
    }


    public function carAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|integer|exists:cars,id',
            'agents' => 'required|array',
            'agents.*' => 'integer|exists:agents,id'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if (count($request->agents) > 0) {
            foreach ($request->agents as $agent_id) {
                CarAgent::create([
                    'car_id' => $request->car_id,
                    'agent_id' => $agent_id
                ]);
            }
        }

        return response([
            'message' => 'Data saved successfully'
        ], 200);
    }


    public function search(Request $request)
    {
        $query = Car::query();

        if ($request->search) {
            $query = $query->where('id', $request->id);
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
            'client_id' => 'nullable|integer|exists:clients,id',
            'car_type' => 'nullable|string|max:255',
            'pick_up_location' => 'nullable|string|max:255',
            'drop_off_location' => 'nullable|string|max:255',
            'pick_up_datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'drop_off_datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'no_of_travelers' => 'nullable|string|max:255',
            'no_of_cars' => 'nullable|string|max:255',
            'options' => 'nullable|array',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $car = Car::find($id);

        if (!$car) {
            return response([
                'exception' => 'Car not found'
            ], 404);
        }

        $car = $car->update($request->all());

        return response([
            'car' => $car
        ], 200);
    }


    public function destroy($id)
    {
        $data = Car::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }

        return response([
            'exeception' => 'Car not found'
        ], 404);
    }
}
