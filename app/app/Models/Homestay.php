<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;
    protected $table = 'homestays';
    protected $fillable = ['name', 'location', 'location_id', 'type_id', 'created_at', 'updated_at'];

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
}
