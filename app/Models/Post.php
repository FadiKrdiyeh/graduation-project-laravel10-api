<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['date_of_publish', 'car_id', 'user_id', 'count_in_package'];

    // ? Relations ...
    public function car () {
        return $this->belongsTo(Car::class);
    }
    public function user () {
        return $this->belongsTo(User::class);
    }
}
