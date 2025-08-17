const burger = document.getElementById("burger");
const burgeropen = document.getElementById("mobile-menu");

burger.addEventListener("click", function () {
    burgeropen.classList.toggle("hidden");
});
const modal = document.getElementById("modal");
const overlay = document.getElementById("overlay");
const openModal = document.getElementById("openModal");

// Modal açmaq
openModal.addEventListener("click", () => {
  overlay.classList.remove("hidden");
});

// Modal bağlamaq (yalnız overlay kliklə)
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
