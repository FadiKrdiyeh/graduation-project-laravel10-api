<?php

namespace App\Http\Controllers;

use App\Models\Transmission;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransmissionController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transmissions = Transmission::paginate(10);

            if ($transmissions->count() > 0) {
                return $this->apiResponse(true, 200, 'Transmissions fetched successfuly.', $transmissions);
            } else {
                return $this->apiResponse(false, 404, 'No transmissions found.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $transmission = Transmission::create([
                'type' => $request->type,
            ]);

            if ($transmission) {
                return $this->apiResponse(true, 201, 'Transmission created successfully.', $transmission);
            } else {
                return $this->apiResponse(false, 400, 'Update transmission faild.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $transmission = Transmission::find($id);

            if ($transmission) {
                return $this->apiResponse(true, 200, 'Transmission fetched successfully.', $transmission);
            } else {
                return $this->apiResponse(false, 404, 'Transmission not found.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $transmission = Transmission::find($id);

            if ($transmission) {
                $transmission->update(['type' => $request->type]);

                $transmission->save();

                return $this->apiResponse(true, 200, 'Transmission updated successfuly.', $transmission);
            } else {
                return $this->apiResponse(false, 400, 'Update transmission faild.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $transmission = Transmission::find($id);

            if (!$transmission) {
                return $this->apiResponse(false, 404, 'Transmission not found.');
            } else {
                Transmission::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Transmission deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
