function togglePrecio() {
    const tipoVenta = document.getElementById("tipo-venta").value;
    const campoPrecio = document.getElementById("campo-precio");
    campoPrecio.style.display = tipoVenta === "fijo" ? "block" : "none";
  }

  function toggleNuevaCategoria() {
    const categoria = document.getElementById("categoria").value;
    const campoNueva = document.getElementById("nueva-categoria");
    campoNueva.style.display = categoria === "nueva" ? "block" : "none";
  }