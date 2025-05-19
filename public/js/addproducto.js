document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("form-agregar-producto")
    .addEventListener("submit", validarFormulario);
  // Ejecutar al iniciar para reflejar el estado actual del select
  togglePrecio();

  // Evento onchange para el select
  tipoVenta.addEventListener("change", togglePrecio);
});

function agregarImagen() {
  const container = document.getElementById("imagenes-container");
  const input = document.createElement("input");
  input.type = "file";
  input.name = "imagenes[]";
  input.accept = "image/*";
  input.style.display = "none";

  input.addEventListener("change", function () {
    if (input.files.length > 0) {
      mostrarPrevisualizacion(input, "imagen");
    }
  });

  input.click();
}

function agregarVideo() {
  const container = document.getElementById("videos-container");
  const input = document.createElement("input");
  input.type = "file";
  input.name = "videos[]";
  input.accept = "video/*";
  input.style.display = "none";

  input.addEventListener("change", function () {
    if (input.files.length > 0) {
      mostrarPrevisualizacion(input, "video");
    }
  });

  input.click();
}

function mostrarPrevisualizacion(input, tipo) {
  const container =
    tipo === "imagen"
      ? document.getElementById("imagenes-container")
      : document.getElementById("videos-container");

  const archivo = input.files[0];

  if (archivo) {
    const reader = new FileReader();
    reader.onload = function (e) {
      const div = document.createElement("div");
      div.classList.add(`${tipo}-preview`);

      const preview = document.createElement(
        tipo === "imagen" ? "img" : "video"
      );
      preview.src = e.target.result;
      preview.classList.add("media-preview");

      if (tipo === "video") {
        preview.controls = false;
        preview.muted = true;
        preview.autoplay = true;
        preview.loop = true;
      }

      const botonEliminar = document.createElement("button");
      botonEliminar.textContent = "X";
      botonEliminar.classList.add(
        tipo === "imagen" ? "eliminar-img" : "eliminar-btn"
      );

      // Asociar el input al contenedor para poder eliminarlo después
      div.appendChild(preview);
      div.appendChild(botonEliminar);
      container.appendChild(div);
      container.appendChild(input); // Se agrega aquí para mantener la estructura del DOM

      // Evento de eliminación
      botonEliminar.addEventListener("click", function () {
        div.remove();
        input.remove();
      });
    };

    reader.readAsDataURL(archivo);
  }
}

function validarFormulario(e) {
  e.preventDefault();

  const nombre = document.getElementById("nombre").value.trim();
  const descripcion = document.getElementById("descripcion").value.trim();
  const stock = document.getElementById("stock").value.trim();
  const tipoVenta = document.getElementById("tipo-venta").value;
  const precio = document.getElementById("precio").value.trim();
  const imagenesInputs = document.querySelectorAll(
    "#imagenes-container input[type='file']"
  );
  const videosInputs = document.querySelectorAll(
    "#videos-container input[type='file']"
  );
  const categorias = document.querySelectorAll(
    "input[name='categorias[]']:checked"
  );

  let errores = [];
  let totalImagenes = 0;
  let totalVideos = 0;

  // Contar las imágenes cargadas (inputs no eliminados)
  imagenesInputs.forEach((input) => {
    if (input.files.length > 0) {
      totalImagenes++;
    }
  });

  // Contar los videos cargados (inputs no eliminados)
  videosInputs.forEach((input) => {
    if (input.files.length > 0) {
      totalVideos++;
    }
  });

  // Validación de campos vacíos
  if (nombre === "")
    errores.push("El nombre del producto no puede estar vacío.");
  if (descripcion === "")
    errores.push("La descripción del producto no puede estar vacía.");
  if (tipoVenta == "venta") {
    if (stock === "" || isNaN(stock) || parseInt(stock) < 0) {
      errores.push(
        "La cantidad en stock debe ser un número mayor o igual a 0."
      );
    }
  }

  // Validación de imágenes (mínimo 3)
  if (totalImagenes < 3) {
    errores.push("Debes cargar al menos 3 imágenes del producto.");
  }

  // Validación de videos (mínimo 1)
  if (totalVideos < 1) {
    errores.push("Debes cargar al menos 1 video del producto.");
  }

  // Validación de categorías (mínimo 1 seleccionada)
  if (categorias.length < 1) {
    errores.push("Debes seleccionar al menos una categoría.");
  }

  // Validación de tipo de venta
  if (tipoVenta === "") {
    errores.push("Debes seleccionar un tipo de venta.");
  } else if (
    tipoVenta === "venta" &&
    (precio === "" || parseFloat(precio) <= 0)
  ) {
    errores.push(
      "Si el tipo de venta es 'Precio Fijo', el precio debe ser mayor a 0."
    );
  }

  // Mostrar errores o enviar el formulario
  if (errores.length > 0) {
    Swal.fire({
      icon: "error",
      title: "Errores en el formulario",
      html: `<ul>${errores.map((e) => `<li>${e}</li>`).join("")}</ul>`,
      confirmButtonText: "Aceptar",
    });
  } else {
    e.target.submit();
  }
}

function togglePrecio() {
  const tipoVenta = document.getElementById("tipo-venta");
  const divPrecio = document.getElementById("campo-precio");

  if (tipoVenta.value == "venta") divPrecio.style.display = "block";
  else divPrecio.style.display = "none";
}

function togglePrecio() {
  const tipoVenta = document.getElementById("tipo-venta");
  const divPrecio = document.getElementById("campo-precio");
  const stock = document.getElementById("stock");
  divPrecio.style.display = tipoVenta.value === "venta" ? "block" : "none";
  stock.disabled = tipoVenta.value === "venta" ? false : true;
}
