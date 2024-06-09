<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Quote;
use App\Models\QuoteCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteCarController extends Controller
{
    public function index()
    {
        return response([
            'quote_cars' => QuoteCar::where('status', true)->orderBy('created_at', 'DESC')->get()
        ], 200);
    }

    public function show($id)
    {
        $quote_car = QuoteCar::find($id);
        if ($quote_car) {
            return response([
                'quote_car' => $quote_car
            ], 200);
        }
        return response([
            'exception' => 'Quote car not found'
        ], 404);
    }

    public function search(Request $request)
    {
        $query = QuoteCar::query();

        if ($request->search) {
            $query = $query->where('id', $request->search);
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|integer',
            'quote_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->car_id) {
            $checkFlight = Flight::find($request->car_id);
    
            if (!$checkFlight) {
                return response([
                    'flight' => 'Flight id not found'
                ], 404);
            }
        }

        if ($request->quote_id) {
            $checkQuote = Quote::find($request->quote_id);
    
            if (!$checkQuote) {
                return response([
                    'quote' => 'Quote id not found'
                ], 404);
            }
        }

        $quote_car = QuoteCar::create([
            'quote_id' => $request->quote_id,
            'car_id' => $request->car_id
        ]);

        return response([
            'quote_car' => $quote_car
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'nullable|integer',
            'quote_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $quote_car = QuoteCar::find($id);

        if ($request->car_id) {
            $checkFlight = Flight::find($request->car_id);
    
            if (!$checkFlight) {
                return response([
                    'flight' => 'Flight id not found'
                ], 404);
            }
        }

        if ($request->quote_id) {
            $checkQuote = Quote::find($request->quote_id);
    
            if (!$checkQuote) {
                return response([
                    'quote' => 'Quote id not found'
                ], 404);
            }
        }

        if ($quote_car) {
            $quote_car->quote_id = isset($request->quote_id) ? $request->quote_id : $quote_car->quote_id ;
            $quote_car->car_id = isset($request->car_id) ? $request->car_id : $quote_car->car_id ;
            $quote_car->save();

            return response([
                'quote_car' => $quote_car
            ], 200);
        }
        return response([
            'exception' => 'Quote car not found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = QuoteCar::find($id);

        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        
        return response([
            'exeception' => 'Quote car not found'
        ], 404);
    }
}
