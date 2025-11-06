<?php
// backend/v1/api/version1.php
// Front controller para la API de EnergyAndWater
// Front controller versión 1


// Cabeceras para CORS y respuestas JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=utf-8");

// Responder al preflight de CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Obtiene la ruta solicitada después de /v1/api/version1.php
// Ej: /v1/api/version1.php/categoria_servicio  ruta = "categoria_servicio"
$ruta = '';
if (isset($_SERVER['PATH_INFO'])) {
    $ruta = trim($_SERVER['PATH_INFO'], '/');
}

// Si no se especificó un recurso, mostramos la lista de endpoints disponibles
if ($ruta === '') {
    echo json_encode([
        'message' => 'API EnergyAndWater v1',
        'available_resources' => [
            'categoria_servicio',
            'equipo',
            'historia',
            'info_contacto',
            'mantenimiento_info',
            'pregunta_frecuente',
            
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Desglosamos el recurso (puede venir con subrutas, pero aquí solo usamos el primero)
$partes = explode('/', $ruta);
$recurso = array_shift($partes);

// Construimos la ruta al archivo index.php de ese recurso
$archivo = __DIR__ . '/' . $recurso . '/index.php';

if (file_exists($archivo)) {
    // Incluimos y ejecutamos ese endpoint
    require $archivo;
} else {
    // Si no existe, devolvemos 404
    http_response_code(404);
    echo json_encode([
        'error' => "Recurso '$recurso' no encontrado"
    ], JSON_UNESCAPED_UNICODE);
}