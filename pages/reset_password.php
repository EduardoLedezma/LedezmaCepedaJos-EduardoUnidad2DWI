<?php
require_once '../php/db.php';
include '../php/navbar.php';


$token = $_GET['token'] ?? '';
$alerta = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $nueva = $_POST['password'];

    if (strlen($nueva) < 6) {
        $alerta = "minima";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token_recuperacion = :token AND token_expira > NOW()");
        $stmt->execute([':token' => $token]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $hash = password_hash($nueva, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuarios SET password = :pass, token_recuperacion = NULL, token_expira = NULL WHERE id = :id");
            $stmt->execute([':pass' => $hash, ':id' => $usuario['id']]);
            $alerta = "actualizada";
        } else {
            $alerta = "invalido";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8">
  <title>Restablecer contraseña</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/styles.css" />
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
<body class="bg-dark text-white">
  <div class="container-form mt-5">
    <h2>Restablecer contraseña</h2>
    <form method="POST">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
      <div class="mb-3">
        <label class="form-label">Nueva contraseña</label>
        <input type="password" name="password" class="form-control" required minlength="6">
      </div>
      <button type="submit" class="btn btn-warning">Restablecer</button>
    </form>
  </div>

  <?php if (!empty($alerta)): ?>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      <?php if ($alerta === 'minima'): ?>
        Swal.fire({
          icon: 'warning',
          title: 'Contraseña muy corta',
          text: 'La contraseña debe tener al menos 6 caracteres.'
        });
      <?php elseif ($alerta === 'actualizada'): ?>
        Swal.fire({
          icon: 'success',
          title: 'Contraseña actualizada',
          text: 'Tu contraseña se ha actualizado correctamente.',
          confirmButtonText: 'Aceptar'
        }).then(() => {
          window.location.href = '/index.php';
        });
      <?php elseif ($alerta === 'invalido'): ?>
        Swal.fire({
          icon: 'error',
          title: 'Token inválido',
          text: 'El enlace ha expirado o es inválido.',
          confirmButtonText: 'Volver al inicio'
        }).then(() => {
          window.location.href = '/index.php';
        });
      <?php endif; ?>
    });
  </script>
  <?php endif; ?>

</body>
</html>
