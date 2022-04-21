<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{

    public $orders = [];
    public $products = [];

    public $totalIncome = 0;
    public $totalPayedIncome = 0;

    public $payed = 0;


    public function handlePayed($orderId, $payed){
        $currentOrder = Order::find($orderId);
        $currentOrder->payed = $payed;
        $currentOrder->save();

        $this->orders[$orderId]['payed'] = $payed;

        if($payed){
            $this->payed += 1;
            $this->totalPayedIncome += $currentOrder->price;
        }else{
            $this->payed -= 1;
            $this->totalPayedIncome -= $currentOrder->price;
        }
    }

    public function mount(){

        // all orders
        $tempOrders = Order::orderBy('payed', 'desc')->get();

        // payed/unPayed orders
        foreach($tempOrders as $order){
            $this->orders[$order->id] = $order;
            $this->totalIncome += $order->price;

            if($order->payed){
                $this->payed += 1;
                $this->totalPayedIncome += $order->price;
            }

        }

        // sorting later

    }

    public function render()
    {
        return view('livewire.admin.orders');
    }
}
