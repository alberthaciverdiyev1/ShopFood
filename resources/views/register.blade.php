@extends('layouts.app')

@section('content')
    @php
        $hideNavbar = true;
    @endphp

    <div class="w-full min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg flex overflow-hidden">

            <!-- LEFT SIDE -->
            <div class="w-1/2 bg-gray-200 flex flex-col items-start p-8">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="w-[140px] h-10 mr-2">
                </div>
                <div class="w-full flex justify-center">
                    <img src="{{ asset('/images/login-left.png') }}" alt="Left Image"
                         class="rounded-lg shadow-lg object-cover">
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="w-1/2 px-[120px] py-[100px] scroll-thin flex flex-col justify-start max-h-screen overflow-y-auto">

                <h2 class="text-2xl font-bold text-center mb-6 text-[#331111]">@lang("Register")</h2>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- COMPANY INFO -->
                    <div>
                        <label class="block text-[#331111] font-bold">@lang("Company name")</label>

                        <div class="relative mt-1">
                            <i class="fas fa-id-card absolute left-3 top-3 text-black"></i>
                            <input type="text" name="reg_number"
                                   placeholder="@lang('Registration number')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>

                        <div class="relative mt-2">
                            <i class="fas fa-file-invoice absolute left-3 top-3 text-black"></i>
                            <input type="text" name="tax_number"
                                   placeholder="@lang('Tax number (VAT)')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>

                        <div class="relative mt-2">
                            <i class="fas fa-phone-alt absolute left-3 top-3 text-black"></i>
                            <input type="tel" name="phone"
                                   placeholder="@lang('Phone')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]" required>
                        </div>

                        <div class="relative mt-2">
                            <i class="fas fa-envelope absolute left-3 top-3 text-black"></i>
                            <input type="email" name="email"
                                   placeholder="@lang('Email')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>
                    </div>

                    <!-- LEGAL ADDRESS -->
                    <div>
                        <label class="block font-bold text-[#331111] mt-4">@lang("Company legal address")</label>

                        <div class="relative mt-1">
                            <i class="fas fa-road absolute left-3 top-3 text-black"></i>
                            <input type="text" name="street"
                                   placeholder="@lang('Street, house')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>

                        <div class="relative mt-2">
                            <i class="fas fa-city absolute left-3 top-3 text-black"></i>
                            <input type="text" name="city"
                                   placeholder="@lang('City')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>

                        <div class="relative mt-2">
                            <i class="fas fa-flag absolute left-3 top-3 text-black"></i>
                            <input type="text" name="country"
                                   placeholder="@lang('Country')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>

                        <div class="relative mt-2">
                            <i class="fas fa-mail-bulk absolute left-3 top-3 text-black"></i>
                            <input type="text" name="zip"
                                   placeholder="@lang('Zip code')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>
                    </div>

                    <!-- CONTACT PERSON -->
                    <div>
                        <label class="block font-bold text-[#331111] mt-4">@lang("Contact person")</label>

                        <div class="relative mt-1">
                            <i class="fas fa-user absolute left-3 top-3 text-black"></i>
                            <input type="text" name="contact_name"
                                   placeholder="@lang('First name, Last name')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]">
                        </div>

                        <div class="relative mt-2">
                            <i class="fas fa-phone-alt absolute left-3 top-3 text-black"></i>
                            <input type="tel" name="contact_phone"
                                   placeholder="@lang('Phone')"
                                   class="w-full border rounded-lg px-10 py-2 outline-none border-[#CED4DA]" required>
                        </div>
                    </div>

                    <!-- TERMS -->
                    <div class="flex items-center mt-4">
                        <input type="checkbox" name="terms" id="terms" class="mr-2">
                        <label for="terms" class="text-gray-700 text-sm">
                            @lang("I agree to the terms of sale")
                        </label>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- BUTTON -->
                    <button type="submit"
                            class="w-full flex items-center justify-center bg-[#3D0C0C] text-white py-2 rounded-lg hover:bg-[#2b0909] mt-4">
                        @lang("Register")
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection
