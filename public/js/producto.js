document.addEventListener("DOMContentLoaded", function () {
  const focusContainer = document.getElementById("focusContainer");
  const focusImage = document.getElementById("focusImage");
  const focusVideo = document.getElementById("focusVideo");
  const mediaItems = document.querySelectorAll(".media-item");

  // Cargar el primer elemento multimedia en el foco al iniciar
  if (mediaItems.length > 0) {
    const primerElemento = mediaItems[0];
    const tipo =
      primerElemento.tagName.toLowerCase() === "video" ? "video" : "imagen";
    cargarEnFoco(primerElemento, tipo);
  }

  window.mostrarEnFoco = function (elemento, tipo) {
    cargarEnFoco(elemento, tipo);
  };

  function cargarEnFoco(elemento, tipo) {
    if (tipo === "imagen") {
      focusVideo.style.display = "none";
      focusImage.style.display = "block";
      focusImage.src = elemento.src;
    } else if (tipo === "video") {
      focusImage.style.display = "none";
      focusVideo.style.display = "block";
      focusVideo.src = elemento.src;
      focusVideo.play();
    }
  }

  window.scrollGaleria = function (direccion) {
    const galeriaContenedor = document.querySelector(".galeria-contenedor");
    const scrollAmount = 160;

    if (direccion === "izquierda") {
      galeriaContenedor.scrollLeft -= scrollAmount;
    } else {
      galeriaContenedor.scrollLeft += scrollAmount;
    }
  };

  focusImage.addEventListener("click", function () {
    abrirPantallaCompleta(focusImage, "imagen");
  });

  focusVideo.addEventListener("click", function () {
    abrirPantallaCompleta(focusVideo, "video");
  });

  function abrirPantallaCompleta(elemento, tipo) {
    const overlay = document.createElement("div");
    overlay.classList.add("fullscreen-overlay");

    const closeButton = document.createElement("button");
    closeButton.classList.add("fullscreen-close");
    closeButton.textContent = "✖";
    closeButton.addEventListener("click", () =>
      cerrarPantallaCompleta(overlay)
    );

    const clone = elemento.cloneNode(true);
    clone.classList.add("focus-item");
    clone.style.cursor = "default";

    overlay.appendChild(closeButton);
    overlay.appendChild(clone);
    document.body.appendChild(overlay);
  }

  function cerrarPantallaCompleta(overlay) {
    overlay.remove();
    focusVideo.pause(); // Pausar video al cerrar
  }
});
