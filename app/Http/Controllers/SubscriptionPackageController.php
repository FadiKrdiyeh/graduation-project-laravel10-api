<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionPackageController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subscriptionPackages = SubscriptionPackage::paginate(10);

            if ($subscriptionPackages->count() > 0) {
                return $this->apiResponse(true, 200, 'Subscription packages fetched successfuly.', $subscriptionPackages);
            } else {
                return $this->apiResponse(false, 404, 'No subscriptionPackages found.');
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
        // 'name', 'cost', 'duration', 'payment_method_id'
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'cost' => 'required',
                'duration' => 'required',
                'payment_method_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $subscriptionPackage = SubscriptionPackage::create([
                'name' => $request->name,
                'cost' => $request->cost,
                'duration' => $request->duration,
                'payment_method_id' => $request->payment_method_id,
            ]);

            if ($subscriptionPackage) {
                return $this->apiResponse(true, 201, 'Subscription package created successfully.', $subscriptionPackage);
            } else {
                return $this->apiResponse(false, 400, 'Create subscription package faild.');
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
            $subscriptionPackage = SubscriptionPackage::find($id);

            if ($subscriptionPackage) {
                return $this->apiResponse(true, 200, 'Subscription package fetched successfuly.', $subscriptionPackage);
            } else {
                return $this->apiResponse(false, 404, 'Subscription package not found.');
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
                'cost' => 'required',
                'duration' => 'required',
                'payment_method_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $subscriptionPackage = SubscriptionPackage::find($id);

            if ($subscriptionPackage) {
                $subscriptionPackage->update([
                    'name' => $request->name,
                    'cost' => $request->cost,
                    'duration' => $request->duration,
                    'payment_method_id' => $request->payment_method_id,
                ]);

                $subscriptionPackage->save();

                return $this->apiResponse(true, 200, 'Subscription package updated successfuly.', $subscriptionPackage);
            } else {
                return $this->apiResponse(false, 400, 'Update subscription package faild.');
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
            $subscriptionPackage = SubscriptionPackage::find($id);

            if (!$subscriptionPackage) {
                return $this->apiResponse(false, 404, 'Subscription package not found.');
            } else {
                SubscriptionPackage::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Subscription package deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
