const btnLogin = document.getElementById('btnLogin');
  const btnRegistro = document.getElementById('btnRegistro');
  const loginForm = document.getElementById('loginForm');
  const registroForm = document.getElementById('registroForm');
  const mensaje = document.getElementById('mensajeRegistro');

  btnLogin.addEventListener('click', () => {
    btnLogin.classList.add('active');
    btnRegistro.classList.remove('active');
    loginForm.classList.remove('hidden');
    registroForm.classList.add('hidden');
    mensaje.textContent = '';
  });

  btnRegistro.addEventListener('click', () => {
    btnRegistro.classList.add('active');
    btnLogin.classList.remove('active');
    registroForm.classList.remove('hidden');
    loginForm.classList.add('hidden');
    mensaje.textContent = '';
  });

  registroForm.addEventListener('submit', e => {
    e.preventDefault();
    mensaje.textContent = 'Registro enviado (simulado)';
    mensaje.style.color = 'green';
  });

  loginForm.addEventListener('submit', e => {
    e.preventDefault();
    mensaje.textContent = 'Login exitoso (simulado)';
    mensaje.style.color = 'green';
  });