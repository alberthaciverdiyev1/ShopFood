<!-- Modal HTML -->
<div id="overlay" class="fixed inset-0 bg-black/50 z-20 flex items-center justify-center hidden p-4">
    <div id="modal"
         class="bg-[#EFEFEF] w-full max-w-5xl rounded-3xl shadow-2xl flex flex-col md:flex-row gap-6 p-6 md:p-8 z-30">

        <!-- Left side -->
        <div class="md:w-1/2 flex flex-col items-center">
            <div class="relative w-full">
                <img id="modalImage" class="bg-white rounded-xl w-full h-auto object-contain max-h-[400px]"
                     src="{{ asset('/images/product.png') }}" alt="Product Image">
            </div>

            <div id="modalThumbs" class="flex gap-2 mt-4 overflow-x-auto w-full"></div>
        </div>

        <!-- Right side -->
        <div class="md:w-1/2 flex flex-col gap-4">

            <h3 id="modalTitle" class="text-lg font-bold">Məhsul Adı</h3>
            <input type="hidden" id="modalProductId"/>

            <p id="modalPrice" class="text-red-500 text-xl md:text-3xl font-bold">₼12.50</p>

            <div id="modalDetails" class="text-sm md:text-base text-gray-700 leading-6">
                <p><strong>SKU:</strong> <span id="modalSKU">PRD-00123</span></p>
                <p><strong>Content:</strong> <span id="modalContent">500ml</span></p>
                <p><strong>Per Box:</strong> <span id="modalUnit">12</span></p>
                <p><strong>Boxes per Pallet:</strong> <span id="modalStockTotal">80</span></p>
                <p><strong>Box per Layer:</strong> <span id="modalStockReserved">10</span></p>
                <div id="modalTags" class="flex flex-wrap gap-2 mt-1"></div>
            </div>

            <p id="modalDescription" class="text-sm md:text-base text-gray-700 leading-6">
                Bu məhsul yüksək keyfiyyətli materiallardan hazırlanmışdır.
            </p>

            <!-- UNIT SELECTOR -->
            <div class="mt-3">
                <p class="font-semibold text-gray-700 mb-2">Seçim:</p>

                <div class="grid grid-cols-2 gap-4">

                    <div
                        class="unit-card cursor-pointer
                                border-2 border-[#FC9700]
                                bg-orange-50
                                rounded-xl
                                py-3 px-4 text-center
                                shadow-sm
                                transition-all duration-200"
                        data-unit="piece">

                        <p class="font-bold text-gray-800 text-sm sm:text-base">
                            Unit
                        </p>
                    </div>

                    <div
                        class="unit-card cursor-pointer
                                border-2 border-gray-200
                                rounded-xl
                                py-3 px-4 text-center
                                bg-white
                                shadow-sm
                                hover:border-[#FC9700] hover:bg-orange-50
                                transition-all duration-200"
                        data-unit="box">

                        <p class="font-bold text-gray-800 text-sm sm:text-base">
                            Karton
                        </p>
                    </div>

                </div>

                <p id="unitInfo" class="mt-3 text-sm text-gray-600"></p>
            </div>

            <div id="qtySection" class="mt-4 flex items-center gap-3 hidden">

                <button id="qtyMinus"
                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-xl hover:bg-gray-100 text-lg">
                    −
                </button>

                <input id="qtyInput" type="number" min="1" value="1"
                       class="w-20 text-center border border-gray-300 rounded-xl py-2 focus:ring-[#FC9700]"/>

                <button id="qtyPlus"
                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-xl hover:bg-gray-100 text-lg">
                    +
                </button>
            </div>

            <p id="unitWarning" class="text-red-500 text-sm mt-1"></p>

            <!-- TOTAL -->
            <div class="flex flex-col md:flex-row gap-4 mt-3 text-gray-800">
                <p>Выбрано: <span id="modalSelected" class="font-bold">10</span></p>
                <p>Сумма: <span id="modalTotal" class="font-bold">₼0.00</span></p>
            </div>

            <!-- BUTTONS -->
            <div class="flex gap-4 mt-4">
                <button id="addBasket" data-type="unit" class="flex-1 py-3 border rounded-2xl bg-white hover:bg-gray-100">
                    Add to Basket
                </button>
                <button
                    class="favorite-btn p-3 border text-[#FC9700] rounded-2xl bg-white hover:bg-orange-300 flex justify-center items-center">
                    <i class="fa fa-heart text-[#FC9700]"></i>
                </button>
            </div>

        </div>
    </div>
</div>


<script>
    const modal = document.getElementById("modal");
    const overlay = document.getElementById("overlay");

    let selectedUnit = null;

    function resetModalState() {
        selectedUnit = null;

        const unitCards = modal.querySelectorAll(".unit-card");
        const qtyInput = modal.querySelector("#qtyInput");
        const qtySection = modal.querySelector("#qtySection");
        const unitInfo = modal.querySelector("#unitInfo");
        const totalEl = modal.querySelector("#modalTotal");
        const selectedEl = modal.querySelector("#modalSelected");
        const warning = modal.querySelector("#unitWarning");

        unitCards.forEach(c => {
            c.classList.remove("border-[#FC9700]", "bg-orange-50");
            c.classList.add("border-gray-200", "bg-white");
        });

        qtySection.classList.add("hidden");

        qtyInput.min = 1;
        qtyInput.value = 1;

        selectedEl.textContent = "1";
        totalEl.textContent = "₼0.00";
        unitInfo.innerHTML = "";
        if (warning) warning.textContent = "";
    }

    function activateUnitCard(card) {
        const unitCards = modal.querySelectorAll(".unit-card");

        unitCards.forEach(c => {
            c.classList.remove("border-[#FC9700]", "bg-orange-50");
            c.classList.add("border-gray-200", "bg-white");
        });

        card.classList.remove("border-gray-200", "bg-white");
        card.classList.add("border-[#FC9700]", "bg-orange-50");
    }


    document.querySelectorAll(".openModal").forEach(btn => {
        btn.addEventListener("click", () => {

            resetModalState();
            overlay.classList.remove("hidden");

            const productData = {
                price: parseFloat(btn.dataset.price) || 0,
                min_quantity: parseInt(btn.dataset.minQuantity) || 1,
                per_box: parseInt(btn.dataset.perBox) || 1,
                per_crate: parseInt(btn.dataset.perCrate) || 1,
                per_pallet: parseInt(btn.dataset.perPallet) || 1
            };

            const unitCards = modal.querySelectorAll(".unit-card");
            const qtyInput = modal.querySelector("#qtyInput");
            const qtySection = modal.querySelector("#qtySection");
            const unitInfo = modal.querySelector("#unitInfo");
            const totalEl = modal.querySelector("#modalTotal");
            const selectedEl = modal.querySelector("#modalSelected");
            const warning = modal.querySelector("#unitWarning");

            let currentPrice = productData.price;

            function updateTotal() {
                const qty = parseInt(qtyInput.value) || 1;
                const total = qty * currentPrice;

                selectedEl.textContent = qty;
                totalEl.textContent = `₼${total.toFixed(2)}`;
            }

            qtyInput.min = productData.min_quantity;
            qtyInput.value = productData.min_quantity;

            unitInfo.innerHTML =
                `Minimum alış miqdarı: <strong>${productData.min_quantity}</strong> ədəd`;

            updateTotal();


            unitCards.forEach(card => {
                card.onclick = () => {

                    selectedUnit = card.dataset.unit;

                    warning.textContent = "";
                    activateUnitCard(card);
                    qtySection.classList.remove("hidden");

                    const unit = card.dataset.unit;

                    const addBasketBtn = modal.querySelector("#addBasket");
                    addBasketBtn.dataset.type = unit;

                    switch (unit) {
                        case "piece":
                            currentPrice = productData.price;
                            qtyInput.min = productData.min_quantity;
                            qtyInput.value = productData.min_quantity;
                            unitInfo.innerHTML =
                                `Minimum alış miqdarı: <strong>${productData.min_quantity}</strong> ədəd`;
                            break;

                        case "box":
                            currentPrice = productData.price * productData.per_box;
                            qtyInput.min = 1;
                            qtyInput.value = 1;
                            unitInfo.innerHTML =
                                `Bir qutuda <strong>${productData.per_box}</strong> ədəd var`;
                            break;
                    }

                    updateTotal();
                };
            });


            modal.querySelector("#qtyPlus").onclick = () => {
                if (!selectedUnit) {
                    warning.textContent = "Önce seçim edin.";
                    return;
                }

                qtyInput.value = parseInt(qtyInput.value) + 1;
                updateTotal();
            };


            modal.querySelector("#qtyMinus").onclick = () => {
                if (!selectedUnit) {
                    warning.textContent = "Önce seçim edin.";
                    return;
                }

                if (parseInt(qtyInput.value) > parseInt(qtyInput.min)) {
                    qtyInput.value = parseInt(qtyInput.value) - 1;
                    updateTotal();
                }
            };


            qtyInput.oninput = () => {
                if (!selectedUnit) {
                    warning.textContent = "Önce seçim edin.";
                    qtyInput.value = qtyInput.min;
                    return;
                }
                updateTotal();
            };
        });
    });


    overlay.addEventListener("click", e => {
        if (e.target === overlay) {
            overlay.classList.add("hidden");
            resetModalState();
        }
    });
</script>
