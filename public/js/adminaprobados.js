function showTab(tabId) {
  document
    .querySelectorAll(".tab-content")
    .forEach((el) => el.classList.add("hidden"));
  document.getElementById(tabId).classList.remove("hidden");

  document
    .querySelectorAll(".tab")
    .forEach((el) => el.classList.remove("active"));
  document
    .querySelector(`[onclick="showTab('${tabId}')"]`)
    .classList.add("active");
}

function cargarProductos() {
  const aprobadosContainer = document.getElementById("aprobados-list");
  const denegadosContainer = document.getElementById("denegados-list");

  aprobadosContainer.innerHTML = productosAprobados.map(crearTarjeta).join("");
  denegadosContainer.innerHTML = productosDenegados.map(crearTarjeta).join("");
}

// Cargar al iniciar
document.addEventListener("DOMContentLoaded", cargarProductos);
