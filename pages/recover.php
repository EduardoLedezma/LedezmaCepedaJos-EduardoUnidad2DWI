<?php
session_start();
include '../php/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8">
  <title>Recuperar contraseña - Tienda Musical</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
  <h2>Recuperar contraseña</h2>
  <p>Introduce tu correo electrónico y te enviaremos instrucciones para restablecer tu contraseña.</p>
  <form action="/php/recover.php" method="POST" onsubmit="return validarRecuperacion();">
    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" name="email" id="email" required>
    </div>
    <button type="submit" class="btn btn-warning">Enviar</button>
  </form>
</div>

<script>
function validarRecuperacion() {
  const email = document.getElementById("email").value.trim();
  if (email === "") {
    Swal.fire({
      icon: 'warning',
      title: 'Campo vacío',
      text: 'Ingresa tu correo electrónico.'
    });
    return false;
  }
  return true;
}

document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);

  if (params.has('error')) {
    let msg = '';
    switch (params.get('error')) {
      case 'correo':
        msg = 'Correo inválido.';
        break;
      case 'sin_cuenta':
        msg = 'No hay cuenta registrada con ese correo.';
        break;
      case 'email':
        msg = 'Error al enviar el correo.';
        break;
      default:
        msg = 'Ocurrió un error.';
    }

    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: msg
    });

    history.replaceState(null, '', window.location.pathname);
  }

  if (params.has('exito')) {
    Swal.fire({
      icon: 'success',
      title: 'Correo enviado',
      text: 'Te hemos enviado un correo con instrucciones.',
      confirmButtonText: 'Aceptar'
    }).then(() => {
      window.location.href = '/index.php';
    });
  }
});
</script>

</body>
</html>
