@extends('layouts.app')

@section('content')
@php
    $hideNavbar = true;
@endphp

<div class="min-h-screen pt-5 bg-gray-200 flex items-center justify-center">
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg flex overflow-hidden">

        <div class="w-1/2 bg-gray-200 flex flex-col items-start p-8">
            <div class="flex items-center mb-4">
                <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="w-[140px] h-10 mr-2">
            </div>

            <div class="w-full flex justify-center">
                <img src="{{ asset('/images/login-left.png') }}" alt="Left Image" class="rounded-lg shadow-lg object-cover">
            </div>

        </div>

        <div class="w-1/2 bg-white px-[120px] py-[100px] flex flex-col justify-center">
            <h2 class="text-3xl font-semibold text-center" style="color: #333333; line-height: 100%; margin-bottom: 80px;">
                Продажа только зарегистрированным предпринимателям
            </h2>

            <p class="text-center font-bold" style="color: #331111; margin-bottom: 20px;">
                Пожалуйста, войдите
            </p>

            <form method="POST" action="{{ route('login') }}" class="flex flex-col space-y-4">
                @csrf

                <div class="flex items-center rounded-lg px-3 py-3" style="background-color: #F9F9F9; border: 1px solid #CED4DA;">
                    <i class="fas fa-user mr-3" style="color: black;"></i>
                    <input type="text" name="username" placeholder="Имя пользователя"
                        class="w-full outline-none placeholder-gray-500 text-sm bg-transparent" required>
                </div>

                <div class="flex items-center rounded-lg px-3 py-3 relative" style="background-color: #F9F9F9; border: 1px solid #CED4DA;">
                    <i class="fas fa-lock mr-3" style="color: black;"></i>
                    <input type="password" name="password" placeholder="Пароль"
                        class="w-full outline-none placeholder-gray-500 text-sm bg-transparent" required>
                    <i class="fas fa-eye cursor-pointer absolute right-3" style="color: black;"></i>
                </div>

                <button type="submit"
                    class="w-full py-3 mt-3 text-white rounded-lg hover:bg-[#2b0909] transition"
                    style="background-color: #3D0C0C;">
                    Войти
                </button>

                <a href="{{ route('register') }}"
                    class="w-full py-3 mt-3 text-center rounded-lg transition block"
                    style="border: 1px solid #3D0C0C; color: #3D0C0C; background-color: white;"
                    onmouseover="this.style.backgroundColor='#2b0909'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='white'; this.style.color='#3D0C0C';">
                    Зарегистрироваться
                </a>

            </form>

        </div>
    </div>
</div>
@endsection
