<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayPolicy extends Model
{
    use HasFactory;
    protected $table = 'homestay_policies';
    protected $fillable = ['homestay_id', 'policy_id', 'content', 'updated_at', 'created_at'];
}
