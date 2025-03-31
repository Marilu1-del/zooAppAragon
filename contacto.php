<?php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Zoológico San Juan de Aragón</title>
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>
    <style>
        body {
            background-color: #e0f7fa;
        }

        /* Navigation Bar */
        nav {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 1rem 2rem;
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
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
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
        }

        footer a {
            color: #ffeb3b;
            text-decoration: none;
        }
    </style>

</head>

<body>
    <!-- Navbar -->
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

    <!-- Sección de Contacto -->
    <section id="contacto" style="padding: 2rem; text-align: center; background-color: #e0f7fa;">
        <h2>Contacto</h2>
        <p>Para cualquier consulta o sugerencia, puedes comunicarte con nosotros a través del siguiente formulario:</p>

        <p><strong>Dirección:</strong> Av. José Loreto Fabela s/n, Gustavo A. Madero, CDMX</p>
        <p><strong>Teléfono:</strong> +52 55 1234 5678</p>
        <p><strong>Horario de atención:</strong> Martes a Domingo, 9:00 AM - 16:30 PM</p>

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.4566137398586!2d-99.0955633!3d19.4486848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1fcd1f892d7ff%3A0x9e46f87bcaee6a9a!2sZool%C3%B3gico%20de%20San%20Juan%20de%20Arag%C3%B3n!5e0!3m2!1ses!2smx!4v1643642529368!5m2!1ses!2smx"
            width="100%" height="300" style="border:0; margin-bottom: 1rem;" allowfullscreen="" loading="lazy">
        </iframe>
        <p><strong>Ubicación en el mapa:</strong> El Zoológico San Juan de Aragón se encuentra dentro del Bosque de San
            Juan de Aragón, al noreste de la Ciudad de México. Se ha marcado en el mapa para una mejor referencia.</p>

        <form action="enviar_formulario.php" method="POST" style="max-width: 500px; margin: auto; text-align: left;">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Escribe tu nombre" required
                style="width: 100%; padding: 0.5rem; margin-bottom: 1rem;">

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required
                style="width: 100%; padding: 0.5rem; margin-bottom: 1rem;">

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" placeholder="Escribe tu mensaje aquí" required
                style="width: 100%; padding: 0.5rem; height: 150px; margin-bottom: 1rem;"></textarea>

            <button type="submit"
                style="background: #00796b; color: white; padding: 0.8rem; border: none; cursor: pointer; width: 100%; font-weight: bold;">Enviar</button>
        </form>

        <p style="margin-top: 1.5rem;">Síguenos en nuestras redes:</p>
        <a href="https://www.facebook.com/ZooAragon" target="_blank">Facebook</a> |
        <a href="https://www.instagram.com/ZooAragon" target="_blank">Instagram</a> |
        <a href="https://twitter.com/ZooAragon" target="_blank">Twitter</a>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | <a href="iniciosesion.php">Administrador</a> | <a
                href="perfil_usuario.html">Usuario</a></p>
    </footer>
</body>

</html>