<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgencyController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $agencies = Agency::paginate(10);

            if ($agencies->count() > 0) {
                return $this->apiResponse(true, 200, 'Agencies fetched successfuly.', $agencies);
            } else {
                return $this->apiResponse(false, 404, 'No agencies found.');
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
        //'name', 'address', 'thumb_image', 'description', 'note', 'user_id'
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'thumb_image' => 'required',
                'description' => 'required',
                'note' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $agency = Agency::create([
                'name' => $request->name,
                'address' => $request->address,
                'thumb_image' => $request->thumb_image,
                'description' => $request->description,
                'note' => $request->note,
                'user_id' => auth()->id(),
            ]);

            if ($agency) {
                // Upload image...

                return $this->apiResponse(true, 201, 'Agency created successfully.', $agency);
            } else {
                return $this->apiResponse(false, 400, 'Create agency faild.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $agency = Agency::find($id);

            if ($agency) {
                return $this->apiResponse(true, 200, 'Agency fetched successfully.', $agency);
            } else {
                return $this->apiResponse(false, 404, 'Agency not found.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                // 'thumb_image' => 'required',
                'description' => 'required',
                'note' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $agency = Agency::find($id);

            if ($agency) {
                $agency->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    // 'thumb_image' => $request->thumb_image,
                    'description' => $request->description,
                    'note' => $request->note,
                ]);

                $agency->save();

                return $this->apiResponse(true, 200, 'Agency updated successfuly.', $agency);
            } else {
                return $this->apiResponse(false, 400, 'Update agency faild.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $agency = Agency::find($id);

            if (!$agency) {
                return $this->apiResponse(false, 404, 'Agency not found.');
            } else {
                Agency::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Agency deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
