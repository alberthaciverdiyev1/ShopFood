@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">

        <h2 class="text-2xl font-semibold mb-6 text-[#331111]">İstifadəçi Məlumatları</h2>

        @php
            $user = auth()->user();
        @endphp

            <!-- Tabs -->
        <div class="flex gap-4 mb-8">
            <button
                class="tab-btn active flex items-center gap-2 px-5 py-3 rounded-md text-black font-medium border border-[#E5E5E5] bg-[#FAD399]"
                data-tab="data">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M5.121 17.804A11.955 11.955 0 0112 15c2.21 0 4.262.597 6.012 1.633M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                My Data
            </button>
            <button
                class="tab-btn flex items-center gap-2 px-5 py-3 rounded-md bg-white text-black font-medium border border-[#E5E5E5]"
                data-tab="company">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657-5.657L2.343 12.757a8 8 0 1011.314 11.314l4.243-4.243a8 8 0 001.757-2.171z"/>
                </svg>
                Company Addresses
            </button>
            <button
                class="tab-btn flex items-center gap-2 px-5 py-3 rounded-md bg-white text-black font-medium border border-[#E5E5E5]"
                data-tab="orders">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6M5 8h14M5 12h.01M5 16h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Order History
            </button>
        </div>

        <!-- Tabs Content -->
        <div id="tab-data" class="tab-content space-y-4">
            <form class="space-y-4" action="{{ route('profile.update',['id'=>$user->id]) }}" method="POST">
                @csrf
                @php
                    $fields = [
                        ['label'=>'Email', 'name'=>'email', 'value'=>$user->email, 'editable'=>true],
                        ['label'=>'Street', 'name'=>'street', 'value'=>$user->street, 'editable'=>true],
                        ['label'=>'City', 'name'=>'city', 'value'=>$user->city, 'editable'=>true],
                        ['label'=>'Country', 'name'=>'country', 'value'=>$user->country, 'editable'=>true],
                        ['label'=>'Zip Code', 'name'=>'zip', 'value'=>$user->zip, 'editable'=>true],
                        ['label'=>'Name and Surname', 'name'=>'contact_name', 'value'=>$user->contact_name, 'editable'=>true],
                        ['label'=>'Contact Phone', 'name'=>'contact_phone', 'value'=>$user->contact_phone, 'editable'=>true],
                        ['label'=>'Reg Number', 'name'=>'reg_number', 'value'=>$user->reg_number, 'editable'=>false],
                        ['label'=>'Tax Number', 'name'=>'tax_number', 'value'=>$user->tax_number, 'editable'=>false],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div class="relative">
                        <label class="block text-gray-700 font-medium mb-1">{{ $field['label'] }}</label>
                        <input type="{{ $field['name'] == 'email' ? 'email' : 'text' }}"
                               name="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 pr-24 {{ $field['editable'] ? 'bg-gray-100' : 'bg-gray-200 cursor-not-allowed' }}"
                            {{ $field['editable'] ? 'readonly' : 'disabled' }}>
                        @if($field['editable'])
                            <div class="absolute right-2 top-9 flex gap-2">
                                <button type="button" onclick="enableEdit(this)"
                                        class="text-gray-400 hover:text-[#F6A833]" title="Edit">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button type="button" onclick="saveEdit(this)"
                                        class="hidden text-green-600 hover:text-green-800" title="Save">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" onclick="cancelEdit(this)"
                                        class="hidden text-red-600 hover:text-red-800" title="Cancel">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Şifrə -->
                <div>
                    {{--                <label class="block text-gray-700 font-medium mb-1">Şifrə</label>--}}
                    {{--                <input type="password" value="********" class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed" readonly>--}}
                    <div class="text-right mt-1">
                        <button type="button" onclick="openModal()"
                                class="text-[#F6A833] underline text-sm hover:text-[#947D5B] transition">
                            Forgot password?
                        </button>
                    </div>
                </div>

                <!-- Save form -->
                <div class="flex items-center gap-3 mt-4">
                    <button type="submit"
                            class="bg-[#F6A833] text-white px-4 py-2 rounded-md hover:bg-[#947D5B] transition">
                        Yadda saxla
                    </button>
                </div>
            </form>
        </div>

        <!-- Company Addresses tab -->
        <div id="tab-company" class="tab-content hidden">
            <!-- Burada Company Addresses məlumatlarını əlavə et -->
            <p class="text-gray-500">Company Addresses content goes here.</p>
        </div>

        <!-- Order History tab -->
        <div id="tab-orders" class="tab-content hidden">
            <!-- Burada Order History məlumatlarını əlavə et -->
            <p class="text-gray-500">Order History content goes here.</p>
        </div>

    </div>

    <!-- Modal -->
    <div id="forgotModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            <h3 class="text-lg font-semibold mb-3">Link göndərildi</h3>
            <p class="text-gray-600 mb-4">Şifrənizi bərpa etmək üçün emailinizə link göndərildi.</p>
            <button onclick="closeModal()"
                    class="bg-[#F6A833] text-white px-4 py-2 rounded-md hover:bg-[#947D5B] transition">
                Bağla
            </button>
        </div>
    </div>

@endsection

@section('scripts')
    @vite('resources/js/profile.js')
@endsection

