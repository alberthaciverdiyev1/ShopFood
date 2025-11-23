document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById("overlay");
    const modal = document.getElementById("modal");
    const modalTitle = document.getElementById("modalTitle");
    const modalPrice = document.getElementById("modalPrice");
    const modalImage = document.getElementById("modalImage");
    const modalThumbsContainer = document.getElementById("modalThumbs");
    const modalDescription = document.getElementById("modalDescription");
    const modalProductInput = document.getElementById('modalProductId');
    const addButton = document.getElementById('addBasket');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const modalSKU = document.getElementById('modalSKU');
    const modalContent = document.getElementById('modalContent');
    const modalUnit = document.getElementById('modalUnit');
    const modalStockTotal = document.getElementById('modalStockTotal');
    const modalStockReserved = document.getElementById('modalStockReserved');
    const modalTagsContainer = document.getElementById('modalTags');
    const modalSelected = document.getElementById('modalSelected');
    const modalTotal = document.getElementById('modalTotal');
    const favCountEl = parseInt(document.getElementById('favoriteCount').textContent.trim());

    const openModalButtons = document.querySelectorAll(".openModal");

    async function getUserFavorites() {
        try {
            const res = await fetch('/favorites/list/ajax', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            return data.map(item => item.product_id);
        } catch (err) {
            console.error('Favorileri yüklerken hata:', err);
            return [];
        }
    }

    let favoriteIds = [];
    getUserFavorites().then(ids => favoriteIds = ids);

    openModalButtons.forEach(button => {
        button.addEventListener("click", () => {
            const title = button.dataset.title;
            const price = parseFloat(button.dataset.price) || 0;
            const image = button.dataset.image;
            const thumbnailsJson = button.dataset.images;
            const description = button.dataset.description;
            const modalProductId = button.dataset.id;
            const basket = +button.dataset.basket;

            const sku = button.dataset.sku || '-';
            const content = button.dataset.content || '-';
            const unit = button.dataset.unit || '-';
            const stockTotal = button.dataset.stocktotal || 0;
            const stockReserved = button.dataset.stockreserved || 0;
            const tags = JSON.parse(button.dataset.tags || '[]');

            const images = JSON.parse(thumbnailsJson || "[]");
            modalThumbsContainer.innerHTML = '';
            images.forEach(img => {
                const imgEl = document.createElement('img');
                imgEl.src = img.url;
                imgEl.classList.add('w-20', 'h-20', 'rounded-xl', 'cursor-pointer');
                imgEl.addEventListener('click', () => { modalImage.src = img.url; });
                modalThumbsContainer.appendChild(imgEl);
            });

            modalTitle.textContent = title;
            modalPrice.textContent = `$${price.toFixed(2)}`;
            modalImage.src = image;
            modalDescription.textContent = description;
            modalProductInput.value = modalProductId;

            modalSKU.textContent = sku;
            modalContent.textContent = content;
            modalUnit.textContent = unit;
            modalStockTotal.textContent = stockTotal;
            modalStockReserved.textContent = stockReserved;

            modalTagsContainer.innerHTML = '';
            tags.forEach(tag => {
                const span = document.createElement('span');
                span.className = 'bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-semibold';
                span.textContent = tag;
                modalTagsContainer.appendChild(span);
            });

            addButton.dataset.basket = basket ? '1' : '0';
            addButton.textContent = basket ? 'Remove from Basket' : 'Add to Basket';
            addButton.style.backgroundColor = basket ? 'orange' : '';

            const favBtn = modal.querySelector('.favorite-btn');
            favBtn.dataset.productId = modalProductId;
            if (favoriteIds.includes(modalProductId)) {
                favBtn.classList.add('favorited');
                favBtn.innerHTML = '<i class="fa fa-heart text-red-500"></i>';
            } else {
                favBtn.classList.remove('favorited');
                favBtn.innerHTML = '<i class="fa fa-heart text-[#FC9700]"></i>';
            }

            const defaultCount = 1;
            modalSelected.textContent = defaultCount;
            modalTotal.textContent = (price * defaultCount).toFixed(2);

            overlay.classList.remove("hidden");
        });
    });

    overlay.addEventListener("click", (e) => { if (e.target === overlay) overlay.classList.add("hidden"); });

    modal.querySelectorAll('.countBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const count = parseInt(btn.dataset.count);
            modalSelected.textContent = count;
            const price = parseFloat(modalPrice.textContent.replace('$','')) || 0;
            modalTotal.textContent = (price * count).toFixed(2);
        });
    });

    addButton.addEventListener('click', function() {
        const productId = modalProductInput.value;
        const basket = addButton.dataset.basket === '1';
        const type = addButton.dataset.type;
        const box_items_count = +addButton.dataset.boxitemscount;
console.log(basket, type, box_items_count);
        const url = basket ? `/basket/remove/${productId}` : `/basket/add/${productId}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ quantity: parseInt(modalSelected.textContent), type, box_items_count})
        })
            .then(response => response.json())
            .then(data => {
                if (basket) {
                    addButton.dataset.basket = '0';
                    addButton.textContent = 'Add to Basket';
                    addButton.style.backgroundColor = '';
                    document.querySelector(`[data-id="${productId}"]`).dataset.basket = '0';
                } else {
                    addButton.dataset.basket = '1';
                    addButton.textContent = 'Remove from Basket';
                    addButton.style.backgroundColor = 'orange';
                    document.querySelector(`[data-id="${productId}"]`).dataset.basket = '1';
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Favorite buton click
    modal.addEventListener('click', async function(e) {
        const btn = e.target.closest('.favorite-btn');
        if (!btn) return;

        e.stopPropagation();
        const productId = btn.dataset.productId;
        const isFavorited = btn.classList.contains('favorited');

        try {
            const url = isFavorited ? `/favorites/delete/${productId}` : `/favorites/add/${productId}`;
            const method = isFavorited ? 'DELETE' : 'POST';

            const response = await fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            if (response.ok) {
                const favCountEl = document.getElementById('favoriteCount');
                let favCount = parseInt(favCountEl.textContent.trim());

                if (isFavorited) {
                    btn.classList.remove('favorited');
                    btn.innerHTML = '<i class="fa fa-heart text-[#FC9700]"></i>';
                    favoriteIds = favoriteIds.filter(id => id !== productId);

                    // favori sayısını bir azalt
                    favCount = Math.max(favCount - 1, 0);
                } else {
                    btn.classList.add('favorited');
                    btn.innerHTML = '<i class="fa fa-heart text-red-500"></i>';
                    favoriteIds.push(productId);

                    // favori sayısını bir artır
                    favCount += 1;
                }

                // güncellenmiş sayıyı DOM'a yaz
                favCountEl.textContent = favCount;
            } else {
                console.error(data.message || 'Hata oluştu');
            }

        } catch (err) {
            console.error('İstek başarısız:', err);
        }
    });
});
