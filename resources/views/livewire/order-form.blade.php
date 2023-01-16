<div class="h-full">

    <div class="p-5 flex flex-col h-full">

        {{-- <p>Lorem ipsum</p> --}}


        <div class="content">

            @switch($page)
                @case(0)
                    
                    <h3 class="font-bold mb-5 text-xl">Algemene gegevens</h3>

                    <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert">
                        <span class="font-bold">Opgelet!</span> De bestelling is pas compleet na het ontvangst van de betaling.
                    </div>

                    <div class="block grid grid-cols-1">
            
                        <div class="mb-6">
                            <label for="naam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Naam *</label>
                            <input wire:model="naam" type="naam" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @error('naam')
                                <span class="text-xs text-red-500 mt-1">Dit veld is verplicht in te vullen</span>
                            @enderror
                        </div>
            
                        <div class="mb-6">
                            <label for="voornaam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Voornaam *</label>
                            <input wire:model="voorNaam" type="voornaam" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @error('voorNaam')
                                <span class="text-xs text-red-500 mt-1">Dit veld is verplicht in te vullen</span>
                            @enderror
                        </div>
            
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email *</label>
                            <input wire:model="email" type="email" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @error('email')
                                @if($message == 'email_exist')
                                    <span class="text-xs text-red-500 mt-1">Deze email is al gebruikt</span>
                                @else
                                    <span class="text-xs text-red-500 mt-1">Dit veld is verplicht in te vullen</span>
                                @endif
                            @enderror
                        </div>
            
                        <div class="mb-6">
                            <label for="telefoon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Telefoon *</label>
                            <input wire:model="telefoon" type="telefoon" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @error('telefoon')
                                <span class="text-xs text-red-500 mt-1">Dit veld is verplicht in te vullen</span>
                            @enderror
                        </div>

                        {{-- <label for="toggle-example" class="flex relative items-center mb-4 cursor-pointer">
                            <input type="checkbox" id="toggle-example" class="sr-only" wire:model="bbq">
                            <div class="w-11 h-6 bg-gray-200 rounded-full border border-gray-200 toggle-bg dark:bg-gray-700 dark:border-gray-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Ik wens deel te nemen aan de BBQ</span>
                        </label> --}}
            
                    </div>

                    @break
                @case(1)

                    <style>
                        /* incard style */
                        .incard{
                            position: relative;
                        }

                        .incard::before{
                            content: 'In de winkelwagen';
                            position: absolute;
                            margin: 0px;
                            background-color: rgba(0, 0, 0, 0.7);
                            color: #FFF;
                            font-weight: bold;
                            padding: 5px 10px;

                            z-index: 999;
                        }

                        /* picture style */

                    </style>


                    <h3 class="font-bold mb-5 text-xl">Merge</h3>

                    <p>Vind hier het maattabel (cart: {{ $cart->count() }})</p>

                    <div class="grid md:grid-cols-2 grid-cols-1 gap-x-4 gap-y-6 mt-8">
            
                        @foreach ($productOrder as $product)

                            @if ($product['productData']['show'])
                                <h2 x-data="{ expanded: false }" class="mb-8 w-full text-base text-left text-gray-500 bg-slate-50
                                    @if ($cart->where('id', $product['productData']['id'])->count())
                                        incard
                                    @endif
                                ">

                                    <form wire:submit.prevent="addToCart({{ $product['productData']['id'] }})">

                                        <!-- foto -->

                                        <div class="w-full h-96 overflow-hidden relative" @click="expanded = ! expanded" x-data="{ image: '{{ $product['customise']->colors[$currentProductView['color'][$product['productData']['id']]]->images[0] }}' }">

                                            @if(array_key_exists($currentProductView['color'][$product['productData']['id']], $product['customise']->colors))

                                                @foreach ($product['customise']->colors[$currentProductView['color'][$product['productData']['id']]]->images as $image)
                                                    <div class="w-full h-96 absolute" x-show="image == '{{ $image }}'" x-cloak>
                                                        <img alt="" src="{{ url('storage/images/'.$image) }}" title="" class="w-full h-full object-cover"/>
                                                    </div>
                                                @endforeach

                                                <!-- thumbnails -->
                                                <div class="absolute h-16 w-full flex items-center justify-center bottom-0 z-50">
                                                    @foreach ($product['customise']->colors[$currentProductView['color'][$product['productData']['id']]]->images as $image)
                                                        <div class="h-16 h-16 p-2 cursor-pointer rounded-sm overflow-hidden" @mouseover="image='{{ $image }}'">
                                                            <img alt="" src="{{ url('storage/images/'.$image) }}" title="" class="w-full h-full object-cover"/>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            @else
                                                <img alt="" src="{{ url('storage/images/'.$product['productData']['photo'][0]) }}" title=""/>
                                            @endif

                                        </div>
                                        


                                        @csrf
                                        <span class="text-lg font-bold tracking-tight text-gray-900 block mt-2">{{ $product['productData']['name'] }}</span>

                                        <div x-show="expanded" x-collapse.duration.500ms>

                                            <!-- kleur -->
                                            <div class="mt-2">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">Kleur</label>
                                                <div class="grid place-content-start grid-cols-4 gap-2 w-full font-medium text-left text-gray-500 mt-2">

                                                    @foreach ($product['customise']->colors as $index => $color)

                                                        <div class="flex items-center px-2 border border-gray-300 rounded" style="background-color:{{ $color->hexcolor }}">
                                                            <input wire:model="currentProductView.color.{{ $product['productData']['id'] }}" type="radio" value="{{ $index }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 dark:bg-gray-700">
                                                            {{-- <input type="radio" name="color" value="{{ $color->name }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 dark:bg-gray-700"> --}}
                                                            <label class="w-full py-2 ml-2 text-sm font-medium">{{ $color->name }}</label>
                                                        </div>
                                                    
                                                    @endforeach

                                                </div>
                                            <div>

                                            <!-- maat -->
                                            <div class="mt-2">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">Maat</label>
                                                <div class="grid place-content-start grid-cols-4 gap-2 w-full font-medium text-left text-gray-500 mt-2">

                                                    @foreach ($product['customise']->sizes as $size)

                                                        <div class="flex items-center px-2 border border-gray-300 rounded">
                                                            <input wire:model="currentProductView.size.{{ $product['productData']['id'] }}" type="radio" value="{{ $size }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 dark:bg-gray-700">
                                                            {{-- <input type="radio" name="size" value="{{ $size }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 dark:bg-gray-700"> --}}
                                                            <label class="w-full py-2 ml-2 text-sm font-medium text-gray-900">{{ $size }}</label>
                                                        </div>

                                                    @endforeach

                                                </div>
                                            </div>

                                            @if ($product['productData']['custom_text'])
                                                <!-- custom tekst -->
                                                <div class="mt-2">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Persoonlijke tekst</label>
                                                    <div class="flex items-center">
                                                        <input wire:model="currentProductView.customtext.{{ $product['productData']['id'] }}" type="text" name="customtext" placeholder="MOEDER GEVAAR" class="block w-64 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs mr-2">
                                                        <svg class="w-6 h-6 grow-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- aantal -->
                                            <div class="mt-2">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">Aantal</label>
                                                <div class="flex justify-between">
                                                    <input type="number" min="0" max="99" id="small-input" wire:model="currentProductView.total.{{ $product['productData']['id'] }}" class="block w-24 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs">
                                                    {{-- <input type="number" name="total" value="1" min="0" max="99" id="small-input" class="block w-24 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs"> --}}
                                                    <div class="flex items-center">
                                                        <span class="text-l font-bold tracking-tight text-blue-700 block mr-2">€ {{ $product['productData']['price'] }},00/st.</span>
                                                        <button type="submit" class="text-indigo-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5" @click="expanded = false">
                                                            <svg class="w-6 h-6 grow-0" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M24 0C10.7 0 0 10.7 0 24S10.7 48 24 48H69.5c3.8 0 7.1 2.7 7.9 6.5l51.6 271c6.5 34 36.2 58.5 70.7 58.5H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H199.7c-11.5 0-21.4-8.2-23.6-19.5L170.7 288H459.2c32.6 0 61.1-21.8 69.5-53.3l41-152.3C576.6 57 557.4 32 531.1 32H360V134.1l23-23c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-64 64c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l23 23V32H120.1C111 12.8 91.6 0 69.5 0H24zM176 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm336-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </form>

                                </h2>
                            @endif
            
                        @endforeach
            
                    </div>
                    
                    @break

                @case(2)

                    <h3 class="font-bold mb-5 text-xl">Overzicht</h3>

                    


                    <div class="relative overflow-x-auto sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Naam
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tekst
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        aantal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        prijs
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($cart as $cartItem)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $cartItem->name }} ({{ $productOrder[$cartItem->id]['customise']->colors[$cartItem->options['color']]->name.'/'.$cartItem->options['size'] }})
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $cartItem->options['customtext'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $cartItem->qty }}
                                    </td>
                                    <td class="px-6 py-4">
                                        € {{$cartItem->price * $cartItem->qty}}
                                    </td>
                                    <td class="pr-6 py-4 text-right cursor-pointer">
                                        <button wire:click="removeFromCart('{{ $cartItem->rowId }}')"><svg class="w-6 h-6 grow-0" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg></button>
                                    </td>
                                </tr>

                            @endforeach
                                
                               
                            </tbody>
                        </table>

                        {{-- KORTINGEN --}}
                        {{-- <div class="block grid grid-cols-1 mt-8">

                            <label for="website-admin" class="block mb-2 text-sm font-medium">Korting code</label>
                            <div class="flex">
                                <input wire:model="reductionField" type="text" id="website-admin" class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5">
                                <span class="cursor-pointer inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 rounded-r-md border border-r-0 border-gray-300" wire:click="processReduction">
                                    Voeg toe
                                </span>
                            </div>
                            @error('reductionField')
                                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                            @enderror

                            @if($reductions)

                                <table class="w-full text-sm text-left text-gray-500 mt-6">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Naam
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Code
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right">
                                                Korting
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
        
                                        @foreach ($reductions as $reduction)
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $reduction['name'] }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $reduction['code'] }}
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    € -{{ $reduction['price'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    
                                    </tbody>
                                </table>

                            @endif

                        </div> --}}

                        <div class="mt-8 flex justify-between">
                            <div></div>
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-4 py-1.5 rounded"><b>Totaal: € {{ $total }}</b></span>
                        </div>

                    </div>

                    @break

                @case(3)

                    <h3 class="font-bold mb-5 text-xl">Bestelling ontvangen!</h3>

                    @if ($total == 0)
                        <p>Uw bestelling is succesvol geregistreerd en bevestigd!</p>
                    @else
                        <p>Uw bestelling is succesvol geregistreerd!<br/>Om uw bestelling te bevestigen: stort <b>€{{ $total }}</b> naar <span class="copy bg-blue-100 cursor-pointer" onclick="navigator.clipboard.writeText('{{ $iban }}')">{{ $iban }}</span> met mededeling: <span class="copy bg-blue-100 cursor-pointer" onclick="navigator.clipboard.writeText('{{ $paymentNotice }}')">{{ $paymentNotice }}</span></p>

                        <div class="p-4 mt-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert">
                            <span class="font-bold">Opgelet!</span> Bestellingen moeten betaald zijn tegen <b>10 Februari 2023</b>. Indien we geen betaling hebben ontvangen word de bestelling niet bevestigd.
                        </div>
                    @endif

                    
                    

                    @break
                
                @default

                <div class="h-full flex justify-center ">
                    <div><span class="font-bold text-xl pt-12">Bestellingen afgesloten.</span></div>
                </div>    
                    
            @endswitch


        </div>

        <!-- Knoppenbalk -->

        <div class="bottom-bar row justify-between">
            @switch($page)
                @case(0)
                    <div></div>
                    <span class="button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" wire:click="nextPage">Volgende</span>
                    @break
                @case(1)
                    <span class="button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" wire:click="previousPage">Terug</span>
                    <span class="button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" wire:click="nextPage">Volgende</span>
                    @break
                @case(2)
                    <span class="button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" wire:click="previousPage">Terug</span>
                    <span class="button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" wire:click="nextPage">Bevestig bestelling</span>
                    @break
                @default
                    
            @endswitch
        </div>

    </div>
</div>
