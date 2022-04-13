<div>

    <h1 class="text-2xl py-5">Bestellingen</h1>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Naam
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Prijs
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Mededeling
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Betaald
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Detail</span>
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)
                    
                    <tr class="bg-white border-b dark:bg-gray-800">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $order['name'] }}
                        </th>
                        <td class="px-6 py-4">
                            € {{ $order['price'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order['notice'] }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($order['payed'])
                                <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                                wire:click="handlePayed({{$order['id']}}, false)">Betaald</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                                wire:click="handlePayed({{$order['id']}}, true)">Open</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/admin/order/{{ $order['id'] }}" class="font-medium text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>

                @endforeach
                
            </tbody>
        </table>
    </div>

</div>
