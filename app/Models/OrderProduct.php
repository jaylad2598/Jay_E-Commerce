<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = "order_products";
    protected $fillable = ['prd_id','userid','prd_name','prd_price','GST','total_price','status'];

}
