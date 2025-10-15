<?php
session_start();
require_once(__DIR__ . "/db.php");

$recaptcha_secret = "6Le6ylorAAAAAAYPTiGolCdFWv9VJmlLXe2Z1wmg";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/register.php');
    exit;
}

// Validar campos obligatorios
if (
    empty($_POST['nombre']) || empty($_POST['correo']) ||
    empty($_POST['password']) || empty($_POST['confirmar']) ||
    empty($_POST['g-recaptcha-response'])
) {
    header("Location: ../pages/register.php?error=campos");
    exit;
}

// Validar correo
if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
    header("Location: ../pages/register.php?error=correo");
    exit;
}

// Validar contraseñas iguales
if ($_POST['password'] !== $_POST['confirmar']) {
    header("Location: ../pages/register.php?error=contrasenas");
    exit;
}

// Validar reCAPTCHA
$captcha = $_POST['g-recaptcha-response'];
$ip = $_SERVER['REMOTE_ADDR'];
$verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$captcha}&remoteip={$ip}";

$response = file_get_contents($verify_url);
$responseKeys = json_decode($response, true);

if (!$responseKeys["success"]) {
    header("Location: ../pages/register.php?error=captcha");
    exit;
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = 'usuario'; // Asignación por defecto

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password, rol) VALUES (:nombre, :correo, :password, :rol)");
    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':password' => $password_hash,
        ':rol' => $rol
    ]);

    header("Location: ../pages/register.php?exito=1");
    exit;

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        header("Location: ../pages/register.php?error=duplicado");
        exit;
    } else {
        header("Location: ../pages/register.php?error=otro");
        exit;
    }
}
