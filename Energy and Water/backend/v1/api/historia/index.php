<?php
// backend/v1/api/historia/index.php

//  CORS & JSON 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
header('Content-Type: application/json; charset=utf-8');

//  Conexión 
require_once __DIR__ . '/../conexion.php';
$pdo = conectarBD();

//  Obtener ID si existe 
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Leer body JSON 
$input = null;
if (in_array($_SERVER['REQUEST_METHOD'], ['POST','PUT','PATCH'])) {
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error'=>'JSON inválido']);
        exit;
    }
}

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM historia WHERE id = :id");
                $stmt->execute(['id'=>$id]);
                $row = $stmt->fetch();
                if (!$row) {
                    http_response_code(404);
                    echo json_encode(['error'=>'Historia no encontrada']);
                    exit;
                }
                echo json_encode($row);
            } else {
                $stmt = $pdo->query("SELECT * FROM historia");
                echo json_encode($stmt->fetchAll());
            }
            break;

            case 'POST':
                // validar campos obligatorios
                foreach (['tipo','texto'] as $f) {
                    if (empty($input[$f])) {
                        http_response_code(400);
                        echo json_encode(['error'=>"Falta campo obligatorio: $f"]);
                        exit;
                    }
                }
    
                $stmt_max_id = $pdo->query("SELECT MAX(id) FROM historia");
                $max_id = $stmt_max_id->fetchColumn();
                $next_id = $max_id ? (int)$max_id + 1 : 1; // Si no hay registros, empezar en 1
    
                $pdo->beginTransaction();
                $stmt = $pdo->prepare(
                    "INSERT INTO historia (id, tipo, texto, activo)
                     VALUES (:id, :tipo, :texto, 1)"
                );
                $stmt->execute([
                    'id' => $next_id,
                    'tipo' => $input['tipo'],
                    'texto' => $input['texto']
                ]);
                $pdo->commit();
                http_response_code(201);
                echo json_encode(['id'=>$next_id]);
                break;

                case 'PUT':
                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['error'=>'Se requiere id en query string']);
                        exit;
                    }
                    $fields = array_intersect_key($input, array_flip(['tipo','texto','activo']));
                    if (empty($fields)) {
                        http_response_code(400);
                        echo json_encode(['error'=>'No hay campos válidos para actualizar']);
                        exit;
                    }
                    $sets = implode(", ", array_map(fn($c)=>"$c=:$c", array_keys($fields)));
                    $fields['id'] = $id;
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare("UPDATE historia SET $sets WHERE id=:id");
                    $stmt->execute($fields);
                    $pdo->commit();
                    echo json_encode(['updated'=>$stmt->rowCount()]);
                    break;

        case 'PATCH':
            if (!$id || !isset($input['activo'])) {
                http_response_code(400);
                echo json_encode(['error'=>'Se requiere id y campo activo']);
                exit;
            }
            $activo = $input['activo'] ? 1 : 0;
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("UPDATE historia SET activo=:activo WHERE id=:id");
            $stmt->execute(['activo'=>$activo,'id'=>$id]);
            $pdo->commit();
            echo json_encode(['changed'=>$stmt->rowCount(),'activo'=>(bool)$activo]);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error'=>'Se requiere id para eliminar']);
                exit;
            }
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("DELETE FROM historia WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            $pdo->commit();
            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(['error'=>'Historia no encontrada']);
                exit;
            }
            http_response_code(204);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error'=>'Método no permitido']);
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error'=>'Error de servidor','detalle'=>$e->getMessage()]);
}

