<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use Illuminate\Http\Request;
// use PDF;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{

    private function getPayedOrders(){
        $orders = [];
        $tempOrders = Order::all();
        foreach($tempOrders as $order){
            if($order->payed){
                array_push($orders, $order);
            }
        }
        return $orders;
    }
    
    public function makeSpecificOrderList($productID){
        $list = [];

        $product = Product::find($productID);
        $orders = $this->getPayedOrders();

    }

    public function makeOrderList(){
        $list = [];

        $products = Product::all();
        foreach($this->getPayedOrders() as $order){

            $productArray = [];

            foreach($products as $product){
                $order_product = Order_product::where([
                    'order_id' => $order->id,
                    'product_id' => $product->id
                ])->first();

                if($order_product){
                    $productArray[$product->id] = [
                        'product' => $product,
                        'total' => $order_product->total
                    ];
                }else{
                    $productArray[$product->id] = [
                        'product' => $product,
                        'total' => 0
                    ];
                }

            }

            $list[$order->id] = [
                'order_detail' => $order,
                'products' => $productArray
            ];

        }

        // return view('pdf.orderlist', [
        //     'productList' => $products,
        //     'list' => $list
        // ]);

        $pdf = PDF::loadView('pdf.orderlist', [
                'productList' => $products,
                'list' => $list
        ]);

        ob_end_clean();

        return $pdf->setPaper('a4')->stream();

        // return $pdf->download('orderlist.pdf');

    }

}
