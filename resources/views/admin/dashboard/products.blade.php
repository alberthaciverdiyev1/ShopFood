@extends('admin.dashboard.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-3xl font-bold mb-6">Products</h2>

    @php
        $headers = ['#', 'Image', 'Name', 'Price', 'Discounted Price', 'Actions'];
        $rows = [];
        $i = 1; 
        foreach ($products as $product) {
            $rows[] = [
                $i++, 
                '<img src="'.($product['images'][0] ?? $product['image']).'" class="w-20 h-20 object-contain mx-auto rounded-md" alt="'.$product['nazev'].'">',
                $product['nazev'],
                "$".$product['cenaZaklVcDph'],
                !empty($product['discounted_price']) 
                    ? '<span class="text-red-600 font-bold">$'.$product['discounted_price'].'</span> 
                       <span class="line-through text-gray-400 ml-2">$'.$product['cenaZaklVcDph'].'</span>' 
                    : '-',
                '<button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md flex items-center gap-1">
                    <i class="fas fa-edit"></i> Edit
                 </button>'
            ];
        }
    @endphp

    <x-admin.admin-table :headers="$headers" :rows="$rows"/>
</div>
@endsection
