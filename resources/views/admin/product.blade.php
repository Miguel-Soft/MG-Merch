@extends('layouts.admin')

@section('content')

    <!-- Admin - (All) Products -->

        <!-- Product table -->
    
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Naam
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">
                            Aantal besteld
                        </th>
                    </tr>
                </thead>
                <tbody>
    
                    @foreach ($products as $product)
                        
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $product['name'] }}
                            </th>
                            <td class="px-6 py-4 text-right">
                                {{ $product['aantal'] }}
                            </td>
                        </tr>
    
                    @endforeach
                    
                </tbody>
            </table>
        </div>

    
@endsection