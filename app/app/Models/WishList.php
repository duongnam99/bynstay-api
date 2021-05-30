<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;
    protected $table = 'wishlist';
    protected $fillable = ['homestay_id', 'user_id', 'client_id'];

}
