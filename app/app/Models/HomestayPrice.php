<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayPrice extends Model
{
    use HasFactory;
    protected $table = 'homestay_prices';
    protected $fillable = ['homestay_id', 'price_normal', 'price_special', 'max_guest',
        'max_night', 'min_night', 'price_expense'];
}
