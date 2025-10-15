<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['email'] ?? '');

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../pages/recover.php?error=correo");
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("Location: ../pages/recover.php?error=sin_cuenta");
        exit;
    }

    $token = bin2hex(random_bytes(32));
    $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $pdo->prepare("UPDATE usuarios SET token_recuperacion = :token, token_expira = :expira WHERE id = :id");
    $stmt->execute([
        ':token' => $token,
        ':expira' => $expira,
        ':id' => $usuario['id']
    ]);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tjamesjoseph6@gmail.com';
        $mail->Password = 'lack eoeq oinz ipss'; // Clave de app
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('tjamesjoseph6@gmail.com', 'Tienda Musical');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body = "Hola, haz clic aquí para restablecer tu contraseña:<br><br>
        <a href='http://localhost/Practica-Gabriel-Unidad3/pages/reset_password.php?token=$token'>Recuperar contraseña</a><br><br>
        Este enlace expirará en 1 hora.";

        $mail->send();
        header("Location: ../pages/recover.php?exito=1");
        exit;
    } catch (Exception $e) {
        header("Location: ../pages/recover.php?error=email");
        exit;
    }
}
// nomas quiero recuperar mis credenciales
?>
