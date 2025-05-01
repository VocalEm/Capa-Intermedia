const usuario = {
    nombreUsuario: "@usuario123",
    fotoPerfil: "src/img/profile.jpg",
    listas: [
      {
        nombre: "Regalos de cumpleaños",
        descripcion: "Cosas que me encantaría recibir 🎁",
        visibilidad: "Pública",
        productos: [
          { nombre: "Smartwatch", precio: 120, imagen: "src/img/producto.jpg" },
          { nombre: "Auriculares", precio: 80, imagen: "src/img/producto.jpg" }
        ]
      },
      {
        nombre: "Compras personales",
        descripcion: "Lo que necesito comprar pronto",
        visibilidad: "Privada",
        productos: [
          { nombre: "Zapatillas", precio: 90, imagen: "src/img/producto.jpg" }
        ]
      }
    ]
  };
  
  function renderizarPerfil() {
    document.querySelector(".foto-perfil").src = usuario.fotoPerfil;
    document.querySelector(".perfil-header h2").textContent = usuario.nombreUsuario;
  
    const container = document.getElementById("listas-container");
    container.innerHTML = "";
  
    usuario.listas.forEach(lista => {
      const listaHTML = `
        <div class="lista-card">
          <h4>${lista.nombre}</h4>
          <p class="descripcion">${lista.descripcion}</p>
          <p class="visibilidad">Visibilidad: ${lista.visibilidad}</p>
          <div class="productos-lista">
            ${lista.productos.map(p => `
              <div class="producto-card">
                <img src="${p.imagen}" alt="${p.nombre}">
                <h5>${p.nombre}</h5>
                <p class="precio">$${p.precio}</p>
              </div>
            `).join('')}
          </div>
        </div>
      `;
      container.innerHTML += listaHTML;
    });
  }
  
  document.addEventListener("DOMContentLoaded", renderizarPerfil);