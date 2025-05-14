const productosVendedor = [
    {
      nombre: "Mesa de comedor",
      descripcion: "Mesa de madera reciclada para 6 personas.",
      precio: "$120",
      imagen: "src/img/producto.jpg"
    },
    {
      nombre: "Diseño de interiores",
      descripcion: "Asesoría para remodelaciones de hogar.",
      precio: null,
      imagen: "src/img/producto.jpg"
    }
  ];

  function crearTarjetaVendedor(producto) {
    return `
      <div class="vendedor-producto" onclick="alert('Detalles de ${producto.nombre}')">
        <img src="${producto.imagen}" alt="${producto.nombre}">
        <div class="vendedor-info">
          <h4>${producto.nombre}</h4>
          <p>${producto.descripcion}</p>
          <p class="${producto.precio ? 'precio' : 'cotizacion'}">
            ${producto.precio || 'Cotización'}
          </p>
        </div>
      </div>
    `;
  }

  window.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("vendedor-productos");
    contenedor.innerHTML = productosVendedor.map(crearTarjetaVendedor).join("");
  });