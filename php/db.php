<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'music_store_unidad3';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la base si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

    // Conectarse ahora sí a la DB
    $pdo->exec("USE `$dbname`");

    // Crear la tabla si no existe con campo 'rol'
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        correo VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        rol ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario',
        creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // ADMIN TEMPORAL SOLO SI NO EXISTE
    $correo_admin = 'df';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo_admin]);
// aaaa comentrioo
} catch (PDOException $e) {
    exit("Error de conexión: " . $e->getMessage());
}
?>
