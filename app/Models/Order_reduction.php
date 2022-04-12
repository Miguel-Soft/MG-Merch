<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_reduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'reduction_id'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function reduction(){
        return $this->belongsTo(Reduction::class);
    }


}
