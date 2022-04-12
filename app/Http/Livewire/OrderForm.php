<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Reduction;
use App\Models\Order_product;
use App\Models\Order_reduction;
use App\Models\Product;
use Livewire\Component;

class OrderForm extends Component{

    // algemene gegevens
    public $naam;
    public $voorNaam;
    public $email;
    public $telefoon;


    public $page = 2;
    public $bbq = false;
    public $productOrder = [];
    public $total = 0;
    public $paymentNotice = 'LUSTRUM-MG OrderID Voornaam';
    public $iban = "BE95 0635 4437 6058";

    public $reductionField;
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
                    $this->resetValidation();
                }else{
                    $this->addError('email', 'email_exist');
                }

                
                
                break;
            case 1:
                if($this->calculateOrder()){
                    $this->page ++;
                    $this->resetValidation();
                }
                break;
            case 2:
                if($this->processOrder()){
                    $this->page ++;
                    $this->resetValidation();
                }
                break;
            case 3:
                $this->resetValidation();
                break;
            default:
                $this->page ++;
                $this->resetValidation();
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

    /* Kortingen */
    function processReduction(){
        if($this->reductionField){
            $reduction = Reduction::where('code',$this->reductionField)->first();

            // check als de korting nog bestaat
            if($reduction){

                // check als de korting al ingegeven is
                foreach($this->reductions as $checkReduction){
                    if($checkReduction['code'] == $this->reductionField){
                        $this->addError('reductionField', 'Deze kortingscode is al geactiveerd');
                        return false;
                    }
                }

                // check als de korting actief/nog beschikbaar is
                if($reduction->active > 0){

                    array_push($this->reductions, [
                        'id' => $reduction->id,
                        'name' => $reduction->name,
                        'code' => $reduction->code,
                        'price' => $reduction->price
                    ]);

                    // verminder korting met 1 van DB als korting niet oneindig is
                    if(!$reduction->infinite){
                        $reduction->active -= 1;
                    }

                    $reduction->save();

                    $this->calculateOrder();
                    $this->resetValidation();

                    return true;

                }else{
                    $this->addError('reductionField', 'Deze kortingscode is niet meer geldig');
                    return false;
                }
            }else{
                $this->addError('reductionField', 'Deze kortingscode bestaat niet');
                return false;
            }
        }else{
            $this->addError('reductionField', 'Geef een kortingscode in');
            return false;
        }
    }

    /* Calculate order */
    function calculateOrder(){

        $this->total = 0;

        // producten

        foreach($this->productOrder as $orderItem){
            if($orderItem['productData']['multiple']){
                $this->total += ($orderItem['productData']['price'] * $orderItem['total']);
            }else{
                if($orderItem['total']){
                    $this->total += $orderItem['productData']['price'];
                }
            }
        }

        // kortingen

        foreach($this->reductions as $reduction){
            $calculatedTotal = $this->total - $reduction['price'];
            if($calculatedTotal <= 0){
                $calculatedTotal = 0;
            }
            $this->total = $calculatedTotal;
        }

        return true;
    }

    /* Process order */
    function processOrder(){

            // voeg toe aan DB

            if($this->total == 0){
                $payed = true;
            }else{
                $payed = false;
            }

            $order = new Order([
                'name' => $this->naam." ".$this->voorNaam,
                'email' => $this->email,
                'telephone' => $this->telefoon,
                'payed' => $payed,
                'price' => $this->total,
                'notice' => "processing"
            ]);

            $order->save();

            // producten

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

            // kortingen

            foreach($this->reductions as $reduction){
                $orderReduction = new Order_reduction([
                    'order_id' => $order->id,
                    'reduction_id' => $reduction['id']
                ]);
                $orderReduction->save();
            }

            $this->paymentNotice = 'LUSTRUM-MG '.$order->id.' '.$this->voorNaam;

            $order->notice = $this->paymentNotice;
            $order->save();

            $this->resetValidation();

            return true;

        
    }

    /* Start */
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
