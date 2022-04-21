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
            $product['aantal'] = Order_product::where('product_id', $product->id)->count();
            array_push($this->products, $product);
        }

        return View('admin.product', [
            'products' => $this->products
        ]);
    }

}
