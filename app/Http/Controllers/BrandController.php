<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $brands = Brand::paginate(10);

            if ($brands->count() > 0) {
                return $this->apiResponse(true, 200, 'Brands fetched successfuly.', $brands);
            } else {
                return $this->apiResponse(false, 404, 'No brands found.');
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

            $brand = Brand::create([
                'name' => $request->name,
            ]);

            if ($brand) {
                return $this->apiResponse(true, 201, 'Brand created successfully.', $brand);
            } else {
                return $this->apiResponse(false, 400, 'Update brand faild.');
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
            $brand = Brand::find($id);

            if ($brand) {
                return $this->apiResponse(true, 200, 'Brand fetched successfully.', $brand);
            } else {
                return $this->apiResponse(false, 404, 'Brand not found.');
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

            $brand = Brand::find($id);

            if ($brand) {
                $brand->update(['name' => $request->name]);

                $brand->save();

                return $this->apiResponse(true, 200, 'Brand updated successfuly.', $brand);
            } else {
                return $this->apiResponse(false, 400, 'Update brand faild.');
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
            $brand = Brand::find($id);

            if (!$brand) {
                return $this->apiResponse(false, 404, 'Brand not found.');
            } else {
                Brand::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Brand deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
