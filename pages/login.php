<?php
session_start();
include '../php/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8">
  <title>Iniciar sesión - Tienda Musical</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/Practica-Gabriel/css/styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: url('/Practica-Gabriel/img/fondo-negro.jpg') no-repeat center center fixed;
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
  <h2>Iniciar sesión</h2>
  <form action="../php/login.php" method="POST" onsubmit="return validarLogin();">
    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" name="email" id="email" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <div class="mb-3">
      <a href="recover.php">¿Olvidaste tu contraseña?</a>
    </div>
    <button type="submit" class="btn btn-primary">Ingresar</button>
  </form>
</div>

<script>
// Validación con SweetAlert2
function validarLogin() {
  const email = document.getElementById("email").value.trim();
  const pass = document.getElementById("password").value.trim();
  if (email === "" || pass === "") {
    Swal.fire({
      icon: 'warning',
      title: 'Campos obligatorios',
      text: 'Por favor completa todos los campos.'
    });
    return false;
  }
  return true;
}

// Mostrar alertas según la URL
const params = new URLSearchParams(window.location.search);
if (params.has('error')) {
  const error = params.get('error');
  let mensaje = 'Ocurrió un error.';

  switch (error) {
    case 'campos':
      mensaje = 'Todos los campos son obligatorios.';
      break;
    case 'correo':
      mensaje = 'Correo electrónico no válido.';
      break;
    case 'no_encontrado':
      mensaje = 'Usuario no encontrado.';
      break;
    case 'contrasena':
      mensaje = 'Contraseña incorrecta.';
      break;
  }

  Swal.fire({
    icon: 'error',
    title: 'Error al iniciar sesión',
    text: mensaje
  });
}
if (params.has('exito')) {
  Swal.fire({
    icon: 'success',
    title: 'Inicio de sesión exitoso',
    showConfirmButton: false,
    timer: 2000
  }).then(() => {
    window.location.href = '../index.php';
  });
}
</script>

</body>
</html>
