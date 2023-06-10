<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cars = Car::
                        with(['fuel_type' => function ($query1) {
                            $query1->select('*');
                        }])
                        ->with(['transmission' => function ($query2) {
                            $query2->select('*');
                        }])
                        ->with(['brand' => function ($query3) {
                            $query3->select('*');
                        }])
                        ->with(['car_model' => function ($query4) {
                            $query4->select('*');
                        }])
                        ->with(['type_of_shop' => function ($query5) {
                            $query5->select('*');
                        }])
                        ->paginate(10);

            if ($cars->count() > 0) {
                return $this->apiResponse(true, 200, 'Cars fetched successfuly.', $cars);
            } else {
                return $this->apiResponse(false, 404, 'No cars found.');
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
                'production_date' => 'required',
                'engine_capacity' => 'required',
                'color' => 'required',
                'status' => 'required',
                'has_turbo' => 'required',
                'is_new' => 'required',
                'has_sunroof' => 'required',
                'kilometerage' => 'required',
                'duration' => 'required',
                'price' => 'required',
                'consumption' => 'required',
                'top_speed' => 'required',
                'dimensions' => 'required',
                'fuel_type_id' => 'required',
                'transmission_id' => 'required',
                'brand_id' => 'required',
                'car_model_id' => 'required',
                'type_of_shop_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $car = Car::create([
                'production_date' => $request->production_date,
                'engine_capacity' => $request->engine_capacity,
                'color' => $request->color,
                'status' => $request->status,
                'has_turbo' => $request->has_turbo,
                'is_new' => $request->is_new,
                'has_sunroof' => $request->has_sunroof,
                'kilometerage' => $request->kilometerage,
                'duration' => $request->duration,
                'price' => $request->price,
                'consumption' => $request->consumption,
                'top_speed' => $request->top_speed,
                'dimensions' => $request->dimensions,
                'fuel_type_id' => $request->fuel_type_id,
                'transmission_id' => $request->transmission_id,
                'brand_id' => $request->brand_id,
                'car_model_id' => $request->car_model_id,
                'type_of_shop_id' => $request->type_of_shop_id,
            ]);

            if ($car) {
                return $this->apiResponse(true, 201, 'Car created successfully.', $car);
            } else {
                return $this->apiResponse(false, 400, 'Create car faild.');
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
            $car = Car::find($id);

            if ($car) {
                return $this->apiResponse(true, 200, 'Car fetched successfully.', $car);
            } else {
                return $this->apiResponse(false, 404, 'Car not found.');
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
                'production_date' => 'required',
                'engine_capacity' => 'required',
                'color' => 'required',
                'status' => 'required',
                'has_turbo' => 'required',
                'is_new' => 'required',
                'has_sunroof' => 'required',
                'kilometerage' => 'required',
                'duration' => 'required',
                'price' => 'required',
                'consumption' => 'required',
                'top_speed' => 'required',
                'dimensions' => 'required',
                'fuel_type_id' => 'required',
                'transmission_id' => 'required',
                'brand_id' => 'required',
                'car_model_id' => 'required',
                'type_of_shop_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $car = Car::find($id);

            if ($car) {
                $car->update([
                    'production_date' => $request->production_date,
                    'engine_capacity' => $request->engine_capacity,
                    'color' => $request->color,
                    'status' => $request->status,
                    'has_turbo' => $request->has_turbo,
                    'is_new' => $request->is_new,
                    'has_sunroof' => $request->has_sunroof,
                    'kilometerage' => $request->kilometerage,
                    'duration' => $request->duration,
                    'price' => $request->price,
                    'consumption' => $request->consumption,
                    'top_speed' => $request->top_speed,
                    'dimensions' => $request->dimensions,
                    'fuel_type_id' => $request->fuel_type_id,
                    'transmission_id' => $request->transmission_id,
                    'brand_id' => $request->brand_id,
                    'car_model_id' => $request->car_model_id,
                    'type_of_shop_id' => $request->type_of_shop_id,
                ]);

                $car->save();

                return $this->apiResponse(true, 200, 'Car updated successfuly.', $car);
            } else {
                return $this->apiResponse(false, 400, 'Update car faild.');
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
            $car = Car::find($id);

            if (!$car) {
                return $this->apiResponse(false, 404, 'Car not found.');
            } else {
                Car::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Car deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
