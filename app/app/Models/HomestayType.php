<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayType extends Model
{
    use HasFactory;
    protected $table = 'homestay_types';
    protected $fillable = ['name'];
}
