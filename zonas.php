<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "zoologico";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener las zonas registradas
$zonas = $conn->query("SELECT * FROM Zonas");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooApp - Navbar & Footer</title>
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

        .grid-animales {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
            text-align: center;
        }

        .animal {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background: white;
        }

        .animal img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 1rem;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .info-box {
            padding: 1rem;
            font-size: 1rem;
            color: #555;
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
        <h2>Zonas del Zoológico</h2>
        <p>Explora nuestras diferentes áreas temáticas.</p>
        <div class="grid-animales">
            <?php
            if ($zonas && $zonas->num_rows > 0) {
                while ($row = $zonas->fetch_assoc()) {
                    // Variables de la zona
                    $nombre = $row["Nombre"];
                    $descripcion = $row["Descripcion"];
                    // Si se tiene imagen en la BD, se muestra desde "uploads/", de lo contrario se muestra una imagen por defecto.
                    $imagen = !empty($row["Imagen"]) ? "uploads/" . $row["Imagen"] : "imagenes/zonas_default.jpg";
                    
                    echo "<div class='animal'>";
                    echo "<img src='$imagen' alt='$nombre'>";
                    echo "<div class='overlay'>$nombre</div>";
                    echo "<div class='info-box'>$descripcion</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay zonas registradas.</p>";
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
