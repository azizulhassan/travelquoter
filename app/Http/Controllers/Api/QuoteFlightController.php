<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Quote;
use App\Models\QuoteFlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteFlightController extends Controller
{
    public function index()
    {
        return response([
            'quote_flights' => QuoteFlight::where('status', true)->orderBy('created_at', 'DESC')->get()
        ], 200);
    }

    public function show($id)
    {
        $quote_flight = QuoteFlight::find($id);
        if ($quote_flight) {
            return response([
                'quote_flight' => $quote_flight
            ], 200);
        }
        return response([
            'exception' => 'Quote flight not found'
        ], 404);
    }

    public function search(Request $request)
    {
        $query = QuoteFlight::query();

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
            'flight_id' => 'required|integer',
            'quote_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->flight_id) {
            $checkFlight = Flight::find($request->flight_id);
    
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

        $quote_flight = QuoteFlight::create([
            'quote_id' => $request->quote_id,
            'flight_id' => $request->flight_id
        ]);

        return response([
            'quote_flight' => $quote_flight
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'flight_id' => 'nullable|integer',
            'quote_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $quote_flight = QuoteFlight::find($id);

        if ($request->flight_id) {
            $checkFlight = Flight::find($request->flight_id);
    
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

        if ($quote_flight) {
            $quote_flight->quote_id = isset($request->quote_id) ? $request->quote_id : $quote_flight->quote_id ;
            $quote_flight->flight_id = isset($request->flight_id) ? $request->flight_id : $quote_flight->flight_id ;
            $quote_flight->save();

            return response([
                'quote_flight' => $quote_flight
            ], 200);
        }
        return response([
            'exception' => 'Quote Flight not found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = QuoteFlight::find($id);

        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        
        return response([
            'exeception' => 'Quote Flight not found'
        ], 404);
    }
}
