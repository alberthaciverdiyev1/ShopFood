
@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg flex overflow-hidden">

        <div class="w-1/2 bg-gray-200 flex flex-col items-center justify-center p-8 relative">
            <img src="{{ asset('/images/login-left.png') }}" alt="Login Left" class="rounded-lg shadow-lg">
            <!-- <div class="absolute top-4 left-4 flex items-center">
                <i class="fas fa-truck text-2xl mr-2"></i>
                <span class="font-bold text-lg">SHOP FOOD</span>
            </div> -->
        </div>

        <div class="w-1/2 p-12 flex flex-col justify-center">
            <h2 class="text-xl font-bold text-center mb-6">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet aliquid enim tempore sequi laboriosam ullam veritatis omnis vitae aut voluptatum!
            </h2>

            <p class="text-center mb-6 text-gray-600">Пожалуйста, войдите</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div class="flex flex-col">
                    <div class="flex items-center border rounded-lg px-3 py-2">
                        <i class="fas fa-user text-gray-500 mr-3"></i>
                        <input type="text" name="email" placeholder="Email" class="w-full outline-none" value="{{ old('email') }}" required>
                    </div>

                </div>

                <div class="flex flex-col">
                    <div class="flex items-center border rounded-lg px-3 py-2 relative">
                        <i class="fas fa-lock text-gray-500 mr-3"></i>
                        <input type="password" name="password" placeholder="Пароль" class="w-full outline-none" required>
                        <i class="fas fa-eye text-gray-400 cursor-pointer absolute right-3"></i>
                    </div>
                </div>

                <a href="/register" class="">Didn't have an account?</a>

                <button type="submit"
                        class="mt-3 w-full bg-[#3D0C0C] text-white py-2 rounded-lg hover:bg-[#2b0909]">
                    Войти
                </button>

                @if ($errors->has('email'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('email') }}</p>
                @endif
            </form>

        </div>

    </div>
</div>
</div>
@endsection
