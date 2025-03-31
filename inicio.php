<?php
// Conexión a la base de datos para obtener las zonas
$servername = "localhost";
$username = "root";
$password = "";
$database = "Zoologico";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$zonas = $conn->query("SELECT * FROM Zonas");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooApp</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e0f7fa;
            color: #374151;
            margin: 0;
            padding: 0;
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
        /* Hero Section */
        header {
            height: 90vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            color: white;
            background: url('imagenes/intro.jpeg') no-repeat center center/cover;
        }
        header .content {
            background: rgba(0, 0, 0, 0.6);
            padding: 2rem;
            border-radius: 10px;
        }
        header h2 {
            font-size: 2.5rem;
        }
        header a {
            background-color: #ffeb3b;
            color: #374151;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        header a:hover {
            background-color: #fbc02d;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        h3 {
            font-size: 1.5rem;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }
        /* Cards Section (estáticas) */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
            text-align: center;
        }
        .card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card h4 {
            font-size: 1.2rem;
            color: #00796b;
            margin: 1rem 0;
        }
        .card p {
            color: #555;
            padding: 0 1rem 1rem;
        }
        /* New Zones Section from Database */
        #zonas-db {
            background-color: #f1f5f9;
            padding: 2rem;
        }
        #zonas-db .cards {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

    <header>
        <div class="content">
            <h2>Bienvenidos al Zoológico San Juan de Aragón</h2>
            <p>"Descubre la magia de la vida salvaje, donde la naturaleza cobra vida."</p>
            <a href="#about">Ver más</a>
        </div>
    </header>

    <section id="about">
        <div class="container">
            <h3><br>Conoce nuestro Zoológico <br> <p>Dentro de nuestras instalaciones contamos con:</p></h3>
        </div>
    </section>

    <!-- Sección estática de Cards (Opcional) -->
    <section class="cards">
        <?php 
        $sections = [
            ["zoo.jpg", "Zoológico", "Oportunidad para conocer a tus animales favoritos."],
            ["aviario.jpg", "Aviario", "Una representación cultural donde las aves son los protagonistas."],
            ["tren.jpg", "Recorrido en Tren", "Comodidad y emoción al mismo tiempo."],
            ["demostracionaves.jpg", "Demostraciones y pláticas de aves", "Un espacio dedicado al conocimiento de las aves."],
            ["herpetario.jpg", "Herpetario", "Una exhibición educativa sobre serpientes y reptiles."],
            ["jardinplantas.jpg", "Jardín de plantas", "Un hermoso espacio lleno de olores."],
            ["areaeducativa.jpg", "Área Educativa", "Sección para aprender divirtiéndote."],
            ["zoovenires.jpg", "Zouvenirs", "Para llevarte un recuerdo de tu visita."],
            ["areadejuegos.jpg", "Área de juegos infantiles", "Espacio de distracción para más pequeños."],
            ["relajacion.jpg", "Áreas de relajación", "Lugar de descanso y paz en contacto con la naturaleza."]
        ];
        
        foreach ($sections as $section) {
            echo "<div class='card'>
                    <img src='imagenes/{$section[0]}' alt='{$section[1]}' loading='lazy'>
                    <h4>{$section[1]}</h4>
                    <p>{$section[2]}</p>
                  </div>";
        }
        ?>
    </section>

    <!-- Nueva Sección: Zonas del Zoológico (desde la base de datos) -->
  <!-- Nueva Sección: Zonas del Zoológico (desde la base de datos) -->
<section id="zonas-db">
    <div class="container">
        <h3>Zonas del Zoológico</h3>
        <div class="cards">
            <?php 
            if($zonas && $zonas->num_rows > 0){
                while($row = $zonas->fetch_assoc()){
                    $zonaID = $row["ZonaID"];
                    $nombre = $row["Nombre"];
                    $descripcion = $row["Descripcion"];
                    $disponibilidad = $row["Disponibilidad"];
                    // Verificamos si se ha guardado una imagen; si es así, la mostramos desde "uploads", sino se usa una imagen por defecto
                    $imagen = !empty($row["Imagen"]) ? "uploads/" . $row["Imagen"] : "imagenes/zonas_default.jpg";
                    echo "<div class='card'>";
                    echo "<img src='$imagen' alt='$nombre'>";
                    echo "<h4>$nombre</h4>";
                    echo "<p>$descripcion</p>";
                    echo "<p><strong>Disponibilidad:</strong> " . ($disponibilidad == 'S' ? 'Disponible' : 'No Disponible') . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay zonas registradas.</p>";
            }
            ?>
        </div>
    </div>
</section>


    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | 
            <a href="iniciosesion.php">Iniciar Sesión</a> | 
            <a href="perfil_usuario.php">Usuario</a>
        </p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
