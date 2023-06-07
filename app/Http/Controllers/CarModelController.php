<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarModelController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $carModels = CarModel::paginate(10);

            if ($carModels->count() > 0) {
                return $this->apiResponse(true, 200, 'Car models fetched successfuly.', $carModels);
            } else {
                return $this->apiResponse(false, 404, 'No car models found.');
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
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $carModel = CarModel::create([
                'name' => $request->name,
            ]);

            if ($carModel) {
                return $this->apiResponse(true, 201, 'Car model created successfully.', $carModel);
            } else {
                return $this->apiResponse(false, 400, 'Update car model faild.');
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
            $carModel = CarModel::find($id);

            if ($carModel) {
                return $this->apiResponse(true, 200, 'Car model fetched successfully.', $carModel);
            } else {
                return $this->apiResponse(false, 404, 'Car model not found.');
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
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $carModel = CarModel::find($id);

            if ($carModel) {
                $carModel->update(['name' => $request->name]);

                $carModel->save();

                return $this->apiResponse(true, 200, 'Car model updated successfuly.', $carModel);
            } else {
                return $this->apiResponse(false, 400, 'Update car model faild.');
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
            $carModel = CarModel::find($id);

            if (!$carModel) {
                return $this->apiResponse(false, 404, 'Car model not found.');
            } else {
                CarModel::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Car model deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
