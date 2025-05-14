const productos = [
    { nombre: "Zapatos deportivos", usuario: "vendedor1", precio: 120, rating: 4.5, ventas: 320, imagen: "src/img/producto.jpg" },
    { nombre: "Auriculares Bluetooth", usuario: "techstore", precio: 85, rating: 4.8, ventas: 480, imagen: "src/img/producto.jpg" },
    { nombre: "Reloj inteligente", usuario: "smartworld", precio: 150, rating: 4.2, ventas: 150, imagen: "src/img/producto.jpg" },
    { nombre: "Laptop Gamer", usuario: "pcmania", precio: 950, rating: 4.9, ventas: 210, imagen: "src/img/producto.jpg" },
  ];
  
  function buscarContenido() {
    const termino = document.getElementById("inputBusqueda").value.toLowerCase();
    const filtro = document.getElementById("filtro").value;
    let resultados = productos.filter(p =>
      p.nombre.toLowerCase().includes(termino) || p.usuario.toLowerCase().includes(termino)
    );
  
    switch (filtro) {
      case "precioAsc":
        resultados.sort((a, b) => a.precio - b.precio);
        break;
      case "precioDesc":
        resultados.sort((a, b) => b.precio - a.precio);
        break;
      case "rating":
        resultados.sort((a, b) => b.rating - a.rating);
        break;
      case "ventas":
        resultados.sort((a, b) => b.ventas - a.ventas);
        break;
    }
  
    mostrarResultados(resultados);
  }
  
  function mostrarResultados(resultados) {
    const contenedor = document.getElementById("resultados");
    contenedor.innerHTML = "";
    resultados.forEach(p => {
      contenedor.innerHTML += `
        <div class="resultado-card">
          <img src="${p.imagen}" alt="${p.nombre}">
          <h3>${p.nombre}</h3>
          <p>Vendedor: ${p.usuario}</p>
          <p>Rating: ⭐ ${p.rating}</p>
          <p class="precio">$${p.precio}</p>
        </div>
      `;
    });
  }