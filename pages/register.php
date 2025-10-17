<?php
session_start();
include '../php/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8">
  <title>Registro - Tienda Musical</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <style>
    body {
      background: url('/img/fondo-negro.jpg') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }
    .seccion {
      background-color: rgba(0, 0, 0, 0.7);
      padding: 2rem;
      border-radius: 10px;
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>

<div class="container-form mt-5">
  <h2>Crear cuenta</h2>
  <form id="form-registro" action="../php/register.php" method="POST" onsubmit="return validarRegistro();">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre completo</label>
      <input type="text" class="form-control" name="nombre" id="nombre" required>
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" name="correo" id="correo" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <div class="mb-3">
      <label for="confirmar" class="form-label">Confirmar contraseña</label>
      <input type="password" class="form-control" name="confirmar" id="confirmar" required>
    </div>

    <div class="g-recaptcha mb-3" data-sitekey="6Le6ylorAAAAAKV-qmkp6UleEDPIQj_FjlWHKyT_"></div>

    <button type="submit" class="btn btn-primary">Registrarse</button>
  </form>
</div>

<script>
function validarRegistro() {
  const pass = document.getElementById("password").value;
  const confirmar = document.getElementById("confirmar").value;
  if (pass !== confirmar) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Las contraseñas no coinciden.'
    });
    return false;
  }

  const captcha = grecaptcha.getResponse();
  if (!captcha) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor completa el reCAPTCHA.'
    });
    return false;
  }

  return true;
}

// Mostrar alertas según query params error/exito
document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has('error')) {
    const error = urlParams.get('error');
    let msg = '';
    switch(error) {
      case 'campos':
        msg = 'Todos los campos son obligatorios.';
        break;
      case 'correo':
        msg = 'Correo electrónico no válido.';
        break;
      case 'contrasenas':
        msg = 'Las contraseñas no coinciden.';
        break;
      case 'captcha':
        msg = 'Captcha inválido.';
        break;
      case 'duplicado':
        msg = 'El correo ya está registrado.';
        break;
      case 'otro':
        msg = 'Error al registrar. Intenta de nuevo más tarde.';
        break;
      default:
        msg = 'Error desconocido.';
    }
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: msg
    });
    history.replaceState(null, '', window.location.pathname); // Limpiar query
  }

  if (urlParams.has('exito')) {
    Swal.fire({
      icon: 'success',
      title: 'Registro exitoso',
      text: 'Tu cuenta ha sido creada correctamente.',
      confirmButtonText: 'Aceptar'
    }).then(() => {
      window.location.href = '../index.php';
    });
  }
});
</script>

</body>
</html>
