function moverCarrusel(direccion) {
    const carrusel = document.getElementById("carrusel");
    const tarjetaWidth = carrusel.querySelector(".tarjeta-producto").offsetWidth + 20; // incluye gap
    carrusel.scrollLeft += direccion * tarjetaWidth;
  }

function moverCarrusel2(direccion) {
    const carrusel = document.getElementById("carrusel2");
    const tarjetaWidth = carrusel.querySelector(".tarjeta-producto").offsetWidth + 20; // incluye gap
    carrusel.scrollLeft += direccion * tarjetaWidth;
  }