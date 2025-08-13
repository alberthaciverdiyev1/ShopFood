const burger = document.getElementById("burger");
const burgeropen = document.getElementById("mobile-menu");

burger.addEventListener("click", function () {
    burgeropen.classList.toggle("hidden");
});

