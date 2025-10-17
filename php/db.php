<?php
$host = 'host.docker.internal';              // Nombre del servicio MySQL en docker-compose
$user = 'root';
$pass = '';                // Contraseña vacía para root
$dbname = 'music_store_unidad3';
$charset = 'utf8mb4';

try {
    // Conectar al servidor MySQL sin seleccionar base de datos
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la base de datos si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

    // Seleccionar la base de datos
    $pdo->exec("USE `$dbname`");

    // Crear tabla 'usuarios' si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        correo VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        rol ENUM('usuario','admin') NOT NULL DEFAULT 'usuario',
        creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Crear tabla 'productos' si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT NOT NULL,
        img VARCHAR(255) NOT NULL,
        creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // ADMIN TEMPORAL (solo si no existe)
    $correo_admin = 'admin@tienda.com';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo_admin]);
    if ($stmt->fetchColumn() == 0) {
        $pass_admin = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, 'admin')")
            ->execute(['Administrador', $correo_admin, $pass_admin]);
    }

} catch (PDOException $e) {
    exit("Error de conexión: " . $e->getMessage());
}
?>
