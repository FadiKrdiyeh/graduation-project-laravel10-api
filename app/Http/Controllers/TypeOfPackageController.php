<?php

namespace App\Http\Controllers;

use App\Models\TypeOfPackage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeOfPackageController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $typeOfPackages = TypeOfPackage::paginate(10);

            if ($typeOfPackages->count() > 0) {
                return $this->apiResponse(true, 200, 'Type of packages fetched successfuly.', $typeOfPackages);
            } else {
                return $this->apiResponse(false, 404, 'No type of packages found.');
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

            $typeOfPackage = TypeOfPackage::create([
                'name' => $request->name,
            ]);

            if ($typeOfPackage) {
                return $this->apiResponse(true, 201, 'Type of package created successfully.', $typeOfPackage);
            } else {
                return $this->apiResponse(false, 400, 'Update type of package faild.');
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
            $typeOfPackage = TypeOfPackage::find($id);

            if ($typeOfPackage) {
                return $this->apiResponse(true, 200, 'Type of package fetched successfully.', $typeOfPackage);
            } else {
                return $this->apiResponse(false, 404, 'Type of package not found.');
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

            $typeOfPackage = TypeOfPackage::find($id);

            if ($typeOfPackage) {
                $typeOfPackage->update(['name' => $request->name]);

                $typeOfPackage->save();

                return $this->apiResponse(true, 200, 'Type of package updated successfuly.', $typeOfPackage);
            } else {
                return $this->apiResponse(false, 400, 'Update type of package faild.');
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
            $typeOfPackage = TypeOfPackage::find($id);

            if (!$typeOfPackage) {
                return $this->apiResponse(false, 404, 'Type of package not found.');
            } else {
                TypeOfPackage::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Type of package deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
