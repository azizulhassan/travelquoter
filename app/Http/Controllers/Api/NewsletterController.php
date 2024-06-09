<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function index()
    {
        return response([
            'newsletters' => Newsletter::where('status', true)->orderBy('email', 'ASC')->get()
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:newsletters,email|max:255',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $newsletter = Newsletter::create([
            'email' => $request->email,
            'status' => true
        ]);

        return response([
            'newsletter' => $newsletter
        ], 200);
    }

    public function search(Request $request)
    {
        $query = Newsletter::query();

        if ($request->search) {
            $query = $query->where('email', 'like', '%' . $request->search . '%');
        }

        if ($request->sorting) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('email', 'ASC')->get();
            } else {
                $query = $query->orderBy('email', 'ASC')->get();
            }
        } else {
            $query = $query->orderBy('email', 'DESC')->get();
        }

        return response([
            'search' => $query
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $newsletter = Newsletter::find($id);


        if ($newsletter) {
            if ($request->status) {
                $newsletter->status = $request->status;
            }
            $newsletter->save();

            return response([
                'newsletter' => $newsletter
            ], 200);
        }

        return response([
            'exception' => 'Newsletter not found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = Newsletter::find($id);

        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        
        return response([
            'exception' => 'Newsletter not found'
        ], 404);
    }
}
