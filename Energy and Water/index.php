<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Energy and Water - Visor API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos CSS mejorados */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8; /* Un gris claro más moderno */
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #0056b3; /* Un azul más moderno y accesible */
            color: white;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sutil sombra */
        }

        header .logo-container {
            display: flex;
            align-items: center;
        }

        header img {
            height: 50px; /* Un tamaño de logo más manejable */
            margin-right: 15px;
        }

        header h1 {
            font-size: 1.5em; /* Título más prominente */
            font-weight: bold;
        }

        nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: normal; /* Peso de fuente más legible */
            transition: color 0.3s ease; /* Transición suave al pasar el ratón */
        }

        nav a:hover {
            color: #f0f8ff; /* Un color más claro al pasar el ratón */
            text-decoration: underline;
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        section {
            background: white;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08); /* Sombra más suave y extendida */
            padding: 25px; /* Un poco más de espacio interno */
            border: 1px solid #e0e0e0; /* Borde sutil */
        }

        section h2 {
            color: #0056b3;
            margin-bottom: 20px;
            border-bottom: 2px solid #0056b3; /* Línea inferior para separar el título */
            padding-bottom: 10px;
        }

        pre {
            background: #f9f9f9; /* Un gris muy claro para el fondo del código */
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 0.9em;
            border: 1px solid #ddd; /* Borde para el bloque de código */
            white-space: pre-wrap; /* Permite el ajuste de línea */
        }

        footer {
            background-color: #0056b3;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            font-size: 0.9em;
        }

        footer a {
            color: #f0f8ff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            text-decoration: underline;
            color: #fff;
        }

        /* Estilos para mejorar la legibilidad en pantallas pequeñas */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            header nav {
                margin-top: 15px;
            }

            nav a {
                margin: 0 10px;
                font-size: 0.95em;
            }

            main {
                padding: 0 15px;
            }

            section {
                padding: 20px;
            }

            section h2 {
                font-size: 1.3em;
            }

            pre {
                font-size: 0.85em;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="#" alt="Logo Energy and Water">
            <h1>Visor API</h1>
        </div>
        <nav>
            <a href="#mantenimiento">Mantenimiento</a>
            <a href="#categoria">Categorías</a>
            <a href="#contacto">Contacto</a>
            <a href="#historia">Historia</a>
            <a href="#equipo">Equipo</a>
            <a href="#faq">FAQ</a>
        </nav>
    </header>

    <main>
        <section id="mantenimiento">
            <h2>Mantenimiento</h2>
            <pre id="mantenimiento-data">Cargando datos...</pre>
        </section>

        <section id="categoria">
            <h2>Categorías de Servicio</h2>
            <pre id="categoria-data">Cargando datos...</pre>
        </section>

        <section id="contacto">
            <h2>Información de Contacto</h2>
            <pre id="contacto-data">Cargando datos...</pre>
        </section>

        <section id="historia">
            <h2>Historia de la Empresa</h2>
            <pre id="historia-data">Cargando datos...</pre>
        </section>

        <section id="equipo">
            <h2>Nuestro Equipo</h2>
            <pre id="equipo-data">Cargando datos...</pre>
        </section>

        <section id="faq">
            <h2>Preguntas Frecuentes</h2>
            <pre id="faq-data">Cargando datos...</pre>
        </section>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Energy and Water - <a href="https://www.energyandwater.cl/" target="_blank">Sitio Oficial</a>
    </footer>

    <script>
        async function cargarDatos(endpoint, elementoId) {
            try {
                const response = await fetch(endpoint);
                if (!response.ok) throw new Error("Error " + response.status);
                const data = await response.json();
                document.getElementById(elementoId).textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                document.getElementById(elementoId).textContent = "Error al cargar datos: " + error;
            }
        }

        // URLs  rutas reales en localhost (sin espacios en carpetas)
        cargarDatos('http://localhost/Energy%20and%20Water/backend/v1/api/mantenimiento_info/index.php', 'mantenimiento-data');
        cargarDatos('http://localhost/Energy%20and%20Water/backend/v1/api/categoria_servicio/index.php', 'categoria-data');
        cargarDatos('http://localhost/Energy%20and%20Water/backend/v1/api/info_contacto/index.php', 'contacto-data');
        cargarDatos('http://localhost/Energy%20and%20Water/backend/v1/api/historia/index.php', 'historia-data');
        cargarDatos('http://localhost/Energy%20and%20Water/backend/v1/api/equipo/index.php', 'equipo-data');
        cargarDatos('http://localhost/Energy%20and%20Water/backend/v1/api/pregunta_frecuente/index.php', 'faq-data');
    </script>

</body>
</html>