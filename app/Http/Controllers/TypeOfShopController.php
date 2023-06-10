<?php

namespace App\Http\Controllers;

use App\Models\TypeOfShop;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeOfShopController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $typeOfShopes = TypeOfShop::paginate(10);

            if ($typeOfShopes->count() > 0) {
                return $this->apiResponse(true, 200, 'Type of shopes fetched successfuly.', $typeOfShopes);
            } else {
                return $this->apiResponse(false, 404, 'No type of shopes found.');
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

            $typeOfShop = TypeOfShop::create([
                'name' => $request->name,
            ]);

            if ($typeOfShop) {
                return $this->apiResponse(true, 201, 'Type of shop created successfully.', $typeOfShop);
            } else {
                return $this->apiResponse(false, 400, 'Create type of shop faild.');
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
            $typeOfShop = TypeOfShop::find($id);

            if ($typeOfShop) {
                return $this->apiResponse(true, 200, 'Type of shop fetched successfully.', $typeOfShop);
            } else {
                return $this->apiResponse(false, 404, 'Type of shop not found.');
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

            $typeOfShop = TypeOfShop::find($id);

            if ($typeOfShop) {
                $typeOfShop->update(['name' => $request->name]);

                $typeOfShop->save();

                return $this->apiResponse(true, 200, 'Type of shop updated successfuly.', $typeOfShop);
            } else {
                return $this->apiResponse(false, 400, 'Update type of shop faild.');
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
            $typeOfShop = TypeOfShop::find($id);

            if (!$typeOfShop) {
                return $this->apiResponse(false, 404, 'Type of shop not found.');
            } else {
                TypeOfShop::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Type of shop deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
