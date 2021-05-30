<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestedPlace extends Model
{
    use HasFactory;
    protected $table = 'suggest_place';
    public $timestamps = false;
    protected $fillable = ['district_id', 'image'];

    public function district()
    {
        return $this->belongsTo(VnDistrict::class, 'district_id');
    }
}
