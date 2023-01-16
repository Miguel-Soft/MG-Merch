<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_product;
use App\Models\Order_reduction;
use App\Models\Product;
use App\Models\Reduction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function index($id){
        $order = Order::find($id);

        $orderProducts = [];
        $orderReduction = [];

        foreach(Order_product::where('order_id', $id)->get() as $productRaw){
            array_push($orderProducts, [
                'product' => Product::find($productRaw->product_id),
                'total' => $productRaw->total,
                'size' => $productRaw->size,
                'color' => $productRaw->color,
                'custom_text' => $productRaw->custom_text,
            ]);
        }

        foreach(Order_reduction::where('order_id', $id)->get() as $reductionRaw){
            array_push($orderReduction, Reduction::find($reductionRaw->reduction_id));
        }

        return view('admin.order', [
            'order' => $order,
            'products' => $orderProducts,
            'reductions' => $orderReduction
        ]);
    }

}
