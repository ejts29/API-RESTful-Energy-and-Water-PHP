<?php
// backend/index.php

// Definir la carpeta base de la API
$baseDir = __DIR__ . '/v1/api';

// Obtener la parte de la URI después de "/backend"
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$requestUri = $_SERVER['REQUEST_URI'];
$path = substr($requestUri, strlen($scriptName));

// Fijar PATH_INFO para version1.php
$_SERVER['PATH_INFO'] = $path;

// Incluir el front controller de la versión 1
require $baseDir . '/version1.php';
