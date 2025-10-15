<?php
session_start();
require_once(__DIR__ . '/db.php');

// Si hay sesión activa, borra el token de la base de datos
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("UPDATE usuarios SET session_token = NULL WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);
}

// Destruir la sesión
session_unset();
session_destroy();

// Redirigir al login
header("Location: /Practica-Gabriel-Unidad3/pages/login.php");
exit();
?>
