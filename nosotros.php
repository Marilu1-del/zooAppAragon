<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nosotros</title>
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f7fa;
        }

        section {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #000000;
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


    <section id="sobre-nosotros">
        <h2>Sobre Nosotros</h2>
        <p>El Zoológico de San Juan de Aragón, inaugurado en 1964, es uno de los principales zoológicos de la Ciudad de
            México. Ubicado en el noreste de la ciudad, dentro del Bosque de San Juan de Aragón, ofrece a los visitantes
            una experiencia única para conocer y admirar especies de fauna silvestre de México y el mundo.</p>
        <p>Tras una remodelación en 1998, el zoológico reabrió en 2002 con una nueva organización que agrupa a los
            animales según su continente de origen, recreando sus hábitats naturales para brindar una experiencia
            educativa y enriquecedora.</p>
        <img src="imagenes/animal3.jpg" alt="" srcset="" width="700px">
        <h3>Áreas Destacadas</h3>

        <ul>
            <li><strong>Zoológico antiguo:</strong> Lobo mexicano, perro de la pradera, coatíes, mapaches, pecaríes y
                coyotes.</li>
            <li><strong>Zona americana:</strong> Guacamayas verdes y leones marinos de California y la Patagonia.</li>
            <li><strong>Zona mexicana:</strong> Monos araña, jaguares, ocelotes, venado yucateco y un aviario.</li>
            <li><strong>Zona africana:</strong> Elefantes, rinocerontes blancos, chimpancés e hipopótamos.</li>
        </ul>
        <p>El zoológico trabaja en conjunto con el de Chapultepec, lo que permite el intercambio de animales y
            colaboraciones en investigación y veterinaria. También participa en programas de conservación, como el
            Centro de Rescate y Rehabilitación de Aves Rapaces, inaugurado en enero de 2022.</p>
        <p>Con entrada gratuita y ubicado en una extensa área verde, el Zoológico de San Juan de Aragón es una excelente
            opción para disfrutar de un día en contacto con la naturaleza y la fauna de diversas partes del mundo.</p>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | <a href="iniciosesion.php">Administrador</a> | <a
                href="perfil_usuario.html">Usuario</a></p>
    </footer>

</body>

</html>