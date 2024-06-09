<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\QuoteResource;
use App\Models\Quote;
use App\Models\QuoteAgent;
use App\Models\QuoteCar;
use App\Models\QuoteCruise;
use App\Models\QuoteFlight;
use App\Models\QuoteHotel;
use App\Models\QuoteInsurance;
use App\Models\QuoteOffer;
use App\Models\QuoteOption;
use App\Models\QuoteVisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DateTime;

class QuoteController extends Controller {

    public function index() {
        return response([
            'quotes' => Quote::where('status', true)->orderBy('created_at', 'DESC')->get()
                ], 200);
    }

    public function latestQuotes() {
        return response([
            'quotes' => Quote::where('status', true)->orderBy('created_at', 'DESC')->limit(5)->get()
                ], 200);
    }

    public function show($id) {
        $quote = Quote::find($id);
        $quote = DB::table('quotes')->select([
                    'id',
                    'full_name',
                    'mobile_number',
                    'email',
                    'budget',
                    'receive_quote_via_call',
                    'receive_quote_via_email',
                    'receive_quote_via_sms',
                    'suitable_time',
                    'comment',
                    'status',
                    'reason',
                    'file',
                    'extra_field',
                    'agent_id',
                    'user_id',
                    'created_at',
                    'updated_at'
                ])->where('id', $id)->first();
        if ($quote) {
            return response([
                'quote' => new QuoteResource($quote)
                    ], 200);
        }
        return response([
            'exception' => 'Quote not found'
                ], 404);
    }

