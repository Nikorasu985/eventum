const notifIcon = document.querySelector(".notifications-icon");
const userIcon = document.querySelector(".user");
const sidebarIcon = document.querySelector(".sidebar-icon");

const notifDropdown = document.querySelector(".notifications-dropdown");
const userDropdown = document.querySelector(".user-dropdown");
const sidebar = document.querySelector(".sidebar");

// Toggle notificaciones
notifIcon.addEventListener("click", () => {
    notifDropdown.classList.toggle("hidden");
    userDropdown.classList.add("hidden"); // cerrar si está abierto
});

// Toggle usuario
userIcon.addEventListener("click", () => {
    userDropdown.classList.toggle("hidden");
    notifDropdown.classList.add("hidden"); // cerrar si está abierto
});

// Toggle sidebar
sidebarIcon.addEventListener("click", () => {
    sidebar.classList.toggle("show");
});

const closeSidebar = document.querySelector(".close-sidebar");

closeSidebar.addEventListener("click", () => {
  sidebar.classList.remove("show");
});

// Cerrar dropdowns si se hace click fuera
document.addEventListener("click", (e) => {
    if (!notifIcon.contains(e.target) && !notifDropdown.contains(e.target)) {
        notifDropdown.classList.add("hidden");
    }
    if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.add("hidden");
    }
});
