<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/../php/db.php'); 

// Crear tabla si no existe
$pdo->exec("CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    img VARCHAR(255) NOT NULL,
    creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

try {
    // Obtener productos
    $stmt = $pdo->query("SELECT nombre, descripcion, img FROM productos ORDER BY creado DESC");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($productos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener productos']);
}
