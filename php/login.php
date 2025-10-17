<?php
session_start();
require_once(__DIR__ . "/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validaciones
    if (empty($email) || empty($password)) {
        header("Location: ../pages/login.php?error=campos");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../pages/login.php?error=correo");
        exit;
    }

    // Buscar usuario por correo
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $stmt->execute([':correo' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../pages/login.php?error=no_encontrado");
        exit;
    }

    // Verificar contraseña
    if (!password_verify($password, $user['password'])) {
        header("Location: ../pages/login.php?error=contrasena");
        exit;
    }

    // Credenciales correctas: generar token único para la sesión
    $session_token = bin2hex(random_bytes(32));

    // Guardar token en base de datos
    $stmt = $pdo->prepare("UPDATE usuarios SET session_token = :token WHERE id = :id");
    $stmt->execute([
        ':token' => $session_token,
        ':id' => $user['id']
    ]);

    // Guardar datos en la sesión
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_nombre'] = $user['nombre'];
    $_SESSION['user_correo'] = $user['correo'];
    $_SESSION['rol'] = $user['rol'];
    $_SESSION['session_token'] = $session_token;

    // Redirigir con éxito
    header("Location: ../pages/login.php?exito=1");
    exit;

} else {
    header('Location: ../login.html');
    exit;
}
