@extends('layouts.admin')

@section('content')

    <!-- Admin - (All) Products -->

    <!-- Algemene info -->

    <h2 class="font-bold mb-5 text-2xl">{{ $order['name'] }}</h2>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500">
          <tbody>

            <tr class="bg-white border-b">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                  Bestel ID
              </th>
              <td class="px-6 py-4 text-right">
                  {{ $order['notice'] }}
              </td>
            </tr>

            <tr class="bg-white border-b">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                  Datum/tijd
              </th>
              <td class="px-6 py-4 text-right">
                  {{ $order['created_at'] }}
              </td>
            </tr>

            <tr class="bg-white border-b">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                  Telefoon
              </th>
              <td class="px-6 py-4 text-right">
                  {{ $order['telephone'] }}
              </td>
            </tr>

            <tr class="bg-white border-b">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                  Email
              </th>
              <td class="px-6 py-4 text-right">
                  {{ $order['email'] }}
              </td>
            </tr>

            <tr class="bg-white border-b">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                @if ($order['payed'])
                    <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                    wire:click="handlePayed({{$order['id']}}, false)">Betaald</span>
                @else
                    <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                    wire:click="handlePayed({{$order['id']}}, true)">Te betalen</span>
                @endif
              </th>
              <td class="px-6 py-4 text-right font-bold text-gray-900">
                  € {{ $order['price'] }}
              </td>
            </tr>
              
          </tbody>
      </table>
    </div>

    <!-- Producten -->

    <h2 class="font-bold mb-5 mt-8 text-xl">Producten</h2>

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
                      Aantal
                  </th>
                  <th scope="col" class="px-6 py-3 text-right">
                      Subtotaal
                  </th>
              </tr>
          </thead>
          <tbody>

              @foreach ($products as $product)
                  
                  <tr class="bg-white border-b">
                      <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                          {{ $product['product']['name'] }}
                      </th>
                      <td class="px-6 py-4">
                          € {{ $product['product']['price'] }}
                      </td>
                      <td class="px-6 py-4">
                        {{ $product['total'] }}
                      </td>
                      <td class="px-6 py-4 text-right">
                          € {{ ($product['total'] * $product['product']['price']) }}
                      </td>
                  </tr>

              @endforeach
              
          </tbody>
      </table>
    </div>

    <!-- Kortingen -->

    <h2 class="font-bold mb-5 mt-8 text-xl">Kortingen</h2>

    @if ($reductions)
      
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Naam
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Code
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Prijs
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
      </div>

    @else

      <p class="text-gray-50 text-center">Geen kortingen gebruikt.</p>

    @endif

    
@endsection