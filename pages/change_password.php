<?php
session_start();
include '../php/navbar.php';
require_once '../php/auth_check.php';


// Redirigir si no hay sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8" />
  <title>Mi perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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

<div class="container mt-5">
  <div class="seccion">
    <h2>Mi perfil</h2>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></p>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($_SESSION['user_correo']); ?></p>
    <p><strong>Rol:</strong> <?php echo htmlspecialchars($_SESSION['rol']); ?></p>
  </div>

  <div class="seccion">
    <h4>Cambiar contraseña</h4>
    <form action="/Practica-Gabriel/php/change_password.php" method="POST" onsubmit="return validarCambio();">
      <div class="mb-3">
        <label for="nueva" class="form-label">Nueva contraseña</label>
        <input type="password" class="form-control" id="nueva" name="nueva" required />
      </div>
      <div class="mb-3">
        <label for="confirmar" class="form-label">Confirmar contraseña</label>
        <input type="password" class="form-control" id="confirmar" name="confirmar" required />
      </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
  </div>

  <div class="text-center mb-5">
    <a href="/Practica-Gabriel-Unidad3/index.php" class="btn btn-light">← Volver al inicio</a>
  </div>
</div>

<script>
function validarCambio() {
  const nueva = document.getElementById("nueva").value.trim();
  const confirmar = document.getElementById("confirmar").value.trim();

  if (nueva !== confirmar) {
    Swal.fire({
      icon: 'error',
      title: 'No coinciden',
      text: 'Las contraseñas no son iguales.'
    });
    return false;
  }

  if (nueva.length < 6) {
    Swal.fire({
      icon: 'warning',
      title: 'Contraseña débil',
      text: 'Debe tener al menos 6 caracteres.'
    });
    return false;
  }

  return true;
}
</script>

</body>
</html>
