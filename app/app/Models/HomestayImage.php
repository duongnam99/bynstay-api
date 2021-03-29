<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayImage extends Model
{
    use HasFactory;
    protected $table = 'homestay_images';
    protected $fillable = ['homestay_id', 'image'];
}
