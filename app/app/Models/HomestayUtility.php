<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayUtility extends Model
{
    use HasFactory;
    protected $table = 'homestay_utilities';
    public $fillable= ['homestay_id', 'utility_id', 'created_at', 'updated_at'];
}
