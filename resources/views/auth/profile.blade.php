@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto  p-6 rounded-lg ">
        <h2 class="text-2xl font-semibold mb-6 text-[#331111]">İstifadəçi Məlumatları</h2>
        <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
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

        <!-- My Data -->
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

                <!-- Password -->
                <div class="text-right mt-1">
                    <button type="button" onclick="openModal()"
                            class="text-[#F6A833] underline text-sm hover:text-[#947D5B] transition">
                        Forgot password?
                    </button>
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

        <!-- Company Addresses -->
        <div id="tab-company" class="tab-content hidden space-y-5">
            <div class="flex items-center">
                <label class="w-56 text-gray-800">Title</label>
                <div class="flex-1 relative">
                    <input id="address-title" type="text"
                           class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8"/>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-56 text-gray-800">Street, house</label>
                <div class="flex-1 relative">
                    <input id="address-street" type="text"
                           class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8"/>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-56 text-gray-800">Index</label>
                <div class="flex-1 relative">
                    <input id="address-zip" type="text"
                           class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8"/>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-56 text-gray-800">City</label>
                <div class="flex-1 relative">
                    <input id="address-city" type="text"
                           class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8"/>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-56 text-gray-800">Working hours</label>
                <div class="flex-1 relative">
                    <input id="address-working-hours" type="text"
                           class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8"/>
                </div>
            </div>

            <div class="flex items-center">
                <label class="w-56 text-gray-800">Default?</label>
                <input id="address-default" type="checkbox" class="w-5 h-5 ml-2"/>
            </div>

            <div class="mt-4">
                <button id="addAddressBtn"
                        class="bg-[#F6A833] text-white px-4 py-2 rounded-md hover:bg-[#947D5B] transition">
                    Add Address
                </button>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">My addresses</h2>
                <div id="addressesContainer" class="space-y-4">
                    <p class="text-gray-500">Loading addresses...</p>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div id="tab-orders" class="tab-content hidden">
            <div id="ordersContainer" class="overflow-x-auto">
                <p class="text-gray-600">Loading orders...</p>
            </div>
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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll(".tab-btn");
            const contents = document.querySelectorAll(".tab-content");

            buttons.forEach(btn => {
                btn.addEventListener("click", () => {
                    buttons.forEach(b => {
                        b.classList.remove("bg-[#FAD399]", "active");
                        b.classList.add("bg-white");
                    });

                    contents.forEach(c => c.classList.add("hidden"));

                    btn.classList.remove("bg-white");
                    btn.classList.add("bg-[#FAD399]", "active");

                    const tab = btn.dataset.tab;
                    document.getElementById("tab-" + tab).classList.remove("hidden");
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            fetch("/order", {
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("ordersContainer");
                    container.innerHTML = "";

                    if (!data || data.length === 0) {
                        container.innerHTML = `<p class="text-gray-600">You have no orders yet.</p>`;
                        return;
                    }

                    let html = `
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700 text-sm">
                        <tr>
                            <th class="px-4 py-2 text-left">Order #</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Items</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
            `;

                    data.forEach(order => {
                        let itemsHtml = order.items.map(item => `
                    <div class="flex items-center gap-2 py-1 border-b last:border-0">
                        <img src="${item.product.media[0].url}" alt="${item.product.name}" class="w-10 h-10 object-cover rounded">
                        <div>
                            <p class="font-medium">${item.product.name}</p>
                            <p class="text-xs text-gray-500">x${item.quantity}</p>
                        </div>
                    </div>
                `).join("");

                        html += `
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">${order.order_number}</td>
                        <td class="px-4 py-2">${new Date(order.created_at).toLocaleString()}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs
                                ${order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                            order.status === 'completed' ? 'bg-green-100 text-green-800' :
                                'bg-red-100 text-red-800'}">
                                ${order.status}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            ${itemsHtml}
                        </td>
                    </tr>
                `;
                    });

                    html += `</tbody></table>`;
                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error("Order fetch error:", err);
                    document.getElementById("ordersContainer").innerHTML =
                        `<p class="text-red-600">Failed to load orders.</p>`;
                });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const addressContainer = document.getElementById("addressesContainer");
            const addBtn = document.getElementById("addAddressBtn");

            function loadAddresses() {
                fetch("/addresses", {
                    headers: {"Accept": "application/json"}
                })
                    .then(res => res.json())
                    .then(data => {
                        addressContainer.innerHTML = "";

                        if (!data || data.length === 0) {
                            addressContainer.innerHTML = `<p class="text-gray-500">No addresses found.</p>`;
                            return;
                        }

                        data.forEach(addr => {
                            addressContainer.innerHTML += `
                                <div class="flex items-start justify-between gap-4 p-4 rounded-md border border-gray-200 bg-gray-50">
                                    <div class="flex gap-3">
                                        <!-- Icon -->
                                        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-[#FAD399] text-white mt-3 mr-3">
                                            <i class="fas fa-map-marker-alt text-2xl"></i>
                                        </div>
                                        <!-- Address info -->
                                        <div>
                                            <p class="font-semibold">${addr.title ?? (addr.city ?? '')}</p>
                                            <p class="font-semibold">${addr.city ?? ''}, ${addr.street ?? ''}</p>
                                            <p class="text-sm text-gray-600">Hours: ${addr.working_hours ?? '-'}</p>
                                            ${addr.is_default ? `<span class="text-xs text-green-600">Default</span>` : ""}
                                        </div>
                                    </div>
                                    <button onclick="deleteAddress(${addr.id})"
                                        class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;

                        });
                    })
                    .catch(err => {
                        console.error("Address fetch error:", err);
                        addressContainer.innerHTML = `<p class="text-red-600">Failed to load addresses.</p>`;
                    });
            }

            addBtn.addEventListener("click", () => {
                const title = document.getElementById("address-title").value;
                const street = document.getElementById("address-street").value;
                const city = document.getElementById("address-city").value;
                const zip = document.getElementById("address-zip").value;
                const workingHours = document.getElementById("address-working-hours").value;
                const isDefault = document.getElementById("address-default").checked;

                fetch("/addresses", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        title: title,
                        street: street,
                        city: city,
                        zip: zip,
                        working_hours: workingHours,
                        is_default: isDefault
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.address) {
                            loadAddresses();
                            document.getElementById("address-title").value = "";
                            document.getElementById("address-street").value = "";
                            document.getElementById("address-city").value = "";
                            document.getElementById("address-zip").value = "";
                            document.getElementById("address-working-hours").value = "";
                            document.getElementById("address-default").checked = false;
                        } else {
                            alert("Failed to add address");
                        }
                    })
                    .catch(err => console.error("Address add error:", err));
            });

            // Ünvan sil
            window.deleteAddress = function (id) {
                if (!confirm("Are you sure you want to delete this address?")) return;

                fetch(`/addresses/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Accept": "application/json"
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        loadAddresses();
                    })
                    .catch(err => console.error("Delete error:", err));
            };

            // İlk yükləmə
            loadAddresses();
        });

    </script>
@endsection
