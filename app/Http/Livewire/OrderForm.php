<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use Livewire\Component;

class OrderForm extends Component{

    // algemene gegevens
    public $naam;
    public $voorNaam;
    public $email;
    public $telefoon;


    public $page = 0;
    public $bbq = false;
    public $productOrder = [];
    public $total = 0;
    public $paymentNotice = 'LUSTRUM-MG OrderID Voornaam';
    public $iban = "BE95 0635 4437 6058";

    public $reductions = [];

    // validation
    public $validationRules = [
        0 => [
            'naam' => 'required',
            'voorNaam' => 'required',
            'email' => 'required',
            'telefoon' => 'required',
        ],
        1 => [],
        2 => [],
        3 => [],
    ];

    /* button handler */
    public function inputButtonHandler($productOrderId, $type){

        $productTotal = $this->productOrder[$productOrderId]['total'];

        switch($type){
            case '-1':
                if($productTotal >= 1){
                    $this->productOrder[$productOrderId]['total'] --;
                }
            break;
            case '+1':
                $this->productOrder[$productOrderId]['total'] ++;
            break;
        }
    }

    /* Page handler */
    public function nextPage(){

        if(count($this->validationRules[$this->page]) > 0){
            $this->validate($this->validationRules[$this->page]);
        }

        switch($this->page){

            case 0:

                // check als de email al gebruikt is

                if(!Order::where('email',$this->email)->first()){
                    // check als de bbq is aangeduid
                    if($this->bbq){
                        $this->page ++;
                    }else{
                        if($this->calculateOrder()){
                            $this->page = 2;
                        }
                    }
                }else{
                    $this->addError('email', 'email_exist');
                }

                
                
                break;
            case 1:
                if($this->calculateOrder()){
                    $this->page ++;
                }
                break;
            case 2:
                if($this->processOrder()){
                    $this->page ++;
                }
                break;
            case 3:
                break;
            default:
                $this->page ++;
            break;
        }
    }

    public function previousPage(){
        switch($this->page){
            case 0:
                break;
            case 2:
                if($this->bbq){
                    $this->page --;
                }else{
                    $this->page = 0;
                }
                break;
            default:
                $this->page --;
            break;
        }
    }

    /* Calculate order */
    function calculateOrder(){

        $this->total = 0;

        foreach($this->productOrder as $orderItem){
            if($orderItem['productData']['multiple']){
                $this->total += ($orderItem['productData']['price'] * $orderItem['total']);
            }else{
                if($orderItem['total']){
                    $this->total += $orderItem['productData']['price'];
                }
            }
        }

        return true;
    }

    /* Process order */
    function processOrder(){

        if($this->total == 0){
            // error -> niets geselecteerd
            return false;
        }else{
            // voeg toe aan DB

            $order = new Order([
                'name' => $this->naam." ".$this->voorNaam,
                'email' => $this->email,
                'telephone' => $this->telefoon,
                'payed' => false,
                'price' => $this->total,
                'notice' => "processing"
            ]);

            $order->save();

            foreach($this->productOrder as $orderItem){
                if($orderItem['productData']['multiple']){
                    if($orderItem['total'] !== 0){
                        $orderProduct = new Order_product([
                            'order_id' => $order->id,
                            'product_id' => $orderItem['productData']['id'],
                            'total' => $orderItem['total']
                        ]);
                        $orderProduct->save();
                    }
                }else{
                    if($orderItem['total']){
                        $orderProduct = new Order_product([
                            'order_id' => $order->id,
                            'product_id' => $orderItem['productData']['id'],
                            'total' => 1
                        ]);
                        $orderProduct->save();
                    }
                }
            }

            $this->paymentNotice = 'LUSTRUM-MG '.$order->id.' '.$this->voorNaam;

            $order->notice = $this->paymentNotice;
            $order->save();

            $this->resetValidation();

            return true;
        }

        
    }

    public function mount(){
        $products = Product::all();

        foreach($products as $product){
            if($product->multiple){
                $this->productOrder[$product->id] = [
                    'productData' => $product,
                    'total' => $product->startval
                ];
            }else{
                $this->productOrder[$product->id] = [
                    'productData' => $product,
                    'total' => $product->startval
                ];
            }
        }

    }

    public function render(){
        return view('livewire.order-form');
    }
}
