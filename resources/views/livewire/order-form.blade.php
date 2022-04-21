<div class="h-full">

    <form action="#" class="p-5 flex flex-col h-full">

        {{-- <p>Lorem ipsum</p> --}}


        <div class="content">

            @switch($page)
                @case(0)
                    
                    <h3 class="font-bold mb-5 text-xl">Algemene gegevens</h3>

                    <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert">
                        <span class="font-bold">Opgelet!</span> Deze inschrijving is per persoon. Indien u voor meerdere personen wilt inschrijven, dient u deze form meerdere keren in te vullen.
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

                        <label for="toggle-example" class="flex relative items-center mb-4 cursor-pointer">
                            <input type="checkbox" id="toggle-example" class="sr-only" wire:model="bbq">
                            <div class="w-11 h-6 bg-gray-200 rounded-full border border-gray-200 toggle-bg dark:bg-gray-700 dark:border-gray-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Ik wens deel te nemen aan de BBQ</span>
                        </label>
            
                    </div>

                    @break
                @case(1)

                    <h3 class="font-bold mb-5 text-xl">BBQ</h3>

                    <p>Sauzen zijn inbegrepen. (Ketchup, Mayonaise, Lookboter, Brazil (?), Andalouse)</p>

                    <div class="block">
            
                        @foreach ($productOrder as $product)

                            @if ($product['productData']['show'])
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
                                                {{-- <input type="checkbox" wire:model="productOrder.{{ $product['productData']['id'] }}.total"> --}}
                                                <div class="p-4 flex justify-end">
                                                    <label for="toggle-example" class="flex relative cursor-pointer">
                                                        <input wire:model="productOrder.{{ $product['productData']['id'] }}.total" type="checkbox" id="toggle-example" class="sr-only">
                                                        <div class="w-11 h-6 bg-gray-200 rounded-full border border-gray-200 toggle-bg"></div>
                                                    </label>
                                                </div>
                                                

                                            @endif

                                        </div>
                                        <svg class="w-6 h-6 grow-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
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
                                        aantal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Prijs
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($productOrder as $product)

                                    @if($product['total'] !== 0)

                                        <tr class="bg-white border-b">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $product['productData']['name'] }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $product['total'] }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                € {{ $product['productData']['price'] * $product['total']}}
                                            </td>
                                        </tr>

                                    @endif
                                @endforeach

                                {{-- <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    </th>
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="px-6 py-4 text-right text-neutral-900">
                                        <b>Totaal: € {{ $total }}</b>
                                    </td>
                                </tr> --}}
                                
                               
                            </tbody>
                        </table>

                        <div class="block grid grid-cols-1 mt-8">

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

                        </div>

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
                            <span class="font-bold">Opgelet!</span> Bestellingen moeten betaald zijn tegen <b>22 april 2022</b>. Indien we geen betaling hebben ontvangen word de bestelling niet bevestigd.
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

    </form>
</div>
