<?php
session_start();
require_once(__DIR__ . '/db.php');

// Crear la tabla de comentarios si no existe
$pdo->exec("
    CREATE TABLE IF NOT EXISTS comentarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        usuario_nombre VARCHAR(100) NOT NULL,
        comentario TEXT NOT NULL,
        fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
    )
");

// POST: agregar comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_nombre'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Debes iniciar sesión para comentar.']);
        exit;
    }

    $usuario_id = $_SESSION['user_id'];
    $usuario_nombre = $_SESSION['user_nombre'];
    $comentario = trim($_POST['comentario'] ?? '');

    if ($comentario === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Comentario vacío.']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO comentarios (usuario_id, usuario_nombre, comentario) VALUES (:usuario_id, :usuario_nombre, :comentario)");
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':usuario_nombre' => $usuario_nombre,
        ':comentario' => $comentario
    ]);

    echo json_encode(['success' => true]);
    exit;
}

// DELETE: eliminar comentario (solo admin)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str($_SERVER['QUERY_STRING'], $params);
    $id = $params['id'] ?? null;

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        http_response_code(403);
        echo json_encode(['error' => 'Solo administradores pueden eliminar comentarios.']);
        exit;
    }

    if (!$id || !is_numeric($id)) {
        http_response_code(400);
        echo json_encode(['error' => 'ID inválido.']);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM comentarios WHERE id = :id");
    $stmt->execute([':id' => $id]);

    echo json_encode(['success' => true]);
    exit;
}

// GET: devolver comentarios y estado login
$stmt = $pdo->query("SELECT id, usuario_nombre AS usuario, comentario, fecha FROM comentarios ORDER BY fecha DESC");
$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agregar campo admin: true si el usuario actual es admin
foreach ($comentarios as &$c) {
    $c['admin'] = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

echo json_encode([
    'logeado' => isset($_SESSION['user_id']),
    'comentarios' => $comentarios
]);
