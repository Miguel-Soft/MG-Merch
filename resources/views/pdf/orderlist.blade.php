<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>pdf</title>

  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />

</head>
<body>

  <!-- pdf -->
  
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Naam
                </th>
                
                @foreach ($productList as $product)
                  <th scope="col" class="px-6 py-3">
                    {{ $product->name }}
                  </td>
                @endforeach
  
                {{-- <th scope="col" class="px-6 py-3 text-right">
                    Subtotaal
                </th> --}}
  
            </tr>
        </thead>
        <tbody>
  
            @foreach ($list as $listItem)
                
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $listItem['order_detail']['name'] }}
                    </th>
                    
                    @foreach ($listItem['products'] as $product)
                      <td class="px-6 py-4">
                        {{ $product['total'] }}
                      </td>
                    @endforeach
  
                    {{-- <td class="px-6 py-4 text-right">
                        € {{ ($product['total'] * $product['product']['price']) }}
                    </td> --}}
  
                </tr>
  
            @endforeach
            
        </tbody>
    </table>
  </div>

  <!-- end pdf -->

</body>
</html>

