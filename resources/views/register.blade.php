@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg flex overflow-hidden">

        <div class="w-1/2 bg-gray-200 flex flex-col items-center justify-center p-8 relative">
            <!-- <div class="absolute top-4 left-4 flex items-center">
                <i class="fas fa-truck text-2xl mr-2 text-black"></i>
                <span class="font-bold text-lg text-[#331111]">SHOP FOOD</span>
            </div> -->
            <img src="{{ asset('/images/login-left.png') }}" alt="Register Left" class="rounded-lg shadow-lg">
        </div>

        <div class="w-1/2 p-8 flex flex-col justify-start max-h-screen overflow-y-auto">
            <h2 class="text-xl font-bold text-center mb-6 text-[#331111]">Register</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[#331111]">Company Information</label>
                    <div class="relative mt-1">
                        <i class="fas fa-building absolute left-3 top-3 text-black"></i>
                        <input type="text" name="company_name" placeholder="Company Name" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-file-invoice-dollar absolute left-3 top-3 text-black"></i>
                        <input type="text" name="vat_number" placeholder="VAT Number" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-phone-alt absolute left-3 top-3 text-black"></i>
                        <input type="tel" name="phone" placeholder="Phone Number" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-envelope absolute left-3 top-3 text-black"></i>
                        <input type="email" name="email" placeholder="Email" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                </div>

                <div>
                    <label class="block text-[#331111] mt-4">Company Address</label>
                    <div class="relative mt-1">
                        <i class="fas fa-road absolute left-3 top-3 text-black"></i>
                        <input type="text" name="street" placeholder="Street, House #" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-city absolute left-3 top-3 text-black"></i>
                        <input type="text" name="city" placeholder="City" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-flag absolute left-3 top-3 text-black"></i>
                        <input type="text" name="country" placeholder="Country" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-mail-bulk absolute left-3 top-3 text-black"></i>
                        <input type="text" name="zip" placeholder="Postal Code" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                </div>

                <div>
                    <label class="block text-[#331111] mt-4">Contact Person</label>
                    <div class="relative mt-1">
                        <i class="fas fa-user absolute left-3 top-3 text-black"></i>
                        <input type="text" name="contact_name" placeholder="First Name" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-user-tie absolute left-3 top-3 text-black"></i>
                        <input type="text" name="contact_surname" placeholder="Last Name" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                    <div class="relative mt-2">
                        <i class="fas fa-phone-alt absolute left-3 top-3 text-black"></i>
                        <input type="tel" name="contact_phone" placeholder="Phone Number" class="w-full border rounded-lg px-10 py-2 outline-none border-[#F9F9F9]">
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" name="terms" id="terms" class="mr-2">
                    <label for="terms" class="text-gray-700 text-sm">Agree to terms and conditions</label>
                </div>

                <button type="submit" class="w-full flex items-center justify-center bg-[#3D0C0C] text-white py-2 rounded-lg hover:bg-[#2b0909] mt-4">
                    <i class="fas fa-user-plus mr-2"></i> Register
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
