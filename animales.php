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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooApp - Navbar & Footer</title>
    <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <style>
        /* General Styles */
        html, body {
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
        /* Grid de tarjetas de animales */
        .grid-animales {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
            justify-items: center;
        }
        /* Estilos para la tarjeta con efecto flip */
        .animal-card {
            perspective: 1000px;
            width: 300px;
            height: 350px;
            margin: 1rem;
        }
        .animal-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }
        .animal-card:hover .animal-inner {
            transform: rotateY(180deg);
        }
        .animal-front, .animal-back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            backface-visibility: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .animal-front {
            background-color: #fff;
            overflow: hidden;
        }
        .animal-front img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .overlay {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem;
            font-size: 1.2rem;
            font-weight: bold;
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        .animal-back {
            background-color: #f8f8f8;
            color: #333;
            transform: rotateY(180deg);
            padding: 1rem;
            box-sizing: border-box;
            overflow-y: auto;
        }
        .animal-back h4 {
            margin-top: 0;
        }
        .animal-back ul {
            list-style: none;
            padding: 0;
            text-align: left;
            font-size: 0.9rem;
        }
        .animal-back ul li {
            margin: 0.5rem 0;
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

    <!-- Main Content -->
    <div class="content">
        <h2>Nuestros Animales</h2>
        <p>Descubre una gran variedad de especies</p>
        <div class="grid-animales">
            <?php 
            if ($animales && $animales->num_rows > 0) {
                while ($row = $animales->fetch_assoc()) {
                    // Variables de la base de datos
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
            <div class="animal-card">
                <div class="animal-inner">
                    <!-- Parte frontal de la tarjeta -->
                    <div class="animal-front">
                        <?php if (!empty($imagen)) { ?>
                            <img src="uploads/<?= $imagen ?>" alt="Imagen de <?= $nombre ?>">
                        <?php } else { ?>
                            <img src="imagenes/default.jpg" alt="Imagen por defecto">
                        <?php } ?>
                        <div class="overlay">
                            <h3><?= $nombre ?></h3>
                            <p><?= $especie ?></p>
                        </div>
                    </div>
                    <!-- Parte trasera de la tarjeta -->
                    <div class="animal-back">
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
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | <a href="iniciosesion.php">Administrador</a> | <a href="perfil_usuario.html">Usuario</a></p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
