<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkshopController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $workshops = Workshop::paginate(10);

            if ($workshops->count() > 0) {
                return $this->apiResponse(true, 200, 'Workshop fetched successfuly.', $workshops);
            } else {
                return $this->apiResponse(false, 404, 'No workshops found.');
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
                'name' => 'required',
                'address' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'jurisdiction' => 'required',
                'oppening_time' => 'required',
                'closing_time' => 'required',
                'description' => 'required',
                'features' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $workshop = Workshop::create([
                'name' => $request->name,
                'address' => $request->address,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'jurisdiction' => $request->name,
                'oppening_time' => $request->oppening_time,
                'closing_time' => $request->closing_time,
                'description' => $request->description,
                'features' => $request->features,
                'user_id' => auth()->id()
            ]);

            if ($workshop) {
                return $this->apiResponse(true, 201, 'Workshop created successfully.', $workshop);
            } else {
                return $this->apiResponse(false, 400, 'Create workshop faild.');
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
            $workshop = Workshop::find($id);

            if ($workshop) {
                return $this->apiResponse(true, 200, 'Workshop fetched successfully.', $workshop);
            } else {
                return $this->apiResponse(false, 404, 'Workshop not found.');
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
                'name' => 'required',
                'address' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'jurisdiction' => 'required',
                'oppening_time' => 'required',
                'closing_time' => 'required',
                'description' => 'required',
                'features' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $workshop = Workshop::find($id);

            if ($workshop) {
                $workshop->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'jurisdiction' => $request->name,
                    'oppening_time' => $request->oppening_time,
                    'closing_time' => $request->closing_time,
                    'description' => $request->description,
                    'features' => $request->features,
                ]);

                $workshop->save();

                return $this->apiResponse(true, 200, 'Workshop updated successfuly.', $workshop);
            } else {
                return $this->apiResponse(false, 400, 'Update workshop faild.');
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
            $workshop = Workshop::find($id);

            if (!$workshop) {
                return $this->apiResponse(false, 404, 'Workshop not found.');
            } else {
                Workshop::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Workshop deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
