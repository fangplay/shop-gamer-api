<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable  = [
        'order_date','payment_date','delivery_date','user_id','address','status_id','product_id'
    ];
}
