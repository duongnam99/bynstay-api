<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayUtilityType extends Model
{
    use HasFactory;

    protected $table = 'homestay_utility_types';
    public $fillable= ['parent_id', 'name', 'created_at', 'updated_at'];
    public $timestamps = false;

    public function getListChildById()
    {

    }
    
    public function parent()
    {
        return $this->belongsTo(HomestayUtilityType::class, 'parent_id');
    }
}
