

<?php 
 ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoológico San Juan de Aragón</title>
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>
    <style>
        /* General Styles */
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            background-color: #e0f7fa;
            color: #333;
        }

        .content {
            flex: 1;
            padding: 2rem;
            text-align: center;
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

    <div class="content">
        <h2>Actividades</h2>
        <p>Vive experiencias increíbles con nuestros programas.</p>
        <div class="grid-animales">
            <div class="animal">
                <img src="imagenes/aviario.jpg" alt="León">
                <div class="overlay">Aviario</div>
            </div>
            <div class="animal">
                <img src="imagenes/demoaves.jpg" alt="Elefante">
                <div class="overlay">Demostración de aves</div>
            </div>
            <div class="animal">
                <img src="imagenes/herpetario.jpg" alt="Jirafa">
                <div class="overlay">Herpetario</div>
            </div>
            <div class="animal">
                <img src="imagenes/jardinplantas.jpg" alt="Tigre">
                <div class="overlay">Jardín de plantas</div>
            </div>
            <div class="animal">
                <img src="imagenes/tren.jpg" alt="Tigre">
                <div class="overlay">Recorrido en tren</div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | <a href="iniciosesion.php">Administrador</a> | <a
                href="perfil_usuario.html">Usuario</a></p>
    </footer>
</body>

</html>