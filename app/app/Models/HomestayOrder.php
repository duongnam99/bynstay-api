<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomestayOrder extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['homestay_id', 'order_number', 'start_date', 'end_date', 'num_night', 'num_guess', 'fee',
     'order_status', 'payment_status', 'customer_name', 'customer_email', 'customer_phone', 'success_code', 'user_creator_id' ];

     public function homestay()
     {
         return $this->belongsTo(Homestay::class, 'homestay_id');
     }
}
