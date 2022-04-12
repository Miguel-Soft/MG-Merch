<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'payed',
        'price',
        'notice'
    ];

    public function order_stock(){
        return $this->hasMany(Order_product::class);
    }

    public function order_reduction(){
        return $this->hasMany(Order_reduction::class);
    }

}
