<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;
    protected $table = 'homestays';
    protected $fillable = ['name', 'location', 'location_id', 'type_id', 'created_at', 'updated_at'];
}
