<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'productid',
        'userid',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class,'id','productid');
    }

    public function products()
    {
        return $this->hasMany(CartProduct::class,'cartid','id');
    }

    public function phone(){
        return $this->hasOne(Cart::class,'userid', 'id');
    }
}
