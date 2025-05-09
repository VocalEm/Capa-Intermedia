const enviarBtn = document.getElementById("enviarBtn");
const mensajeInput = document.getElementById("mensajeInput");
const chatMensajes = document.getElementById("chatMensajes");
const usuarioInput = document.getElementById("usuarioInput");

enviarBtn.addEventListener("click", () => {
  const mensaje = mensajeInput.value.trim();
  const usuario = usuarioInput.textContent.trim() || "Anónimo";

  if (mensaje !== "") {
    const nuevoMensaje = document.createElement("div");
    nuevoMensaje.textContent = `${usuario}: ${mensaje}`;
    chatMensajes.appendChild(nuevoMensaje);
    mensajeInput.value = "";
    chatMensajes.scrollTop = chatMensajes.scrollHeight;
  }
});