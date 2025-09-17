<aside class="w-72 h-screen bg-white shadow-md flex flex-col h-min-screen ">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-[var(--text-color)]">Admin Panel</h1>
    </div>

    <nav class="flex-1 px-3 space-y-1">
        <!-- Users -->
        <a href="{{ asset(path:'/admin/users-info') }}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-user text-lg"></i>
            <span>Users</span>
        </a>

        <!-- Products (active example) -->
        <a href="{{ asset(path:'/admin/products') }}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-black font-medium relative border-l-4 border-[var(--color-primary)] bg-white">
            <i class="fa-solid fa-box text-lg"></i>
            <span>Products</span>
        </a>

        <!-- Category -->
        <a href="#"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-layer-group text-lg"></i>
            <span>Category</span>
        </a>

        <!-- Currency -->
        <a href="{{route('exchange-rates.index')}}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-dollar-sign text-lg"></i>
            <span>Currency</span>
        </a>

        <!-- Sifarişlər -->
        <a href="{{route('admin.order')}}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-cart-shopping text-lg"></i>
            <span>Sifarişlər</span>
        </a>

        <!-- Tag -->
        <a href="{{route('tags.list')}}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-tag text-lg"></i>
            <span>Tag</span>
        </a>
        <!-- Banner -->
        <a href="{{route('banners.index')}}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-image text-lg"></i>
            <span>Banner</span>
        </a>

        <a href="{{route('privacy-policy.index')}}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-shield-halved text-lg"></i>
            <span>Privacy and Policy</span>
        </a>

        <!-- Setting -->
        <a href="{{route('setting.index')}}"
           class="flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-[var(--text-grey)] hover:text-black relative border-l-4 border-transparent">
            <i class="fa-solid fa-gear text-lg"></i>
            <span>Setting</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 py-4 px-5 rounded-lg text-[15px] text-red-600 hover:text-red-700 relative border-l-4 border-transparent">
                <i class="fa-solid fa-right-from-bracket text-lg"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>
