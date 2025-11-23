@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">

        {{-- Banner Categories --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2 mt-5 w-full">
            @foreach ($banner_categories as $banner_category)
                <a href="{{ route('list',['banner_category' => $banner_category['key']]) }}">
                    <div
                        class="border border-[#331111] rounded-lg bg-white w-full h-22 flex flex-col items-center justify-center text-center p-4">
                        <img src="{{ 'storage/'. $banner_category['image'] }}" alt="{{ $banner_category['name'] }}"
                             class="w-14 h-14 object-contain">
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Categories --}}
        <div class="flex flex-wrap gap-4 mt-4">
            @forelse($categories as $i => $category)
                <div class="relative group">
                    <a href="{{ route('list',['category' => $category['key']]) }}">
                        <div
                            class="border border-[#331111] rounded-xl bg-white h-24 w-24 flex flex-col items-center justify-center text-center cursor-pointer shadow-md hover:shadow-lg hover:scale-105 hover:bg-[#331111]/5 transition-all duration-200 ease-in-out">
                            @if($category->image)
                                <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}"
                                     class="h-10 w-10 object-cover rounded-md mb-2">
                            @else
                                <div
                                    class="h-10 w-10 bg-gray-200 rounded-md flex items-center justify-center mb-2 text-gray-500">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                            <p class="text-xs font-semibold text-gray-800 truncate px-1">
                                {{ $category->name ?? 'Category ' . $i }}
                            </p>
                        </div>
                    </a>
                    <div class="absolute left-0 top-[95%] w-full h-5 bg-transparent group-hover:block"></div>

                    {{-- Subcategories Dropdown --}}
                    @if($category->children && $category->children->count() > 0)
                        <div
                            class="absolute left-1/2 -translate-x-1/2 top-[110%] hidden group-hover:flex flex-col bg-white border border-gray-200 rounded-xl shadow-2xl w-56 p-3 z-50 animate-fade-in">
                            <h4 class="text-xs font-semibold text-gray-500 mb-2 border-b border-gray-100 pb-1 uppercase tracking-wide">
                                @lang("Subcategories")
                            </h4>
                            <div class="space-y-2">
                                @foreach($category->children as $child)
                                    <a href="{{ route('list',['sub-category' => $child['key']]) }}"
                                       class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 transition group/item">
                                        @if($child->image)
                                            <img src="{{ asset('storage/'.$child->image) }}" alt="{{ $child->name }}"
                                                 class="h-9 w-9 rounded-md object-cover shadow-sm">
                                        @else
                                            <div
                                                class="h-9 w-9 rounded-md bg-gray-100 flex items-center justify-center text-gray-400">
                                                <i class="fa-regular fa-image"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate group-hover/item:text-indigo-600">
                                                {{ $child->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">@lang("Key"): {{ $child->key }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="flex items-center justify-center w-full py-10">
                    <p class="text-gray-500 text-lg font-medium">@lang("No categories found").</p>
                </div>
            @endforelse
        </div>

        {{-- Products --}}
        <div class="grid grid-cols-1 gap-6 mt-8">
            @forelse ($products as $product)
                <div
                    data-id="{{ $product['code'] }}"
                    data-title="{{ $product['name'] ?? $product['name_alt_a'] }}"
                    data-price="{{ $product['price_with_vat'] }}"
                    data-image="{{ $product['media'][0]['url'] ?? ''}}"
                    data-images='@json($product['media'] ?? [])'
                    data-description="{{ $product['description'] }}"
                    data-basket="{{ Auth::user()->basket->where('product_id', $product['code'])->first() ? 1 : 0 }}"
                    data-sku="{{ $product['barcode'] ?? '-' }}"
                    data-content="{{ $product['weight_unit'] ?? '-' }}"
                    data-unit="{{ $product['unit'] ?? '-' }}"
                    data-stock-total="{{ $product['stock_total'] ?? 0 }}"
                    data-stock-reserved="{{ $product['stock_reserved'] ?? 0 }}"
                    data-tags='@json($product['tags'] ?? [])'
                    class="openModal flex items-center bg-[#EFEFEF] rounded-lg p-4"
                >
                    <div class="w-28 h-32 flex-shrink-0 p-1 rounded-lg border-1 bg-white">
                        <img src="{{ $product['media'][0]['url'] ?? '' }}" alt="{{ $product['name'] }}"
                             class="w-full h-full object-contain rounded-lg">
                    </div>
                    <div class="flex-1 ml-4 text-gray-800">
                        <h2 class="font-semibold text-lg mb-2">
                            {{ $product['name'] }}
                            @if($product['name_alt_a'] || $product['name_alt_b'] || $product['name_alt_c'])
                                <span class="text-sm text-gray-500">
                                ({{ implode(' / ', array_filter([$product['name_alt_a'], $product['name_alt_b'], $product['name_alt_c']])) }})
                            </span>
                            @endif
                        </h2>
                        <div class="text-[14px] text-gray-600 leading-relaxed">
                            <p>SKU: {{ $product['barcode'] ?? '-' }}</p>
                            <p>Content: {{ $product['weight_unit'] ?? '-' }}</p>
                            <p>Per Box: {{ $product['unit'] ?? '-' }}</p>
                            <p>Boxes per Pallet: {{ $product['stock_total'] ?? 0 }}</p>
                            <p>Box per Layer: {{ $product['stock_reserved'] ?? 0 }}</p>

                            @if($product['tags'])
                                <p>Tags:
                                    @foreach($product['tags'] as $tag)
                                        <span class="bg-gray-200 text-gray-700 px-1 rounded mr-1">{{ $tag }}</span>
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Price & Buttons --}}
                    <div class="text-right ml-4 min-w-[140px]">
                        <div class="flex flex-wrap gap-2 justify-end mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button
                                    class="w-8 h-8 flex items-center justify-center border border-[#FC9700] text-[#FC9700] bg-white rounded-md text-sm">
                                    +{{ $i }}
                                </button>
                            @endfor
                        </div>

                        <p class="text-2xl text-red-500 font-bold mt-3">
                            {{ number_format($product['price_with_vat'], 2) }}
                        </p>
                        <div class="mt-2 text-sm text-gray-800">
                            <p><strong>@lang("Selected"):</strong> 5</p>
                            <p><strong>@lang("Sum"):</strong> {{ number_format($product['price_with_vat'] * 5, 2) }}</p>
                        </div>
                    </div>
                </div>

                <x-modal-product-details :product="$product"/>

            @empty
                <div class="flex items-center justify-center w-full py-16">
                    <p class="text-gray-500 text-lg font-semibold">@lang("No products found").</p>
                </div>
            @endforelse
        </div>

        @if($products->count() > 0)
            <div class="pagination my-6">
                @if($products->onFirstPage())
                    <button disabled><<</button>
                @else
                    <a href="{{ $products->previousPageUrl() }}"><button><<</button></a>
                @endif

                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <a href="{{ $url }}">
                        <button class="{{ $products->currentPage() == $page ? 'active' : '' }}">
                            {{ $page }}
                        </button>
                    </a>
                @endforeach

                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"><button>>></button></a>
                @else
                    <button disabled>>></button>
                @endif
            </div>
        @endif
    </div>

    <style>
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(8px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.25s ease-in-out; }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        .pagination button {
            padding: 5px 8px;
            margin: 0 5px;
            background: white;
            border: 1px solid black;
            border-radius: 2px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .pagination button:hover { background: #f5f7fa; }
        .pagination button.active {
            background: black;
            color: white;
            border-color: white;
        }
    </style>

@endsection

@section('scripts')
    @vite('resources/js/home.js')
@endsection
