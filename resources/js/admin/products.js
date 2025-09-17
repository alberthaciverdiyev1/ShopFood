
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