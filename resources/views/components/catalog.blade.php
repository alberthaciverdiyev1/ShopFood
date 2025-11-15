<div class="px-24 py-7">
    <p class="text-xl font-bold text-[var(--text-color)]">Каталог</p>


    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5 mt-5 w-full">
        @foreach($categories as $category)
            <a href="{{route('list',['category' => $category['key']])}}">
                <div
                    class="border border-[#331111] rounded-[12px] bg-white w-[265px] h-[195px] flex flex-col items-center text-center pt-[34px] pb-[34px] hover:cursor-pointer">
                    <img src="{{'storage/'.$category['image']}}" alt="Category Image"
                         class="w-20 h-20 object-cover mb-4">
                    <b>{{$category['name']}}</b>
                </div>
            </a>
        @endforeach
    </div>

</div>
