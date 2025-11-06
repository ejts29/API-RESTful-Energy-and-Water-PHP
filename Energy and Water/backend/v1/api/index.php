<?php
// backend/v1/api/index.php
//  Punto de entrada “v1” para la API
// Cabeceras CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=utf-8");

// Responder inmediatamente al preflight de CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Información básica de la versión
$meta = [
    'api'       => 'EnergyAndWater',
    'version'   => 'v1',
    'endpoints' => [
        'GET     /categoria_servicio/',
        'GET     /categoria_servicio/?id={id}',
        'POST    /categoria_servicio/',
        'PUT     /categoria_servicio/?id={id}',
        'PATCH   /categoria_servicio/?id={id}',
        'DELETE  /categoria_servicio/?id={id}',
        'GET     /equipo/',
        'GET     /equipo/?id={id}',
        'POST    /equipo/',
        'PUT     /equipo/?id={id}',
        'PATCH   /equipo/?id={id}',
        'DELETE  /equipo/?id={id}',
        'GET     /historia/',
        'GET     /historia/?id={id}',
        'POST    /historia/',
        'PUT     /historia/?id={id}',
        'PATCH   /historia/?id={id}',
        'DELETE  /historia/?id={id}',
        'GET     /info_contacto/',
        'GET     /info_contacto/?id={id}',
        'POST    /info_contacto/',
        'PUT     /info_contacto/?id={id}',
        'PATCH   /info_contacto/?id={id}',
        'DELETE  /info_contacto/?id={id}',
        'GET     /mantenimiento_info/',
        'GET     /mantenimiento_info/?id={id}',
        'POST    /mantenimiento_info/',
        'PUT     /mantenimiento_info/?id={id}',
        'PATCH   /mantenimiento_info/?id={id}',
        'DELETE  /mantenimiento_info/?id={id}',
        'GET     /pregunta_frecuente/',
        'GET     /pregunta_frecuente/?id={id}',
        'POST    /pregunta_frecuente/',
        'PUT     /pregunta_frecuente/?id={id}',
        'PATCH   /pregunta_frecuente/?id={id}',
        'DELETE  /pregunta_frecuente/?id={id}',
        
    ]
];

// Envía un listado de los recursos disponibles
echo json_encode([
    'message' => 'API EnergyAndWater v1',
    'available_endpoints' => $meta['endpoints']
], JSON_UNESCAPED_UNICODE);
