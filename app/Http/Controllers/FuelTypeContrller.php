<?php

namespace App\Http\Controllers;

use App\Models\FuelType;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuelTypeContrller extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $fuelTypes = FuelType::paginate(10);

            if ($fuelTypes->count() > 0) {
                return $this->apiResponse(true, 200, 'Fuel types fetched successfuly.', $fuelTypes);
            } else {
                return $this->apiResponse(false, 404, 'No fuel types found.');
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

            $fuelType = FuelType::create([
                'type' => $request->type,
            ]);

            if ($fuelType) {
                return $this->apiResponse(true, 201, 'Fuel type created successfully.', $fuelType);
            } else {
                return $this->apiResponse(false, 400, 'Update fuel type faild.');
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
            $fuelType = FuelType::find($id);

            if ($fuelType) {
                return $this->apiResponse(true, 200, 'Fuel type fetched successfully.', $fuelType);
            } else {
                return $this->apiResponse(false, 404, 'Fuel type not found.');
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

            $fuelType = FuelType::find($id);

            if ($fuelType) {
                $fuelType->update(['type' => $request->type]);

                $fuelType->save();

                return $this->apiResponse(true, 200, 'Fuel type updated successfuly.', $fuelType);
            } else {
                return $this->apiResponse(false, 400, 'Update fuel type faild.');
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
            $fuelType = FuelType::find($id);

            if (!$fuelType) {
                return $this->apiResponse(false, 404, 'Fuel type not found.');
            } else {
                FuelType::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Fuel type deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
