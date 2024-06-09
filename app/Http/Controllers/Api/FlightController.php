<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\FlightAgent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        return response([
            'flights' => Flight::where('status', true)->get()
        ], 200);
    }

    public function show($id)
    {
        $flight = Flight::find($id);
        if ($flight) {
            return response([
                'flight' => $flight
            ], 200);
        }
        return response([
            'exception' => 'Flight not found'
        ], 404);
    }

    public function flightAgent(Request $request) {
        $validator = Validator::make($request->all(), [
            'flight_id' => 'required|integer|exists:flights,id',
            'agents' => 'required|array',
            'agents.*' => 'integer|exists:agents,id'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if (count($request->agents) > 0) {
            foreach($request->agents as $agent_id) {
                FlightAgent::create([
                    'flight_id' => $request->flight_id,
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
        $query = Flight::query();

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "flight_type" => "nullable|string|max:255",
            "from" => "nullable|string|max:255",
            "to" => "nullable|string|max:255",
            "departure_date" => "nullable|date",
            "returning_date" => "nullable|date",
            "trip_days" => "nullable|string|max:255",
            "no_of_passenger" => "nullable|string|max:255",
            "flight_class_id" => "nullable|integer|exists:flight_classes,id",
            "is_flexible_date" => "nullable|boolean",
            "flexible_date" => "nullable|string|max:255",
            "is_visa" => "nullable|boolean",
            "airline_id" => "nullable|integer|exists:airlines,id",
            "is_insurance" => "nullable|boolean",
            "options" => "nullable|array",
            "extra_field" => "nullable|array",
            "status" => "required|boolean"
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $flight = Flight::create($request->all());

        return response([
            'flight' => $flight
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "flight_type" => "nullable|string|max:255",
            "from" => "nullable|string|max:255",
            "to" => "nullable|string|max:255",
            "departure_date" => "nullable|date",
            "returning_date" => "nullable|date",
            "trip_days" => "nullable|string|max:255",
            "no_of_passenger" => "nullable|string|max:255",
            "flight_class_id" => "nullable|integer|exists:flight_classes,id",
            "is_flexible_date" => "nullable|boolean",
            "flexible_date" => "nullable|string|max:255",
            "is_visa" => "nullable|boolean",
            "airline_id" => "nullable|integer|exists:airlines,id",
            "is_insurance" => "nullable|boolean",
            "options" => "nullable|array",
            "extra_field" => "nullable|array",
            "status" => "required|boolean"
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $flight = Flight::find($id);

        if (!$flight) {
            return response([
                'exception' => 'Flight not found'
            ], 404);
        }

        $flight->update($request->all());

        return response([
            'flight' => $flight
        ], 200);
    }

    public function destroy($id)
    {
        $data = Flight::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }

        return response([
            'exeception' => 'Flight not found'
        ], 404);
    }
}
