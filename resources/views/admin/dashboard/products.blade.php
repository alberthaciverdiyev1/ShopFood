@extends('admin.dashboard.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-3xl font-bold mb-6">Products</h2>

    @php
        $headers = ['#', 'Image', 'Name', 'Price', 'Discounted Price', 'Actions'];
        $rows = [];
        $i = 1; 
        foreach ($products as $product) {
            $discount = $product['discounted_price'] ?? null;
            $rows[] = [
                $i++, 
                '<img src="'.($product['images'][0] ?? $product['image']).'" 
                      class="w-20 h-20 object-contain mx-auto rounded-md" 
                      alt="'.$product['nazev'].'">',
                $product['nazev'],
                "$".$product['cenaZaklVcDph'],
                $discount 
                    ? '<span class="text-red-600 font-bold">$'.$discount.'</span> 
                       <span class="line-through text-gray-400 ml-2">$'.$product['cenaZaklVcDph'].'</span>' 
                    : '-',
                '<div class="flex gap-2">
                    <button 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-md flex items-center gap-1 details-btn"
                        data-product=\''.json_encode($product).'\'>
                        <i class="fas fa-info-circle"></i> Details
                    </button>
                    <button 
                        class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-md flex items-center gap-1 open-modal-btn"
                        data-id="'.$product['id'].'"
                        data-name="'.$product['nazev'].'"
                        data-price="'.$product['cenaZaklVcDph'].'"
                        data-discount="'.$discount.'"
                        data-image="'.($product['images'][0] ?? $product['image']).'"
                    >
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>'
            ];
        }
    @endphp

    <x-admin.admin-table :headers="$headers" :rows="$rows"/>

    <div id="detailsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white w-[500px] p-6 rounded-lg shadow-lg relative">
            <button id="detailsModalClose" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl">&times;</button>
            <h2 class="text-xl font-bold mb-4">Product Details</h2>
            <div id="detailsModalContent"></div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white w-[500px] p-6 rounded-lg shadow-lg relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl">&times;</button>
            <h2 class="text-xl font-bold mb-4">Edit Product</h2>

            <form id="editForm" class="space-y-4">
                <div>
                    <label class="block font-semibold">Name</label>
                    <div class="flex items-center border rounded-md px-2">
                        <input type="text" id="editName" class="flex-1 p-2 outline-none" disabled>
                        <i class="fas fa-pen text-gray-500 cursor-pointer ml-2 toggle-edit"></i>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold">Price</label>
                    <div class="flex items-center border rounded-md px-2">
                        <input type="text" id="editPrice" class="flex-1 p-2 outline-none" disabled>
                        <i class="fas fa-pen text-gray-500 cursor-pointer ml-2 toggle-edit"></i>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold">Discounted Price</label>
                    <div class="flex items-center border rounded-md px-2">
                        <input type="text" id="editDiscount" class="flex-1 p-2 outline-none" disabled>
                        <i class="fas fa-pen text-gray-500 cursor-pointer ml-2 toggle-edit"></i>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold">Image</label>
                    <img id="editImage" class="w-32 h-32 object-contain rounded-md border">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="saveBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    const detailsModal = document.getElementById("detailsModal");
    const detailsContent = document.getElementById("detailsModalContent");
    const detailsClose = document.getElementById("detailsModalClose");

    document.querySelectorAll(".details-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const product = JSON.parse(btn.dataset.product);

            detailsContent.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <img src="${product.images[0] ?? product.image}" class="w-full h-40 object-contain rounded-md" alt="${product.nazev}">
                    </div>
                    <div class="space-y-2">
                        <p><strong>Name:</strong> ${product.nazev}</p>
                        <p><strong>Price:</strong> $${product.cenaZaklVcDph}</p>
                        <p><strong>Discounted Price:</strong> ${product.discounted_price ?? '-'}</p>
                        <p><strong>Description:</strong> ${product.popis ?? 'No description'}</p>
                    </div>
                </div>
            `;
            detailsModal.classList.remove("hidden");
        });
    });

    detailsClose.addEventListener("click", () => detailsModal.classList.add("hidden"));
    window.addEventListener("click", e => { if(e.target === detailsModal) detailsModal.classList.add("hidden"); });

    const modal = document.getElementById("editModal");
    const closeModal = document.getElementById("closeModal");
    const openButtons = document.querySelectorAll(".open-modal-btn");

    const editName = document.getElementById("editName");
    const editPrice = document.getElementById("editPrice");
    const editDiscount = document.getElementById("editDiscount");
    const editImage = document.getElementById("editImage");

    openButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            editName.value = this.dataset.name;
            editPrice.value = this.dataset.price;
            editDiscount.value = this.dataset.discount || "";
            editImage.src = this.dataset.image;

            modal.classList.remove("hidden");
        });
    });

    closeModal.addEventListener("click", () => modal.classList.add("hidden"));
    window.addEventListener("click", e => { if(e.target === modal) modal.classList.add("hidden"); });

    document.querySelectorAll(".toggle-edit").forEach(icon => {
        icon.addEventListener("click", function () {
            const input = this.previousElementSibling;
            input.disabled = !input.disabled;
            if (!input.disabled) {
                input.focus();
                this.classList.add("text-blue-500");
            } else {
                this.classList.remove("text-blue-500");
            }
        });
    });

    document.getElementById("saveBtn").addEventListener("click", () => {
        alert("");
        modal.classList.add("hidden");
    });
});
</script>
