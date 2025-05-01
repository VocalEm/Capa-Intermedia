const btnLogin = document.getElementById("btnLogin");
const btnRegistro = document.getElementById("btnRegistro");
const loginForm = document.getElementById("loginForm");
const registroForm = document.getElementById("registroForm");
const mensaje = document.getElementById("mensajeRegistro");
const rolSelect = document.getElementById("rol");
const privacidadSelect = document.getElementById("privacidad");
const errorMessagesRegister = document.querySelectorAll(
  ".errorMessageContainerRegister"
);
const errorMessageLogin = document.getElementById("errorMessageContainerLogin");

btnLogin.addEventListener("click", () => {
  btnLogin.classList.add("active");
  btnRegistro.classList.remove("active");
  loginForm.classList.remove("hidden");
  registroForm.classList.add("hidden");
  mensaje.textContent = "";

  // Ocultar todos los mensajes de error del registro
  errorMessagesRegister.forEach((error) => {
    error.style.display = "none";
  });
  errorMessageLogin.style.display = "block";
});

btnRegistro.addEventListener("click", () => {
  btnRegistro.classList.add("active");
  btnLogin.classList.remove("active");
  registroForm.classList.remove("hidden");
  loginForm.classList.add("hidden");
  mensaje.textContent = "";

  // Mostrar todos los mensajes de error del registro
  errorMessagesRegister.forEach((error) => {
    error.style.display = "block"; // Cambia a "flex" si necesitas un diseño de contenedor flexible
  });

  errorMessageLogin.style.display = "none";
});

// Escuchar cambios en el campo de rol
rolSelect.addEventListener("change", () => {
  if (rolSelect.value === "comprador") {
    privacidadSelect.disabled = false;
  } else {
    privacidadSelect.disabled = true;
    privacidadSelect.value = ""; // Reiniciar el valor si no es cliente
  }
});
