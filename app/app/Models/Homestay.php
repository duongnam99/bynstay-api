<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;
    protected $table = 'homestays';
    protected $fillable = ['name', 'location', 'location_id', 'des', 'type_id', 'approved', 'request_approve_at', 'user_id', 'created_at', 'updated_at'];

    const APPROVED = 1;
    const REQUEST_APPROVE = 2;
    const DECLINE_APPROVE = -1;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function utilities()
    {
        return $this->belongsToMany(HomestayUtilityType::class, 'homestay_utilities', 'homestay_id', 'utility_id');
    }

    public function policyTypes()
    {
        return $this->belongsToMany(HomestayPolicyType::class, 'homestay_policies', 'homestay_id', 'policy_id');
    }

    public function images()
    {
        return $this->hasMany(HomestayImage::class, 'homestay_id');
    }

    public function prices()
    {
        return $this->hasOne(HomestayPrice::class, 'homestay_id');
    }

    public function type()
    {
        return $this->belongsTo(HomestayType::class, 'type_id');
    }

    public function orders()
    {
        return $this->hasMany(HomestayOrder::class, 'homestay_id');
    }

}
