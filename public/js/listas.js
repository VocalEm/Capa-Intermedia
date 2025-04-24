let listaActual = null;

function mostrarTab(tabId) {
  document.querySelectorAll('.tab-content').forEach(tab => {
    tab.style.display = 'none';
  });

  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.classList.remove('active');
  });

  document.getElementById(tabId).style.display = 'block';
  document.querySelector(`.tab-btn[onclick="mostrarTab('${tabId}')"]`).classList.add('active');
}

function toggleLista(listaId) {
  const detalle = document.getElementById("detalleLista");

  if (listaActual === listaId) {
    cerrarLista();
  } else {
    abrirLista(listaId);
  }
}

function abrirLista(listaId) {
  const detalle = document.getElementById("detalleLista");

  if (listaId === "lista1") {
    document.getElementById("tituloLista").textContent = "Lista de Cumpleaños";
    document.getElementById("descripcionLista").textContent = "Ideas para mi próxima fiesta 🥳";
  } else if (listaId === "lista2") {
    document.getElementById("tituloLista").textContent = "Navidad";
    document.getElementById("descripcionLista").textContent = "Regalos navideños 🎄";
  }

  detalle.style.display = "block";
  listaActual = listaId;
}

function cerrarLista() {
  document.getElementById("detalleLista").style.display = "none";
  listaActual = null;
}