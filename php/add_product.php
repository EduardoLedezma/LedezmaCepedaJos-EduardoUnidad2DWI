<?php
session_start();
require_once __DIR__ . 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $img = trim($_POST['img']);

    if ($nombre && $descripcion && $img) {
        // Crear tabla si no existe
        $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            descripcion TEXT NOT NULL,
            img VARCHAR(255) NOT NULL,
            creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, img) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $img]);
    }
    header("Location: ../pages/admin_panel.php");
    exit;
}
?>
