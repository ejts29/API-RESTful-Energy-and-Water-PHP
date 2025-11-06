<?php
// backend/v1/api/mantenedor/index.php

//  CORS 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Sólo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Metodo no permitido. Use POST.']);
    exit;
}

//  Preparar entorno 
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexion.php';    // debebemos tener function conectarBD()
require_once __DIR__ . '/controller.php';     // debebemos contener ejecutarMantenedor()

// Conexión PDO
$pdo = conectarBD();

//  Leer y validar JSON de entrada 
$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido.']);
    exit;
}

$tabla     = $input['tabla']     ?? null;
$operacion = $input['operacion'] ?? null;
$datos     = $input['datos']     ?? null;
$id        = isset($input['id']) ? (int)$input['id'] : null;

if (
    empty($tabla) ||
    empty($operacion) ||
    !is_array($datos)
) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Parámetros inválidos. Se requieren: tabla, operacion, datos(array).'
    ]);
    exit;
}

//  Ejecutar operación 
try {
    $resultado = ejecutarMantenedor($pdo, $tabla, $operacion, $datos, $id);
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    // Si es error de validación/control, devolvemos 400; si no, 500
    $code = stripos($e->getMessage(), 'Falta') === 0 ? 400 : 500;
    http_response_code($code);
    echo json_encode(['error' => $e->getMessage()]);
}
