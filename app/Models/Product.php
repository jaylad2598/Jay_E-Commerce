<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    protected $fillable = ['name','category','price','description','status','image'];

    public function getnameAttribute($value)
    {
        return ucfirst($value);
    }
}


