<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_product extends Model
{
    use HasFactory;

    // MG BBQ
    // protected $fillable = [
    //     'order_id',
    //     'product_id',
    //     'total'
    // ];

    //MG Merch
    protected $fillable = [
        'order_id',
        'product_id',
        'custom_text',
        'color',
        'size',
        'total'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
