// Script para marcar el enlace activo
document.addEventListener("DOMContentLoaded", function () {
  const currentLocation = window.location.href;

  const links = document.querySelectorAll(".links li a");

  links.forEach((link) => {
    if (link.href === currentLocation) {
      link.classList.add("active");
    }
  });
});
