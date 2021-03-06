<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayPolicyType extends Model
{
    use HasFactory;
    protected $table = 'homestay_policy_types';
    protected $fillable = ['name', 'updated_at', 'created_at'];

}
