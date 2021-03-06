<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayUtility extends Model
{
    use HasFactory;

    protected $table = 'homestay_utilities';
    public $fillable= ['parent_id', 'name', 'created_at', 'updated_at'];
    public $timestamps = false;

    public function getListChildById()
    {
        
    }
    public function parent()
    {
        return $this->belongsTo(HomestayUtility::class, 'parent_id');
    }
}
