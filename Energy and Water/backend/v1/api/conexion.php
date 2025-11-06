<?php
// backend/v1/api/conexion.php

function conectarBD() {
    $host = 'localhost';
    $dbname = 'ciisa_backend_v1_eva2_A'; //  Nombre de la base de datos
    $user = 'root';                      // Por defecto en XAMPP
    $pass = '';                          // Contraseña vacía por defecto en XAMPP

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // Lanza una excepción para que el controlador la maneje
        throw new Exception("Error de conexión: " . $e->getMessage());
    }
}

