<?php

require_once __DIR__ . '/db.php';

// Verificar que haya sesión activa y token
if (!isset($_SESSION['user_id'], $_SESSION['session_token'], $_SESSION['rol'])) {
    session_destroy();
    header("Location: /index.php?error=acceso_denegado");
    exit;
}

// Verificar token en la base de datos
$stmt = $pdo->prepare("SELECT session_token, rol FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['session_token'] !== $_SESSION['session_token']) {
    session_destroy();
    header("Location: /pages/login.php?error=sesion_conflicto");
    exit;
}

// Validar rol admin si se requiere
if (defined('REQUIERE_ADMIN') && REQUIERE_ADMIN === true) {
    if ($user['rol'] !== 'admin') {
        header("Location: /index.php?error=acceso_denegado");
        exit;
    }
}
