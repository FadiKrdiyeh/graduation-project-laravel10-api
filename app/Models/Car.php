<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['production_date', 'engine_capacity', 'color', 'status', 'has_turbo', 'is_new', 'has_sunroof', 'kilometerage', 'duration', 'price', 'consumption', 'top_speed', 'dimensions', 'fuel_type_id', 'transmission_id', 'brand_id', 'car_model_id', 'type_of_shop_id'];

    // ? Relations ...
    public function fuel_type () {
        return $this->hasOne(FuelType::class);
    }
    public function transmission () {
        return $this->hasOne(Transmission::class);
    }
    public function brand () {
        return $this->hasOne(Brand::class);
    }
    public function car_model () {
        return $this->hasOne(CarModel::class);
    }
    public function type_of_shop () {
        return $this->hasOne(TypeOfShop::class);
    }
}
