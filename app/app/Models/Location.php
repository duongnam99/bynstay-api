<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    public $timestamps = false;
    protected $fillable = ['province_id', 'district_id', 'ward_id'];

    public function homestay()
    {
        return $this->hasOne(Homestay::class, 'location_id');
    }

}
