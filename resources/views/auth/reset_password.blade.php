@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-semibold mb-6 text-[#331111]">Şifrəni Bərpa Et</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label class="block text-gray-700 font-medium mb-1">Yeni Şifrə</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Şifrəni Təsdiqlə</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-[#F6A833] text-white px-4 py-2 rounded-md hover:bg-[#947D5B] transition">
                    Şifrəni Yenilə
                </button>
            </div>
        </form>
    </div>
@endsection
