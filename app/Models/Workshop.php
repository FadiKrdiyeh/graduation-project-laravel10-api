<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'longitude', 'latitude', 'jurisdiction', 'oppening_time', 'closing_time', 'description', 'features', 'user_id'];
}
