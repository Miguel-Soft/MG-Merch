<div class="h-full">

    <form action="#" class="p-5 flex flex-col h-full">

        {{-- <p>Lorem ipsum</p> --}}


        <div class="content">

            @switch($page)
                @case(0)
                    
                    <h3 class="font-bold mb-5 text-xl">Algemene gegevens</h3>

                    <div class="block grid grid-cols-1">
            
                        <div class="mb-6">
                            <label for="naam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Naam</label>
                            <input wire:model="naam" type="naam" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
            
                        <div class="mb-6">
                            <label for="voornaam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Voornaam</label>
                            <input wire:model="voorNaam" type="voornaam" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
            
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                            <input wire:model="email" type="email" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
            
                        <div class="mb-6">
                            <label for="telefoon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Telefoon</label>
                            <input wire:model="telefoon" type="telefoon" id="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>

                        <div class="flex items-center mb-4">
                            <input wire:model="bbq" id="bbq" aria-describedby="bbq" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500">
                            <label for="bbq" class="ml-3 text-sm font-medium text-gray-900">Ik wens deel te nemen aan de BBQ</label>
                        </div>
            
                    </div>

                    @break
                @case(1)

                    <h3 class="font-bold mb-5 text-xl">BBQ</h3>

                    <p>Sauzen zijn inbegrepen. (Ketchup, Mayonaise, Lookboter, Brazil (?), Andalouse)</p>

                    <div class="block">
            
                        @foreach ($productOrder as $product)

                            <h2 class="mt-2">
                                <div class="flex justify-between items-center p-5 w-full font-medium text-left text-gray-500 border border-gray-200">
                                    <div class="grow-0">
                                        <span class="text-xl font-bold tracking-tight text-gray-900 block">{{ $product['productData']['name'] }}</span>
                                        <span class="text-l font-bold tracking-tight text-blue-700 block">€ {{ $product['productData']['price'] }}</span>
                                    </div>

                                    <div class="grow">
                                        <!-- input -->

                                        @if ($product['productData']['multiple'])
                                            <div class="flex p-4 justify-end input-button">
                                                <span class="border border-gray-300 text-gray-900 text-sm p-2.5 cursor-pointer" wire:click="inputButtonHandler({{$product['productData']['id']}}, '-1')">-</span>
                                                <input type="number" min="0" wire:model="productOrder.{{ $product['productData']['id'] }}.total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm p-2.5 w-14 inline-block align-middle pointer-events-none" required>
                                                <span class="border border-gray-300 text-gray-900 text-sm p-2.5 cursor-pointer" wire:click="inputButtonHandler({{$product['productData']['id']}}, '+1')">+</span>
                                            </div>
                                        @else
                                            <input type="checkbox" wire:model="productOrder.{{ $product['productData']['id'] }}.total">
                                        @endif

                                    </div>
                                    <svg class="w-6 h-6 grow-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </h2>
            
                        @endforeach
            
                    </div>
                    
                    @break

                @case(2)

                    <h3 class="font-bold mb-5 text-xl">Overzicht</h3>

                    

                    @break

                @case(3)

                    <h3 class="font-bold mb-5 text-xl">Bestelling ontvangen!</h3>

                    <p>Uw bestelling is succesvol geregistreerd!<br/>Om uw bestelling te bevestigen: stort <b>€{{ $total }}</b> naar <b>{{ $iban }}</b> met mededeling: <b>{{ $paymentNotice }}</b></p>

                    @break
                
                @default
                    
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

    </form>
</div>
