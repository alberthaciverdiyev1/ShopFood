@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-semibold mt-6 mb-6">Profile</h1>

    <div class="flex gap-4 mb-8">
        <button class="tab-btn active flex items-center gap-2 px-5 py-3 rounded-md text-black font-medium border border-[#E5E5E5] bg-[#FAD399]" data-tab="data">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M5.121 17.804A11.955 11.955 0 0112 15c2.21 0 4.262.597 6.012 1.633M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            My Data
        </button>
        <button class="tab-btn flex items-center gap-2 px-5 py-3 rounded-md bg-white text-black font-medium border border-[#E5E5E5]" data-tab="company">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657-5.657L2.343 12.757a8 8 0 1011.314 11.314l4.243-4.243a8 8 0 001.757-2.171z" />
            </svg>
            Company Addresses
        </button>
        <button class="tab-btn flex items-center gap-2 px-5 py-3 rounded-md bg-white text-black font-medium border border-[#E5E5E5]" data-tab="orders">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6M5 8h14M5 12h.01M5 16h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Order History
        </button>
    </div>

    <div id="tab-data" class="tab-content space-y-5">
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Company Registration Number</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->reg_number }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">VAT Number</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->tax_number }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Phone</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->phone }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Email</label>
            <div class="flex-1 relative">
                <input type="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Street</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->street }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">City</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->city }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Country</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->country }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Zip Code</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->zip }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Contact Name</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->contact_name }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Contact Phone</label>
            <div class="flex-1 relative">
                <input type="text" value="{{ $user->contact_phone }}" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8 bg-gray-100" readonly />
            </div>
        </div>
    </div>

    <div id="tab-company" class="tab-content hidden space-y-5">
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Street, house</label>
            <div class="flex-1 relative">
                <input type="text" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8" />
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Index</label>
            <div class="flex-1 relative">
                <input type="text" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8" />
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">City</label>
            <div class="flex-1 relative">
                <input type="text" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8" />
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex items-center">
            <label class="w-56 text-gray-800">Working hours</label>
            <div class="flex-1 relative">
                <input type="text" class="w-full border border-gray-300 rounded-md py-2.5 px-4 pr-8" />
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">My addresses</h2>
            <div class="space-y-4">
                <div class="flex items-start gap-4 p-4 rounded-md border border-gray-200 bg-gray-50">
                    <div class="mt-1 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#FAD399]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657-5.657L2.343 12.757a8 8 0 1011.314 11.314l4.243-4.243a8 8 0 001.757-2.171z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Office</p>
                        <p class="text-sm text-gray-600">Москва, Пресненская набережная, д. 12, Башня «Федерация», офис 4501</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-md border border-gray-200 bg-gray-50">
                    <div class="mt-1 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#FAD399]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657-5.657L2.343 12.757a8 8 0 1011.314 11.314l4.243-4.243a8 8 0 001.757-2.171z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Office</p>
                        <p class="text-sm text-gray-600">Санкт-Петербург, Невский проспект, д. 28, лит. А, офис 207</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-md border border-gray-200 bg-gray-50">
                    <div class="mt-1 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#FAD399]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657-5.657L2.343 12.757a8 8 0 1011.314 11.314l4.243-4.243a8 8 0 001.757-2.171z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Office</p>
                        <p class="text-sm text-gray-600">Казань, ул. Баумана, д. 17, офис 312</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tab-orders" class="tab-content hidden">
        <div id="ordersContainer" class="overflow-x-auto">
            <p class="text-gray-600">Loading orders...</p>
        </div>
    </div>
</div>

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
                        <img src="${item.product.images[0]}" alt="${item.product.nazev}" class="w-10 h-10 object-cover rounded">
                        <div>
                            <p class="font-medium">${item.product.nazev}</p>
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
@endsection
