<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Reduction;
use App\Models\Order_product;
use App\Models\Order_reduction;
use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderForm extends Component{

    public $cart;

    public $currentProductView = [
        "color" => [],
        "size" => [],
        "customtext" => [],
        "total" => []
    ];

    // algemene gegevens
    public $naam;
    public $voorNaam;
    public $email;
    public $telefoon;


    public $page = 1;
    public $productOrder = [];
    public $total = 0;
    public $paymentNotice = 'Naam + Voornaam + MG Merch';
    public $iban = "BE22 0837 9298 9147";

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

    /* Page handler */
    public function nextPage(){

        if(count($this->validationRules[$this->page]) > 0){
            $this->validate($this->validationRules[$this->page]);
        }

        switch($this->page){

            case 0:
                // ga naar bestelpagina
                // check als de email al gebruikt is
                if(!Order::where('email',$this->email)->first()){
                    $this->page ++;
                    $this->resetValidation();
                }else{
                    $this->addError('email', 'email_exist');
                }
                
                break;
            case 1:
                // ga naar besteloverzichtpagina (of winkelwagen)
                if($this->calculateOrder()){
                    $this->page ++;
                    $this->resetValidation();
                }
                break;
            case 2:
                // start bestelprocess > ga naar status pagina
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
                $this->page --;
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

        $this->total = Cart::total();

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

            $this->total = Cart::total();

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

            foreach($this->cart as $cartItem){
                $orderProduct = new Order_product([
                    'order_id' => $order->id,
                    'product_id' => $cartItem['id'],
                    'custom_text' => $cartItem['options']['customtext'] ?? "",
                    'color' => $this->productOrder[$cartItem['id']]['customise']['colors'][$cartItem['options']['color']]['name'], // veranderen naar effectief kleur
                    'size' => $cartItem['options']['size'],
                    'total' => $cartItem['qty']
                ]);
                $orderProduct->save();
            }

            // kortingen

            foreach($this->reductions as $reduction){
                $orderReduction = new Order_reduction([
                    'order_id' => $order->id,
                    'reduction_id' => $reduction['id']
                ]);
                $orderReduction->save();
            }

            $this->paymentNotice = $this->naam." ".$this->voorNaam." MG Merch";

            $order->notice = $this->paymentNotice;
            $order->save();

            $this->resetValidation();
            Cart::destroy();
            return true;

        
    }

    


    /* CARD */
    /* Add to cart */
    public function addToCart($productId){

        $product = Product::findOrFail($productId);
    
        Cart::add(
            $product->id, 
            $product->name,
            $this->currentProductView['total'][$productId],
            $product->price,
            0, // weight
            [
                'color' => $this->currentProductView['color'][$productId],
                'size' => $this->currentProductView['size'][$productId],
                'customtext' => $this->currentProductView['customtext'][$productId] ?? null
            ]
        );
    }

    /* Remove from cart */
    public function removeFromCart($rowId){
        Cart::remove($rowId);
        $this->calculateOrder();
    }

    /* Start */
    public function mount(){
        //
    }

    public function render(){
        $this->cart = Cart::content();
        $products = Product::all();

        foreach($products as $product){

            $data_json = json_decode(file_get_contents(storage_path() . "/app/public/templates/". $product->data_json));

            $this->productOrder[$product->id] = [
                'productData' => $product,
                'customise' => $data_json
            ];

            $this->productOrder[$product->id]["productData"]->photo = json_decode($this->productOrder[$product->id]["productData"]->photo);


            

            !array_key_exists($product->id, $this->currentProductView['color']) ? $this->currentProductView['color'][$product->id] = 0 : null;
            !array_key_exists($product->id, $this->currentProductView['size']) ? $this->currentProductView['size'][$product->id] = $data_json->sizes[0] : null;
            !array_key_exists($product->id, $this->currentProductView['total']) ? $this->currentProductView['total'][$product->id] = 1: null;

            $product->custom_text &&  !array_key_exists($product->id, $this->currentProductView['customtext']) ? $this->currentProductView['customtext'][$product->id] = "" : null;

        }


        //$this->calculateOrder();
        return view('livewire.order-form');
    }
}
