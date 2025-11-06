<?php
// backend/v1/api/categoria_servicio/index.php

// CORS & Headers 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
header('Content-Type: application/json; charset=utf-8');

// Conexión a la base de datos 
require_once __DIR__ . '/../conexion.php';

try {
    $pdo = conectarBD();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo conectar a la base de datos', 'detalle' => $e->getMessage()]);
    exit;
}

// Obtener ID desde query string 
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

//Leer body JSON en métodos que lo requieren 
$input = null;
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'PATCH'])) {
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'JSON inválido']);
        exit;
    }
}

// Manejo de métodos 
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM categoria_servicio WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$row) {
                    http_response_code(404);
                    echo json_encode(['error' => 'Categoría no encontrada']);
                    exit;
                }
                echo json_encode($row);
            } else {
                $stmt = $pdo->query("SELECT * FROM categoria_servicio");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

            case 'POST':
                foreach (['nombre', 'imagen', 'texto'] as $f) {
                    if (empty($input[$f])) {
                        http_response_code(400);
                        echo json_encode(['error' => "Falta campo obligatorio: $f"]);
                        exit;
                    }
                }
    
                $stmt_max_id = $pdo->query("SELECT MAX(id) FROM categoria_servicio");
                $max_id = $stmt_max_id->fetchColumn();
                $next_id = $max_id ? (int)$max_id + 1 : 1; // Si no hay registros, empezar en 1
    
                $sql = "INSERT INTO categoria_servicio (id, nombre, imagen, texto, activo)
                        VALUES (:id, :nombre, :imagen, :texto, 1)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'id' => $next_id,
                    'nombre' => $input['nombre'],
                    'imagen' => $input['imagen'],
                    'texto' => $input['texto']
                ]);
                http_response_code(201);
                echo json_encode(['id' => $next_id]);
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Se requiere id en query string']);
                    exit;
                }
                $fields_to_update = array_intersect_key($input, array_flip(['nombre', 'imagen', 'texto', 'activo']));
                if (empty($fields_to_update)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'No hay campos válidos para actualizar']);
                    exit;
                }
                $sets = implode(", ", array_map(fn($c) => "$c = :$c", array_keys($fields_to_update)));
                $sql = "UPDATE categoria_servicio SET $sets WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $fields_to_execute = $fields_to_update;
                $fields_to_execute['id'] = $id; // Aseguramos que el ID esté presente para la cláusula WHERE
                $stmt->execute($fields_to_execute);
                echo json_encode(['updated' => $stmt->rowCount()]);
                break;

                case 'PATCH':
                    if (!$id || !array_key_exists('activo', $input)) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Se requiere id y campo activo']);
                        exit;
                    }
                    $activo = (int)(bool)$input['activo'];
                    $stmt = $pdo->prepare("UPDATE categoria_servicio SET activo = :activo WHERE id = :id");
                    $stmt->execute(['activo' => $activo, 'id' => $id]);
                    echo json_encode(['changed' => $stmt->rowCount(), 'activo' => (bool)$activo]);
                    break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'Se requiere id para eliminar']);
                exit;
            }
            $stmt = $pdo->prepare("DELETE FROM categoria_servicio WHERE id = :id");
            $stmt->execute(['id' => $id]);
            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(['error' => 'Categoría no encontrada']);
                exit;
            }
            http_response_code(204); // Sin contenido
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de servidor', 'detalle' => $e->getMessage()]);
}
