document.addEventListener('DOMContentLoaded', function() {
    const menu = document.querySelector(".menu");
    const navMenu = document.querySelector(".nav-menu");
    
    menu.addEventListener("click", () => {
        navMenu.classList.toggle("active");
    });
});