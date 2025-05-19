document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");
    const navLinks = document.querySelectorAll("ul.components li a");

    // Sidebar toggle functionality
    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", function () {
            sidebar.classList.toggle("active");
            content.classList.toggle("active");
        });
    }

    // Highlight active navigation link
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            document.querySelector("ul.components li.active")?.classList.remove("active");
            this.parentElement.classList.add("active");
        });
    });
});
