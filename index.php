<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db   = "zoologico";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta de todas las especies registradas
$query = "SELECT * FROM animales";
$animales = $conn->query($query);
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

        /* Estilos para las tarjetas con efecto flip */
        .catalogo-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .flip-card {
            background-color: transparent;
            width: 250px;
            height: 350px;
            perspective: 1000px;
            margin: auto;
        }
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }
        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }
        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .flip-card-front {
            background-color: #fff;
            color: black;
        }
        .flip-card-front img {
            width: 100%;
            height: 60%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            object-fit: cover;
        }
        .flip-card-front h3 {
            margin: 10px 0 5px;
        }
        .flip-card-front p {
            margin: 0 10px;
            font-size: 0.9em;
            color: #555;
        }
        .flip-card-back {
            background-color: #f8f8f8;
            color: #333;
            transform: rotateY(180deg);
            padding: 10px;
            box-sizing: border-box;
            border-radius: 10px;
            overflow-y: auto;
        }
        .flip-card-back h4 {
            margin-top: 0;
        }
        .flip-card-back ul {
            list-style: none;
            padding: 0;
            text-align: left;
            font-size: 0.9em;
        }
        .flip-card-back ul li {
            margin: 5px 0;
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
            <li><a href="zonas.html">Zonas</a></li>
            <li><a href="actividades.php">Actividades</a></li>
            <li><a href="#precios">Precios</a></li>
            <li><a href="nosotros.html">Sobre Nosotros</a></li>
            <li><a href="#contacto">Contacto</a></li>
        </ul>
    </nav>

    <!-- Sección de Animales (actualizada para mostrar los registros de la BD con efecto flip) -->
    <section id="animales">
        <h2>Nuestros Animales</h2>
        <p>Descubre una gran variedad de especies</p>
        <div class="catalogo-container">
            <?php 
            if ($animales && $animales->num_rows > 0) {
                while ($row = $animales->fetch_assoc()) {
                    $animalID     = $row["AnimalID"];
                    $nombre       = $row["nombre"];
                    $especie      = $row["especie"];
                    $clase        = $row["clase"];
                    $orden        = $row["orden"];
                    $familia      = $row["familia"];
                    $descripcion  = $row["descripcion"];
                    $alimentacion = $row["alimentacion"];
                    $distribucion = $row["distribucion"];
                    $peso         = $row["peso"];
                    $talla        = $row["talla"];
                    $gestacion    = $row["gestacion"];
                    $crias        = $row["crias"];
                    $imagen       = $row["imagen"];
            ?>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <!-- Frente de la tarjeta -->
                    <div class="flip-card-front">
                        <?php if (!empty($imagen)) { ?>
                            <img src="uploads/<?= $imagen ?>" alt="Imagen de <?= $nombre ?>">
                        <?php } else { ?>
                            <img src="imagenes/default.jpg" alt="Imagen por defecto">
                        <?php } ?>
                        <h3><?= $nombre ?></h3>
                        <p><?= $especie ?></p>
                    </div>
                    <!-- Reverso de la tarjeta -->
                    <div class="flip-card-back">
                        <h4>Detalles</h4>
                        <ul>
                            <li><strong>Clase:</strong> <?= $clase ?></li>
                            <li><strong>Orden:</strong> <?= $orden ?></li>
                            <li><strong>Familia:</strong> <?= $familia ?></li>
                            <li><strong>Descripción:</strong> <?= $descripcion ?></li>
                            <li><strong>Alimentación:</strong> <?= $alimentacion ?></li>
                            <li><strong>Distribución:</strong> <?= $distribucion ?></li>
                            <li><strong>Peso:</strong> <?= $peso ?> kg</li>
                            <li><strong>Talla:</strong> <?= $talla ?> cm</li>
                            <li><strong>Gestación:</strong> <?= $gestacion ?> días</li>
                            <li><strong>Crías:</strong> <?= $crias ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<p>No hay especies registradas.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Otras secciones (Zonas, Actividades, Precios, Eventos, etc.) -->
    <section id="zonas">
        <h2>Zonas del Zoológico</h2>
        <p>Explora nuestras diferentes áreas temáticas.</p>
        <div class="grid-animales">
            <div class="animal">
                <img src="imagenes/mexicana.jpg" alt="Zona Mexicana">
                <div class="overlay">Zona Mexicana</div>
                <div class="info-box">Descubre la fauna endémica de México en esta zona.</div>
            </div>
            <div class="animal">
                <img src="imagenes/americana.jpg" alt="Zona Americana">
                <div class="overlay">Zona Americana</div>
                <div class="info-box">Explora la diversidad de especies del continente americano.</div>
            </div>
            <div class="animal">
                <img src="imagenes/africana.jpg" alt="Zona Africana">
                <div class="overlay">Zona Africana</div>
                <div class="info-box">Admira la vida salvaje africana con leones, jirafas y más.</div>
            </div>
            <div class="animal">
                <img src="imagenes/antiguo.jpg" alt="Zoológico Antiguo">
                <div class="overlay">Zoológico Antiguo</div>
                <div class="info-box">Visita la zona más emblemática del zoológico con historia y tradición.</div>
            </div>
        </div>
    </section>
    
    <section id="actividades">
        <h2>Actividades</h2>
        <p>Vive experiencias increíbles con nuestros programas.</p>
        <div class="grid-animales">
            <div class="animal">
                <img src="imagenes/aviario.jpg" alt="Aviario">
                <div class="overlay">Aviario</div>
            </div>
            <div class="animal">
                <img src="imagenes/demoaves.jpg" alt="Demostración de aves">
                <div class="overlay">Demostración de aves</div>
            </div>
            <div class="animal">
                <img src="imagenes/herpetario.jpg" alt="Herpetario">
                <div class="overlay">Herpetario</div>
            </div>
            <div class="animal">
                <img src="imagenes/jardinplantas.jpg" alt="Jardín de plantas">
                <div class="overlay">Jardín de plantas</div>
            </div>
            <div class="animal">
                <img src="imagenes/tren.jpg" alt="Recorrido en tren">
                <div class="overlay">Recorrido en tren</div>
            </div>
        </div>
    </section>

    <section id="precios">
        <h2>Precios y Paquetes</h2>
        <p>Consulta nuestras tarifas y promociones.</p>
    </section>

    <section id="eventos">
        <div class="carousel-container">
            <h2>Eventos</h2>
            <p>Consulta nuestros diferentes eventos especiales</p>
            <button class="carousel-btn left" onclick="moveSlide(-1)">&#10094;</button>
            <div class="carousel-track">
                <div class="carousel-item"><img src="imagenes/herpetario.jpg" alt="Imagen 1"></div>
                <div class="carousel-item"><img src="imagenes/platicas.jpg" alt="Imagen 2"></div>
                <div class="carousel-item"><img src="imagenes/tren.jpg" alt="Imagen 3"></div>
                <div class="carousel-item"><img src="imagenes/areacomida.jpg" alt="Imagen 4"></div>
                <div class="carousel-item"><img src="imagenes/aviario.jpg" alt="Imagen 5"></div>
                <div class="carousel-item"><img src="imagenes/areadejuegos.jpg" alt="Imagen 6"></div>
                <div class="carousel-item"><img src="imagenes/zoovenires.jpg" alt="Imagen 7"></div>
                <div class="carousel-item"><img src="imagenes/zoo.jpg" alt="Imagen 8"></div>
                <div class="carousel-item"><img src="imagenes/jardinplantas.jpg" alt="Imagen 9"></div>
            </div>
            <button class="carousel-btn right" onclick="moveSlide(1)">&#10095;</button>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | <a href="iniciosesion.php">Administrador</a> | <a href="perfil_usuario.html">Usuario</a></p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
