<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$tipo = $_GET['tipo'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: ../pages/admin_panel.php");
    exit;
}

if ($tipo === 'producto') {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
} elseif ($tipo === 'usuario') {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND rol != 'admin'");
    $stmt->execute([$id]);
}

header("Location: ../pages/admin_panel.php");
exit;
?>
