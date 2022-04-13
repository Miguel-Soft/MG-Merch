<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class Admin extends Component{

    public $orders = [];
    public $products = [];



    public function handlePayed($orderId, $payed){
        $currentOrder = Order::find($orderId);
        $currentOrder->payed = $payed;
        $currentOrder->save();

        $this->orders[$orderId]['payed'] = $payed;
    }

    public function mount(){

        // all orders
        $tempOrders = Order::orderBy('payed', 'desc')->get();

        // payed/unPayed orders
        foreach($tempOrders as $order){
            $this->orders[$order->id] = $order;
        }

        // sorting later

        // products
        //$this->products = Product::all();

    }

    public function render(){
        return view('livewire.admin');
    }
}