    public function search(Request $request) {
        $query = Quote::query();

        if ($request->search) {
            $query = $query->where('full_name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->orWhere('mobile_number', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query = $query->whereJsonContains('extra_field->status', $request->status);
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

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'offer_id' => 'nullable|integer|exists:offers,id',
                    'hotel_id' => 'nullable|integer|exists:hotels,id',
                    'car_id' => 'nullable|integer|exists:cars,id',
                    'flight_id' => 'nullable|integer|exists:flights,id',
                    'cruise_id' => 'nullable|integer|exists:cruises,id',
                    'insurance_id' => 'nullable|integer|exists:insurances,id',
                    'option_id' => 'nullable|integer|exists:options,id',
                    'visa_id' => 'nullable|integer|exists:visas,id',
                    'full_name' => 'required|string|max:255',
                    'mobile_number' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'budget' => 'required|string|max:255',
                    'receive_quote_via_call' => 'required|boolean',
                    'receive_quote_via_email' => 'required|boolean',
                    'suitable_time' => 'required|array',
                    'comment' => 'required|string|max:1000',
                    'car_id' => 'nullable|integer',
                    'cruise_id' => 'nullable|integer',
                    'flight_id' => 'nullable|integer',
                    'hotel_id' => 'nullable|integer',
                    'insurance_id' => 'nullable|integer',
                    'option_id' => 'nullable|integer',
                    'visa_id' => 'nullable|integer',
                    'agent_id' => 'nullable|integer',
                    'status' => 'required',
                    'multiple_agents' => 'required|array',
                    'multiple_agents.*' => 'required|integer|exists:agents,id'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }
        $filename = NULL;
        if ($request->hasFile('file')) {
            $validator = Validator::make($request->all(), [
                        'file' => 'mimes:pdf|max:2048', // Maximum file size is 2MB
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('quotes', $filename);
        }

        $quote = Quote::create([
                    'full_name' => $request->full_name,
                    'mobile_number' => $request->mobile_number,
                    'email' => $request->email,
                    'budget' => $request->budget,
                    'receive_quote_via_call' => $request->receive_quote_via_call,
                    'receive_quote_via_email' => $request->receive_quote_via_email,
                    'suitable_time' => $request->suitable_time,
                    'comment' => $request->comment,
                    'extra_field' => [
                        'status' => $request->status,
                    ],
                    'agent_id' => $request->agent_id,
                    'file' => $filename,
                    'status' => true
        ]);

        // Saving QuoteCar, QuoteCruise, QuoteFlight, QuoteHotel, QuoteInsurance, QuoteOption, QuoteVisa, Offer

        if (count($request->multiple_agents) > 0) {
            foreach ($request->multiple_agents as $item) {
                QuoteAgent::create([
                    'quote_id' => $quote->id,
                    'agent_id' => $item,
                ]);
            }
        }


        if ($request->has('offer_id')) {
            QuoteOffer::create([
                'quote_id' => $quote->id,
                'offer_id' => $request->offer_id
            ]);
        }

        if ($request->has('hotel_id')) {
            QuoteHotel::create([
                'quote_id' => $quote->id,
                'hotel_id' => $request->hotel_id
            ]);
        }

        if ($request->has('car_id')) {
            QuoteCar::create([
                'quote_id' => $quote->id,
                'car_id' => $request->car_id
            ]);
        }

        if ($request->has('flight_id')) {
            QuoteFlight::create([
                'quote_id' => $quote->id,
                'flight_id' => $request->flight_id
            ]);
        }

        if ($request->has('cruise_id')) {
            QuoteCruise::create([
                'quote_id' => $quote->id,
                'cruise_id' => $request->cruise_id
            ]);
        }

        if ($request->has('insurance_id')) {
            QuoteInsurance::create([
                'quote_id' => $quote->id,
                'insurance_id' => $request->insurance_id
            ]);
        }

        if ($request->has('option_id')) {
            QuoteOption::create([
                'quote_id' => $quote->id,
                'option_id' => $request->option_id
            ]);
        }

        if ($request->has('visa_id')) {
            QuoteVisa::create([
                'quote_id' => $quote->id,
                'visa_id' => $request->visa_id
            ]);
        }

        if ($request->has('multiple_agents')) {
            QuoteAgent::create([
                'quote_id' => $quote->id,
                'agent'
            ]);
        }


        return response([
            'quote' => new QuoteResource($quote)
                ], 200);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'full_name' => 'nullable|string|max:255',
                    'mobile_number' => 'nullable|string|max:255',
                    'email' => 'nullable|email|max:255',
                    'budget' => 'nullable|string|max:255',
                    'receive_quote_via_call' => 'nullable|boolean',
                    'receive_quote_via_email' => 'nullable|boolean',
                    'suitable_time' => 'nullable|array|max:255',
                    'comment' => 'nullable|string|max:1000',
                    'car_id' => 'nullable|integer',
                    'cruise_id' => 'nullable|integer',
                    'flight_id' => 'nullable|integer',
                    'hotel_id' => 'nullable|integer',
                    'insurance_id' => 'nullable|integer',
                    'option_id' => 'nullable|integer',
                    'visa_id' => 'nullable|integer',
                    'status' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }
        $filename = NULL;

        if ($request->hasFile('file')) {
            $validator = Validator::make($request->all(), [
                        'file' => 'mimes:pdf|max:2048', // Maximum file size is 2MB
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('quotes', $filename);
        }

        $quote = Quote::find($id);

        if ($quote) {
            $quote->full_name = isset($request->full_name) ? $request->full_name : $quote->full_name;
            $quote->mobile_number = isset($request->mobile_number) ? $request->mobile_number : $quote->mobile_number;
            $quote->email = isset($request->email) ? $request->email : $quote->email;
            $quote->budget = isset($request->budget) ? $request->budget : $quote->budget;
            $quote->receive_quote_via_call = isset($request->receive_quote_via_call) ? $request->receive_quote_via_call : $quote->receive_quote_via_call;
            $quote->receive_quote_via_email = isset($request->receive_quote_via_email) ? $request->receive_quote_via_email : $quote->receive_quote_via_email;
            $quote->suitable_time = isset($request->suitable_time) ? $request->suitable_time : $quote->suitable_time;
            $quote->comment = isset($request->comment) ? $request->comment : $quote->comment;
            $quote->agent_id = isset($request->agent_id) ? $request->agent_id : $quote->agent_id;
            $quote->file = !empty($filename) ? $filename : $quote->file;

            if ($request->has('status')) {
                $quote->extra_field = [
                    'status' => $request->status
                ];
            }

            $quote->save();

            if ($request->offer_id) {
                $checkQuoteOffer = QuoteOffer::where('quote_id', $quote->id)->where('offer_id', $request->offer_id)->first();
                if ($checkQuoteOffer) {
                    $checkQuoteOffer->offer_id = isset($request->offer_id) ? $request->offer_id : $checkQuoteOffer->offer_id;
                    $checkQuoteOffer->save();
                }
            }

            if ($request->hotel_id) {
                $checkQuoteHotel = QuoteHotel::where('quote_id', $quote->id)->where('hotel_id', $request->hotel_id)->first();
                if ($checkQuoteHotel) {
                    $checkQuoteHotel->hotel_id = isset($request->hotel_id) ? $request->hotel_id : $checkQuoteHotel->hotel_id;
                    $checkQuoteHotel->save();
                }
            }

            if ($request->car_id) {
                $checkQuoteCar = QuoteCar::where('quote_id', $quote->id)->where('car_id', $request->car_id)->first();
                if ($checkQuoteCar) {
                    $checkQuoteCar->car_id = isset($request->car_id) ? $request->car_id : $checkQuoteCar->car_id;
                    $checkQuoteCar->save();
                }
            }

            if ($request->flight_id) {
                $checkQuoteFlight = QuoteCar::where('quote_id', $quote->id)->where('flight_id', $request->flight_id)->first();
                if ($checkQuoteFlight) {
                    $checkQuoteFlight->flight_id = isset($request->flight_id) ? $request->flight_id : $checkQuoteFlight->flight_id;
                    $checkQuoteFlight->save();
                }
            }

            if ($request->cruise_id) {
                $checkQuoteCruise = QuoteCruise::where('quote_id', $quote->id)->where('cruise_id', $request->cruise_id)->first();
                if ($checkQuoteCruise) {
                    $checkQuoteCruise->cruise_id = isset($request->cruise_id) ? $request->cruise_id : $checkQuoteCruise->cruise_id;
                    $checkQuoteCruise->save();
                }
            }


            if ($request->insurance_id) {
                $checkQuoteInsurance = QuoteInsurance::where('quote_id', $quote->id)->where('insurance_id', $request->insurance_id)->first();
                if ($checkQuoteInsurance) {
                    $checkQuoteInsurance->insurance_id = isset($request->insurance_id) ? $request->insurance_id : $checkQuoteInsurance->insurance_id;
                    $checkQuoteInsurance->save();
                }
            }


            if ($request->option_id) {
                $checkQuoteOption = QuoteOption::where('quote_id', $quote->id)->where('option_id', $request->option_id)->first();
                if ($checkQuoteOption) {
                    $checkQuoteOption->option_id = isset($request->option_id) ? $request->option_id : $checkQuoteOption->option_id;
                    $checkQuoteOption->save();
                }
            }

            if ($request->visa_id) {
                $checkQuoteVisa = QuoteVisa::where('quote_id', $quote->id)->where('visa_id', $request->option_id)->first();
                if ($checkQuoteVisa) {
                    $checkQuoteVisa->visa_id = isset($request->visa_id) ? $request->visa_id : $checkQuoteVisa->visa_id;
                    $checkQuoteVisa->save();
                }
            }

            return response([
                'quote' => $quote
                    ], 200);
        }


        return response([
            'exception' => 'Quote not found'
                ], 404);
    }

    public function destroy($id) {
        $data = Quote::find($id);

        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
                    ], 200);
        }

        return response([
            'exeception' => 'Quote not found'
                ], 404);
    }
}
