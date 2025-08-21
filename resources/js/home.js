const burger = document.getElementById("burger");
const burgeropen = document.getElementById("mobile-menu");

burger.addEventListener("click", function () {
    burgeropen.classList.toggle("hidden");
});
const overlay = document.getElementById("overlay");
const modalTitle = document.getElementById("modalTitle");
const modalPrice = document.getElementById("modalPrice");
const modalImage = document.getElementById("modalImage");
const modalDescription = document.getElementById("modalDescription");

const openModalButtons = document.querySelectorAll(".openModal");

// Modal açmaq və məlumatları doldurmaq
openModalButtons.forEach(button => {
  button.addEventListener("click", () => {
    const title = button.dataset.title;
    const price = button.dataset.price;
    const image = button.dataset.image;
    const description = button.dataset.description;

    modalTitle.textContent = title;
    modalPrice.textContent = `$${price}`;
    modalImage.src = image;
    modalDescription.textContent = description;

    overlay.classList.remove("hidden");
  });
});

// Modal bağlamaq (overlay kliklə)
overlay.addEventListener("click", (e) => {
  if (e.target === overlay) {
    overlay.classList.add("hidden");
  }
});


const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".dot");
let currentIndex = 0;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.toggle("hidden", i !== index);
        dots[i].classList.toggle("active", i === index);
    });
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

setInterval(nextSlide, 2000);
dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
        currentIndex = index;
        showSlide(currentIndex);
    });
});
showSlide(currentIndex);
