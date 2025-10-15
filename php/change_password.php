<?php
session_start();
require_once __DIR__ . '/db.php';

// Función para mostrar SweetAlert2 desde PHP
function mostrarAlerta($icono, $titulo, $texto, $redir = null) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
      document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
          icon: '$icono',
          title: '$titulo',
          text: '$texto'
        }).then(() => {";
    if ($redir) {
        echo "window.location.href = '$redir';";
    } else {
        echo "window.history.back();";
    }
    echo "});
      });
    </script>";
    exit;
}

// Verifica si hay sesión activa
if (!isset($_SESSION['user_id'])) {
    mostrarAlerta('warning', 'Acceso denegado', 'Debes iniciar sesión para cambiar tu contraseña.', '/Practica-Gabriel/pages/login.html');
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva = trim($_POST['nueva']);
    $confirmar = trim($_POST['confirmar']);

    if (empty($nueva) || empty($confirmar)) {
        mostrarAlerta('warning', 'Campos requeridos', 'Todos los campos son obligatorios.');
    }

    if ($nueva !== $confirmar) {
        mostrarAlerta('error', 'No coinciden', 'Las contraseñas no coinciden.');
    }

    if (strlen($nueva) < 6) {
        mostrarAlerta('warning', 'Contraseña débil', 'La contraseña debe tener al menos 6 caracteres.');
    }

    try {
        $hash = password_hash($nueva, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        $stmt->execute([
            ':password' => $hash,
            ':id' => $_SESSION['user_id']
        ]);
        mostrarAlerta('success', '¡Listo!', 'Contraseña actualizada exitosamente.', '/Practica-Gabriel/index.php');
    } catch (PDOException $e) {
        mostrarAlerta('error', 'Error', 'Error en la base de datos.');
    }
} else {
    mostrarAlerta('error', 'Solicitud inválida', 'La solicitud no es válida.');
}
