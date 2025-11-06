<?php
// CORS y tipo de respuesta JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
header("Content-Type: application/json; charset=UTF-8");

// Leer el cuerpo del JSON
$input = json_decode(file_get_contents("php://input"), true);
if (!$input || !isset($input['nombre'], $input['email'], $input['mensaje'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos obligatorios']);
    exit;
}

$nombre = $input['nombre'];
$email = $input['email'];
$mensaje = $input['mensaje'];

//  GUARDAR EN BASE DE DATOS 
require_once __DIR__ . '/v1/api/conexion.php';

try {
    $pdo = conectarBD();
    $stmt = $pdo->prepare("INSERT INTO contacto (nombre, email, mensaje, fecha) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$nombre, $email, $mensaje]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar en la base de datos', 'detalle' => $e->getMessage()]);
    exit;
}

// ENVIAR CORREO 
$to = 'tu_correo@dominio.com'; 
$subject = 'Nuevo mensaje de contacto';
$body = "Nombre: $nombre\nEmail: $email\nMensaje:\n$mensaje";
$headers = "From: contacto@energyandwater.cl\r\nReply-To: $email";

$mail_enviado = mail($to, $subject, $body, $headers);

if (!$mail_enviado) {
    // Nota: mail() no lanza errores, por eso validamos manualmente
    echo json_encode(['advertencia' => 'El mensaje fue guardado pero no se pudo enviar el correo.']);
    exit;
}

// RESPUESTA OK 
http_response_code(200);
echo json_encode(['mensaje' => 'Gracias por contactarnos. Hemos recibido tu mensaje.']);