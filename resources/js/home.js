const overlay = document.getElementById("overlay");
const modalTitle = document.getElementById("modalTitle");
const modalPrice = document.getElementById("modalPrice");
const modalImage = document.getElementById("modalImage");
const modalDescription = document.getElementById("modalDescription");
const modalProductInput = document.getElementById('modalProductId');
const addButton = document.getElementById('addBasket');

const openModalButtons = document.querySelectorAll(".openModal");

openModalButtons.forEach(button => {
    button.addEventListener("click", () => {
        const title = button.dataset.title;
        const price = button.dataset.price;
        const image = button.dataset.image;
        const description = button.dataset.description;
        const modalProductId = button.dataset.id;
        const basket = +button.dataset.basket;
        console.log(button.dataset.basket);
        console.log(basket)

        modalTitle.textContent = title;
        modalPrice.textContent = `$${price}`;
        modalImage.src = image;
        modalDescription.textContent = description;
        modalProductInput.value = modalProductId;

        addButton.dataset.basket = basket ? '1' : '0';
        addButton.textContent = basket ? 'Remove from Basket' : 'Add to Basket';
        addButton.style.backgroundColor = basket ? 'orange' : '';

        overlay.classList.remove("hidden");
    });
});

overlay.addEventListener("click", (e) => {
    if (e.target === overlay) overlay.classList.add("hidden");
});

addButton.addEventListener('click', function() {
    const productId = modalProductInput.value;
    const basket = addButton.dataset.basket === '1';

    const url = basket ? `/basket/remove/${productId}` : `/basket/add/${productId}`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: 1 })
    })
        .then(response => response.json())
        .then(data => {
            console.log("Basket response:", data);

            // Buton durumunu güncelle
            if (basket) {
                addButton.dataset.basket = '0';
                addButton.textContent = 'Add to Basket';
                addButton.style.backgroundColor = '';

                // Kart üzerindeki data-basket güncelle
                document.querySelector(`[data-id="${productId}"]`).dataset.basket = '0';
            } else {
                addButton.dataset.basket = '1';
                addButton.textContent = 'Remove from Basket';
                addButton.style.backgroundColor = 'orange';

                // Kart üzerindeki data-basket güncelle
                document.querySelector(`[data-id="${productId}"]`).dataset.basket = '1';
            }
        })

        .catch(error => {
            console.error('Error:', error);
        });
});
