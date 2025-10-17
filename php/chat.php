<?php
header('Content-Type: application/json');

$entrada = json_decode(file_get_contents('php://input'), true);
$mensaje = strtolower(trim($entrada['mensaje'] ?? ''));

// Simular una pequeña espera para hacerlo más real
usleep(500000); // 0.5 segundos

$respuestas = [];

if (strpos($mensaje, 'hola') !== false || strpos($mensaje, 'buenas') !== false) {
    $respuestas[] = "¡Hola! ¿Que tal estas?";
}
if (strpos($mensaje, 'contraseña') !== false) {
    $respuestas[] = "Si olvidaste tu contraseña, puedes restablecerla desde la sección de perfil.";
}
if (strpos($mensaje, 'registrar') !== false || strpos($mensaje, 'registro') !== false) {
    $respuestas[] = "Para registrarte, ve al menú principal y haz clic en 'Registrarse'.";
}
if (strpos($mensaje, 'sugerencia') !== false || strpos($mensaje, 'comentario') !== false) {
    $respuestas[] = "Puedes dejar tus sugerencias en el Buzón de Sugerencias desde el menú.";
}
if (strpos($mensaje, 'agradezco') !== false || strpos($mensaje, 'gracias') !== false) {
    $respuestas[] = "¡Gracias a ti! Si necesitas algo más, aquí estaré.";
}
if (strpos($mensaje, 'nos vemos') !== false || strpos($mensaje, 'Adiós') !== false) {
    $respuestas[] = "¡Nos vemos! Espero haya sido de utilidad.";
}

// Si no hubo coincidencias, mandar mensaje por defecto
if (empty($respuestas)) {
    $respuestas[] = "Lo siento, no entendí eso. ¿Puedes reformularlo?";
}

// Unir todas las respuestas con un salto de línea
echo json_encode(['respuesta' => implode(" ", $respuestas)]);
?>
