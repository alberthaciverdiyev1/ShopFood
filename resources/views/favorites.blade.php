@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-8 ">
  <h2 class="text-2xl font-bold">@lang('Favorites')</h2>
  <div class="flex gap-8 mt-4">
      <div class="w-[15%]"> </div>

      <div class="w-[68%] border border-[#999999] p-4 rounded-2xl">
      <h3 class="text-[#331111] font-semibold  text-xl ">Your favorite products</h3>

          @foreach ($favorites as $index => $item)
              <div class="favorite-row flex gap-4 justify-between items-center pb-4 mb-4">

                  <div class="flex gap-4 items-center">
                      <div class="checkbox-wrapper-23">
                          <h2 class="font-bold text-lg">
                              {{$index+1}}
                          </h2>
                      </div>
                      <img src="{{ $item['product']['images'][0]}}" alt="{{ $item['product']['nazev'] }}" class="w-24 h-24 object-contain mt-4">
                      <div>
                          <h3 class="font-bold text-lg">{{ $item['product']['nazev'] }}</h3>
                          <p class="text-gray-600">Some description about the product. It is very good and useful.</p>
                          <p class="text-red-500 font-bold mt-2">${{ $item['product']['cenaZaklVcDph'] }}</p>
                      </div>
                  </div>

                  <div class="flex gap-4 items-center">
                      <div class="bg-white px-2 py-2 rounded-xl border border-[#FAD399] cursor-pointer remove-favorite"
                           data-product-id="{{ $item['product']['id'] }}">
                          <img class="w-6 h-6 " src="{{ asset('/images/trash.png') }}" alt="">
                      </div>
                  </div>

              </div>
          @endforeach

    </div>
    <div class="w-[15%]"> </div>

  </div>
  <x-suggestions :products="$products" />

</div>

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removeBtns = document.querySelectorAll('.remove-favorite');

        removeBtns.forEach(btn => {
            btn.addEventListener('click', async function () {
                const productId = this.dataset.productId;
                const row = this.closest('.favorite-row'); // satırı seç

                try {
                    const response = await fetch(`/favorites/delete/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (response.ok) {
                        row.remove(); // satırı DOM'dan sil
                        // Navbar favori sayısını güncelle
                        const favCountEl = document.getElementById('favoriteCount');
                        if (favCountEl) {
                            let favCount = parseInt(favCountEl.textContent);
                            favCountEl.textContent = favCount > 0 ? favCount - 1 : 0;
                        }
                    } else {
                        console.error(data.message || 'Error removing favorite.');
                    }

                } catch (error) {
                    console.error('Request failed:', error);
                }
            });
        });
    });
</script>

