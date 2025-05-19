document.addEventListener("DOMContentLoaded", () => {
  const saveButton = document.getElementById("save-button");
  const popup = document.getElementById("popup");
  const closeButton = document.querySelector(".close-button");
  const buttonVerification = document.getElementById("saveIcon");
  const idProducto = document.querySelector("input[name='idProducto']").value;

  // Mostrar la ventana emergente al hacer clic en el botón "save-button"
  saveButton.addEventListener("click", (e) => {
    e.preventDefault(); // Evita redireccionamiento no deseado

    // Verificar si el botón tiene la clase "guardado"
    if (buttonVerification.classList.contains("guardado")) {
      return; // No hacer nada si ya está guardado
    }

    // Mostrar el popup y bloquear el scroll del fondo
    popup.style.display = "flex";
    document.body.style.overflow = "hidden";
  });

  // Ocultar la ventana emergente al hacer clic en el botón de cerrar
  closeButton.addEventListener("click", () => {
    popup.style.display = "none";
    document.body.style.overflow = ""; // Restaurar el scroll del fondo
  });

  // Ocultar la ventana emergente al hacer clic fuera del contenido
  window.addEventListener("click", (event) => {
    if (event.target === popup) {
      popup.style.display = "none";
      document.body.style.overflow = ""; // Restaurar el scroll del fondo
    }
  });
});
