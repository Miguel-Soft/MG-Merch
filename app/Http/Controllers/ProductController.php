<?php

namespace App\Http\Controllers;

use App\Models\Order_product;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public $products = [];
    
    public function index(){

        $tempProducts = Product::all();

        foreach($tempProducts as $product){
            $orders = Order_product::where('product_id', $product->id)->get();
            $product['aantal'] = 0;

            foreach($orders as $order){
                $product['aantal'] += $order->total;
            }

            array_push($this->products, $product);
        }

        return View('admin.product', [
            'products' => $this->products
        ]);
    }

}
