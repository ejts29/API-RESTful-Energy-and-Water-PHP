<?php
// backend/v1/api/mantenedor/controller.php

require_once __DIR__ . '/../conexion.php';  // debebemos definir function conectarBD(): PDO

/**
 * Ejecuta operaciones CRUD y activate/deactivate genéricas sobre una tabla permitida.
 *
 * @param PDO    $pdo        Conexión PDO activa.
 * @param string $tabla      Nombre de la tabla (recurso).
 * @param string $operacion  CREATE | READ | UPDATE | DELETE | ACTIVATE | DEACTIVATE.
 * @param array  $datos      Array asociativo con los campos y valores.
 * @param int    $id         ID para READ/UPDATE/DELETE/ACTIVATE/DEACTIVATE (opcional).
 *
 * @return array Resultado de la operación o datos.
 * @throws Exception en errores de validación o SQL.
 */
function ejecutarMantenedor(PDO $pdo, string $tabla, string $operacion, array $datos = [], ?int $id = null): array
{
    // 1) Validar tabla permitida
    $tablasPermitidas = [
        'mantenimiento_info',
        'categoria_servicio',
        'info_contacto',
        'historia',
        'equipo',
        'pregunta_frecuente'
    ];
    if (!in_array($tabla, $tablasPermitidas)) {
        throw new Exception("Tabla no permitida: $tabla");
    }

    // Normalizar operación
    $op = strtoupper($operacion);

    // 2) Ejecutar dentro de transacción
    $pdo->beginTransaction();
    try {
        switch ($op) {
            case 'CREATE':
            case 'INSERT':
                if (empty($datos)) {
                    throw new Exception("Datos vacíos para CREATE");
                }
                $cols = array_keys($datos);
                $phs  = array_map(fn($c)=>":$c", $cols);
                $sql  = "INSERT INTO `$tabla` (" . implode(',', $cols) . ") VALUES (" . implode(',', $phs) . ")";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($datos);
                $newId = (int)$pdo->lastInsertId();
                $pdo->commit();
                return ['mensaje'=>'Insertado','id'=>$newId];

            case 'READ':
                if ($id !== null) {
                    $sql = "SELECT * FROM `$tabla` WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['id'=>$id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $pdo->commit();
                    return $row ? $row : [];
                } else {
                    $sql = "SELECT * FROM `$tabla`";
                    $stmt = $pdo->query($sql);
                    $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $pdo->commit();
                    return $all;
                }

            case 'UPDATE':
                if ($id === null) {
                    throw new Exception("Falta id para UPDATE");
                }
                if (empty($datos)) {
                    throw new Exception("Datos vacíos para UPDATE");
                }
                // Quitar id de datos si existe
                unset($datos['id']);
                $sets = implode(', ', array_map(fn($c)=>"`$c`=:$c", array_keys($datos)));
                $sql  = "UPDATE `$tabla` SET $sets WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $datos['id'] = $id;
                $stmt->execute($datos);
                $pdo->commit();
                return ['mensaje'=>'Actualizado','affected'=>$stmt->rowCount()];

            case 'DELETE':
                if ($id === null) {
                    throw new Exception("Falta id para DELETE");
                }
                $stmt = $pdo->prepare("DELETE FROM `$tabla` WHERE id = :id");
                $stmt->execute(['id'=>$id]);
                $pdo->commit();
                return ['mensaje'=>'Eliminado','deleted'=>$stmt->rowCount()];

            case 'ACTIVATE':
            case 'DEACTIVATE':
                if ($id === null) {
                    throw new Exception("Falta id para $op");
                }
                $activo = ($op === 'ACTIVATE') ? 1 : 0;
                $stmt = $pdo->prepare("UPDATE `$tabla` SET activo = :activo WHERE id = :id");
                $stmt->execute(['activo'=>$activo,'id'=>$id]);
                $pdo->commit();
                return ['mensaje'=> strtolower($op),'activo'=> (bool)$activo];

            default:
                throw new Exception("Operación no soportada: $operacion");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        // Lanzar para que el index.php capture y devuelva 500
        throw $e;
    }
}
