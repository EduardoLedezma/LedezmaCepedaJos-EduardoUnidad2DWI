<?php
session_start();
require_once  '../php/db.php';
include  '../php/navbar.php';
define('REQUIERE_ADMIN', true); 
require_once '../php/auth_check.php';


// Solo permitir acceso a admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
  header('Location: ../index.php');
  exit;
}

// Obtener productos y usuarios para mostrar en las tablas
$productos = $pdo->query("SELECT * FROM productos ORDER BY creado DESC")->fetchAll(PDO::FETCH_ASSOC);
$usuarios = $pdo->query("SELECT * FROM usuarios ORDER BY creado DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administrador</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #111;
      color: #fff;
    }
    .container {
      margin-top: 80px;
    }
    .form-control, .btn {
      border-radius: 0;
    }
    table {
      background-color: #222;
      color: white;
    }
  </style>
</head>
<body>
<div class="container">
  <h2 class="mb-4">Panel de administrador</h2>

  <!-- Formulario para agregar productos -->
  <div class="mb-5">
    <h4>Agregar nuevo producto</h4>
    <form action="../php/add_product.php" method="POST">
      <div class="row g-2">
        <div class="col-md-4">
          <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
        </div>
        <div class="col-md-4">
          <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
        </div>
        <div class="col-md-4">
          <input type="text" name="img" class="form-control" placeholder="URL de imagen" required>
        </div>
      </div>
      <button type="submit" class="btn btn-success mt-3">Agregar producto</button>
    </form>
  </div>

  <!-- Tabla de productos -->
  <h4>Productos existentes</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Imagen</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['nombre']) ?></td>
          <td><?= htmlspecialchars($p['descripcion']) ?></td>
          <td><img src="<?= $p['img'] ?>" width="60"></td>
          <td>
            <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion('producto', <?= $p['id'] ?>)">Eliminar</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Tabla de usuarios -->
  <h4 class="mt-5">Usuarios registrados</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td><?= htmlspecialchars($u['correo']) ?></td>
          <td><?= htmlspecialchars($u['rol'] ?? 'user') ?></td>
          <td>
            <?php if ($u['rol'] !== 'admin'): ?>
              <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion('usuario', <?= $u['id'] ?>)">Eliminar</button>
            <?php else: ?>
              <em>No permitido</em>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
function confirmarEliminacion(tipo, id) {
  const texto = tipo === 'producto' ? 'este producto' : 'este usuario';
  Swal.fire({
    title: '¿Estás seguro?',
    text: `Vas a eliminar ${texto}. Esta acción no se puede deshacer.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `../php/delete.php?tipo=${tipo}&id=${id}`;
    }
  });
}
</script>

</body>
</html>
