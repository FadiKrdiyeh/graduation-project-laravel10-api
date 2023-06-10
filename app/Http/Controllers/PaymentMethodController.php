<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $paymentMethods = PaymentMethod::paginate(10);

            if ($paymentMethods->count() > 0) {
                return $this->apiResponse(true, 200, 'Payment methods fetched successfuly.', $paymentMethods);
            } else {
                return $this->apiResponse(false, 404, 'No payment methods found.');
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

            $paymentMethod = PaymentMethod::create([
                'name' => $request->name,
            ]);

            if ($paymentMethod) {
                return $this->apiResponse(true, 201, 'Payment method created successfully.', $paymentMethod);
            } else {
                return $this->apiResponse(false, 400, 'Create payment method faild.');
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
            $paymentMethod = PaymentMethod::find($id);

            if ($paymentMethod) {
                return $this->apiResponse(true, 200, 'Payment method fetched successfully.', $paymentMethod);
            } else {
                return $this->apiResponse(false, 404, 'Payment method not found.');
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

            $paymentMethod = PaymentMethod::find($id);

            if ($paymentMethod) {
                $paymentMethod->update(['name' => $request->name]);

                $paymentMethod->save();

                return $this->apiResponse(true, 200, 'Payment method updated successfuly.', $paymentMethod);
            } else {
                return $this->apiResponse(false, 400, 'Update payment method faild.');
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
            $paymentMethod = PaymentMethod::find($id);

            if (!$paymentMethod) {
                return $this->apiResponse(false, 404, 'Payment method not found.');
            } else {
                PaymentMethod::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Payment method deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
