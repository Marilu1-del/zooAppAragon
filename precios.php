<?php
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precios - Zoológico San Juan de Aragón</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Agrega tu CSS si es necesario -->
    <script defer src="js/script.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-direction: column;
            /* Para que el footer se pegue abajo */
            min-height: 100vh;
            /* Asegura que el body tenga al menos la altura de la pantalla */
        }

        /* Contenedor principal para centrar el contenido y dar ancho al nav y footer */
        .contenedor-principal {
            width: 100%;
            /* Ancho completo */
            max-width: 1200px;
            /* Ancho máximo para pantallas grandes */
            margin: 0 auto;
            /* Centrar horizontalmente */
            flex: 1;
            /* Permite que el contenido principal se expanda */
            padding: 20px;
            /* Espacio alrededor del contenido */
            display: flex; /* Habilitar flexbox en el contenedor principal */
            flex-direction: column; /* Alinear elementos verticalmente */
            align-items: center; /* Centrar horizontalmente los elementos */
            justify-content: center; /* Centrar verticalmente los elementos */
        }

        #precios {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin-top: 20px;
            width: 100%; /* Ocupa el ancho del contenedor principal */
            width: auto; /* Ajustar el ancho automáticamente al contenido de la tabla */
            max-width: 800px; /* Mantener un ancho máximo */
            margin: 20px 0; /* Margen arriba y abajo, 0 a los lados para centrar */
        }


        h1 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin: 0 auto; /* Centrar la tabla dentro de #precios */
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background: #00796b;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #ddd;
        }

        p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        a {
            color: #00796b;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Navigation Bar */
        nav {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 1rem 2rem;
            width: 100%;
            /* Ancho completo */
            box-sizing: border-box;
            /* Incluir padding en el ancho */
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            font-family: 'Poppins', sans-serif;
        }

        nav h1 {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        nav h1 img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: #ffeb3b;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 1.5rem;
            text-align: center;
            width: 100%;
            /* Ancho completo */
            box-sizing: border-box;
            /* Incluir padding en el ancho */
        }

        footer a {
            color: #ffeb3b;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <nav>
        <h1>
            <img src="imagenes/evento1.jpg" alt="Zoo Logo">
            Zoológico San Juan de Aragón
        </h1>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="mapaZooAragon.php">Mapa</a></li>
            <li><a href="animales.php">Animales</a></li>
            <li><a href="zonas.php">Zonas</a></li>
            <li><a href="actividades.php">Actividades</a></li>
            <li><a href="precios.php">Precios</a></li>
            <li><a href="nosotros.php">Sobre Nosotros</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <div class="contenedor-principal">
        <section id="precios">
            <h2>Precios de Actividades</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Precio (MXN)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Entrada General</td>
                        <td>Gratuita</td>
                    </tr>
                    <tr>
                        <td>Herpetario</td>
                        <td>$69.00</td>
                    </tr>
                    <tr>
                        <td>Dinoexcava</td>
                        <td>$49.00</td>
                    </tr>
                    <tr>
                        <td>Paseo en Tren</td>
                        <td>$50.00</td>
                    </tr>
                    <tr>
                        <td>Combo 1 (Herpetario + Dinoexcava)</td>
                        <td>$99.00</td>
                    </tr>
                    <tr>
                        <td>Combo Plus (Tren + Herpetario + Dinoexcava)</td>
                        <td>$129.00</td>
                    </tr>
                </tbody>
            </table>
            <p>*Los precios pueden estar sujetos a cambios. Consulta en <a href="https://zooaventuras.mx/boletos/"
                    target="_blank">Zooaventuras</a> para información actualizada.</p>
        </section>
    </div>
    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | <a href="iniciosesion.php">Administrador</a> | <a
                href="perfil_usuario.html">Usuario</a></p>
    </footer>
</body>

</html>