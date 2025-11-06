 
-- Archivo: schema_user_tables_data_A.sql
-- Esquema de Base de Datos para la API RESTful de Energy and Water

-- 1. Creación de la Base de Datos y Usuario (para entorno local)
-- NOTA: Estos comandos deben ejecutarse manualmente antes de 'USE'
-- CREATE DATABASE ciisa_backend_v1_eva2_A;
-- CREATE USER 'ciisa_backend_v1_eva2_A'@'localhost' IDENTIFIED BY '14c143-c114';
-- GRANT ALL PRIVILEGES ON ciisa_backend_v1_eva2_A.* TO 'ciisa_backend_v1_eva2_A'@'localhost';
-- FLUSH PRIVILEGES;

USE ciisa_backend_v1_eva2_A;

-- =======================================================
-- 1. TABLA historia (Hitos y Misión de la Empresa)
-- =======================================================
CREATE TABLE historia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL, -- Ej: 'titulo', 'parrafo', 'mision'
    texto TEXT NOT NULL,
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Datos de ejemplo
INSERT INTO historia (tipo, texto, activo) VALUES 
('titulo', 'Nuestra Historia', TRUE),
('parrafo', 'Energy and Water se fundó con el objetivo de garantizar la eficiencia de las instalaciones en el rubro de la climatización y sistemas hidráulicos.', TRUE);

-- =======================================================
-- 2. TABLA equipo (Miembros del Equipo/Staff)
-- =======================================================
CREATE TABLE equipo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL, -- Ej: 'Fundador', 'Técnico', 'Gerente'
    nombre VARCHAR(100) NOT NULL,
    imagen TEXT, -- URL de la imagen del miembro del equipo
    texto TEXT, -- Pequeña biografía o descripción
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Datos de ejemplo
INSERT INTO equipo (tipo, nombre, texto, activo) VALUES 
('Fundador', 'Efren Tovar', 'Especialista en climatización y gestión de energía.', TRUE),
('Técnico', 'Eduardo Ahumada', 'Ingeniero en sistemas hidráulicos.', TRUE);

-- =======================================================
-- 3. TABLA info_contacto (Datos de Contacto de la Empresa)
-- =======================================================
CREATE TABLE info_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE, -- Ej: 'telefono', 'email', 'direccion'
    texto TEXT NOT NULL, -- El valor del dato (ej: +56 2 3256 9798)
    texto_adicional TEXT, -- Información extra (ej: horario de atención)
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Datos de ejemplo
INSERT INTO info_contacto (nombre, texto, texto_adicional, activo) VALUES 
('telefono', '+56 2 3256 9798', 'Atención 24/7', TRUE),
('email', 'contacto@energyandwater.cl', NULL, TRUE),
('direccion', 'Manquehue Sur 520, oficina 205, Las Condes', 'Santiago de Chile', TRUE);

-- =======================================================
-- 4. TABLA pregunta_frecuente (FAQ)
-- =======================================================
CREATE TABLE pregunta_frecuente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta TEXT NOT NULL,
    respuesta TEXT NOT NULL,
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Datos de ejemplo
INSERT INTO pregunta_frecuente (pregunta, respuesta, activo) VALUES 
('¿Qué servicios preventivos ofrecen?', 'Ofrecemos revisiones periódicas de climatización y salas de calderas para prolongar la vida útil de los activos.', TRUE),
('¿Cómo solicito un servicio correctivo?', 'Puede contactarnos por teléfono o a través de nuestra web para solucionar cualquier problema o avería en sus instalaciones.', TRUE);

-- =======================================================
-- 5. TABLA mantenimiento_info (Servicios de Mantenimiento Específicos)
-- =======================================================
CREATE TABLE mantenimiento_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL, -- Ej: 'Limpieza de filtros', 'Recarga de gas'
    texto TEXT,
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Datos de ejemplo
INSERT INTO mantenimiento_info (nombre, texto, activo) VALUES 
('Climatización: Recarga de Gas', 'Nos encargamos de la detección de fugas y la recarga de gas refrigerante en sistemas de aire acondicionado domésticos e industriales.', TRUE),
('Energía: Purga de Radiadores', 'Servicio preventivo para salas de calderas que ayuda a mejorar la eficiencia de la calefacción.', TRUE);

-- =======================================================
-- 6. TABLA categoria_servicio (Tipos de Mantenimiento)
-- =======================================================
CREATE TABLE categoria_servicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE, -- Ej: 'Climatización', 'Electricidad'
    imagen TEXT, -- URL de la imagen representativa de la categoría
    texto TEXT,
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Datos de ejemplo
INSERT INTO categoria_servicio (nombre, imagen, texto, activo) VALUES 
('Climatización', 'URL_IMAGEN_CLIMATIZACION', 'Instalación, reparación y revisión de sistemas de aire acondicionado.', TRUE),
('Sistemas Hidráulicos', 'URL_IMAGEN_BOMBAS', 'Instalación, reparación y revisión de salas de bombas y bombas hidráulicas.', TRUE);

-- =======================================================
-- 7. TABLA contacto (Para guardar mensajes del formulario)
-- Nota: Esta tabla es requerida por contacto.php
-- =======================================================
CREATE TABLE contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha DATETIME NOT NULL
);