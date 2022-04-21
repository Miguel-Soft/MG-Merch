
<div>

    <!-- Algemene info -->

    <div class="p-4 w-100 bg-white shadow-md sm:rounded-lg mb-6 border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-xl font-bold leading-none text-gray-900">Snelle data</h5>
        </div>
        <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200">

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Aantal bestellingen
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                {{ count($orders) }}
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Inkomsten
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900">
                               € {{$totalPayedIncome}} / {{ $totalIncome }}
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Betaald
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                {{ $payed }} / {{ count($orders) }}
                            </div>
                        </div>
                    </li>
                    
                </ul>
        </div>
    </div>

    <!-- Order table -->
    
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
                    
                    <tr class="bg-white border-b">
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
                                <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded cursor-pointer"
                                wire:click="handlePayed({{$order['id']}}, false)">Betaald</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded cursor-pointer"
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
