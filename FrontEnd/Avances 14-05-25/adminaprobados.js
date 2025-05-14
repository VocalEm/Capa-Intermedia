const productosAprobados = [
    {
      nombre: "Laptop Dell XPS 13",
      vendedor: "Juan Pérez",
      precio: "$1,200",
      descripcion: "Ultrabook con pantalla 4K y 16GB de RAM.",
      fecha: "2025-05-10"
    },
    {
      nombre: "Auriculares Sony WH-1000XM5",
      vendedor: "María López",
      precio: "$350",
      descripcion: "Auriculares con cancelación activa de ruido.",
      fecha: "2025-05-09"
    }
  ];

  const productosDenegados = [
    {
      nombre: "Impresora usada",
      vendedor: "Carlos Ruiz",
      precio: "$45",
      descripcion: "Impresora láser antigua, requiere reparación.",
      fecha: "2025-05-08"
    }
  ];

  function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById(tabId).classList.remove('hidden');

    document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));
    document.querySelector(`[onclick="showTab('${tabId}')"]`).classList.add('active');
  }

  function crearTarjeta(producto) {
    return `
      <div class="product-card">
        <h3>${producto.nombre}</h3>
        <p><strong>Vendedor:</strong> ${producto.vendedor}</p>
        <p class="price"><strong>Precio:</strong> ${producto.precio}</p>
        <p><strong>Descripción:</strong> ${producto.descripcion}</p>
        <p class="date"><strong>Fecha:</strong> ${producto.fecha}</p>
      </div>
    `;
  }

  function cargarProductos() {
    const aprobadosContainer = document.getElementById("aprobados-list");
    const denegadosContainer = document.getElementById("denegados-list");

    aprobadosContainer.innerHTML = productosAprobados.map(crearTarjeta).join('');
    denegadosContainer.innerHTML = productosDenegados.map(crearTarjeta).join('');
  }

  // Cargar al iniciar
  document.addEventListener("DOMContentLoaded", cargarProductos);