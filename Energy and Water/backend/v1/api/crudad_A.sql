-- Archivo: crudad_A.sql
-- Queries de Prueba (CREATE, READ, UPDATE, DELETE, ACTIVATE/DEACTIVATE)
-- Para los recursos de la API Energy and Water (Esquema A)

USE ciisa_backend_v1_eva2_A;

-- =======================================================
-- 1. RECURSO: categoria_servicio
-- =======================================================
-- CREATE (POST)
INSERT INTO categoria_servicio (nombre, imagen, texto, activo) 
VALUES ('Electricidad', 'url_imagen_electricidad', 'Servicios de instalación y reparación eléctrica.', TRUE);

-- READ (GET)
SELECT id, nombre, texto, activo FROM categoria_servicio WHERE id = 1;

-- UPDATE (PUT)
UPDATE categoria_servicio SET nombre = 'Climatización Avanzada', imagen = 'url_nueva_imagen', texto = 'Servicios especializados de A/C.', activo = TRUE WHERE id = 1;

-- PATCH (DESACTIVATE)
UPDATE categoria_servicio SET activo = FALSE WHERE id = 1;

-- DELETE
DELETE FROM categoria_servicio WHERE id = 1;

-- =======================================================
-- 2. RECURSO: mantenimiento_info
-- =======================================================
-- CREATE (POST)
INSERT INTO mantenimiento_info (nombre, texto, activo) 
VALUES ('Revisión Trimestral de Bombas', 'Mantenimiento preventivo de bombas hidráulicas.', TRUE);

-- UPDATE (PUT)
UPDATE mantenimiento_info SET texto = 'Inspección de válvulas y sellos mecánicos.', activo = TRUE WHERE id = 1;

-- PATCH (ACTIVATE)
UPDATE mantenimiento_info SET activo = TRUE WHERE id = 1;

-- DELETE
DELETE FROM mantenimiento_info WHERE id = 1;

-- =======================================================
-- 3. RECURSO: info_contacto
-- =======================================================
-- CREATE (POST)
INSERT INTO info_contacto (nombre, texto, texto_adicional, activo) 
VALUES ('Whatsapp', '+56 9 3083 5203', 'Horario de atención: 9:00 - 18:00', TRUE);

-- READ (GET ALL)
SELECT * FROM info_contacto;

-- UPDATE (PATCH)
UPDATE info_contacto SET activo = FALSE WHERE nombre = 'Whatsapp';

-- DELETE
DELETE FROM info_contacto WHERE nombre = 'Whatsapp';

-- =======================================================
-- 4. RECURSO: historia
-- =======================================================
-- CREATE (POST)
INSERT INTO historia (tipo, texto, activo) 
VALUES ('hitos', 'Obtuvimos la certificación ISO 9001 en 2020.', TRUE);

-- UPDATE (PUT)
UPDATE historia SET texto = 'Nuestra visión es liderar el mantenimiento edilicio en Chile.', activo = TRUE WHERE id = 1;

-- DELETE
DELETE FROM historia WHERE id = 1;

-- =======================================================
-- 5. RECURSO: equipo
-- =======================================================
-- CREATE (POST)
INSERT INTO equipo (tipo, nombre, texto, activo) 
VALUES ('Técnico Senior', 'Carlos Soto', 'Experiencia en calderas y grupos electrógenos.', TRUE);

-- UPDATE (PATCH)
UPDATE equipo SET activo = FALSE WHERE nombre = 'Carlos Soto';

-- DELETE
DELETE FROM equipo WHERE id = 1;

-- =======================================================
-- 6. RECURSO: pregunta_frecuente
-- =======================================================
-- CREATE (POST)
INSERT INTO pregunta_frecuente (pregunta, respuesta, activo) 
VALUES ('¿Usan sistemas de telegestión?', 'Sí, monitoreamos las instalaciones 24/7.', TRUE);

-- UPDATE (PUT)
UPDATE pregunta_frecuente SET respuesta = 'Utilizamos IoT para monitoreo y control.', activo = TRUE WHERE id = 1;

-- DELETE
DELETE FROM pregunta_frecuente WHERE id = 1;
