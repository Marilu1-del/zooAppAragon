<?php
session_start(); // Inicia la sesión
require 'conexion.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['fecha']) || empty($_POST['tipoTratamiento']) || empty($_POST['medicamentos'])) {
        echo "<script>alert('Todos los campos son obligatorios.');</script>";
    } else {
        if (!isset($_SESSION['veterinario'])) {
            die("Error: No se ha iniciado sesión como veterinario.");
        }
        $veterinario = $_SESSION['veterinario']; // Obtener el veterinario de la sesión

        $fecha = $_POST['fecha'];
        $tipoTratamiento = $_POST['tipoTratamiento'];
        $medicamentos = $_POST['medicamentos'];
        $seguimiento = $_POST['seguimiento'] ?? '';

        $sql = "INSERT INTO tratamientos (fecha, tipoTratamiento, medicamentos, VeterinarioResponsable, seguimiento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssss", $fecha, $tipoTratamiento, $medicamentos, $veterinario, $seguimiento);

        if ($stmt->execute()) {
            echo "<script>alert('Tratamiento registrado correctamente');</script>";
        } else {
            echo "<script>alert('Error al registrar el tratamiento');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Tratamientos</title>
    <script src="https://kit.fontawesome.com/ca7c7e6854.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function toggleMenu() {
            document.getElementById("nav-menu").classList.toggle("active");
        }
    </script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f2f1;
            text-align: center;
        }

        .Encabezado {
            background: linear-gradient(90deg, #004d40, #00796b);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .Encabezado img {
            width: 80px;
            border-radius: 50%;
        }

        .menu-icon {
            display: block;
            font-size: 28px;
            cursor: pointer;
            margin-right: 20px;
        }

        nav {
            display: none;
            flex-direction: column;
            background: #00796b;
            position: absolute;
            top: 70px;
            right: 0;
            width: 200px;
            box-shadow: -2px 2px 10px rgba(0,0,0,0.2);
            border-radius: 0 0 10px 10px;
        }

        nav.active {
            display: flex;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 15px;
            font-size: 18px;
            transition: background 0.3s ease-in-out;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e0f7fa;
            color: #374151;
            margin: 0;
            padding: 0;
        }
        .background-section {
            margin: 0;
            padding: 0;
            background: url('imagenes/intro.jpeg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            font-family: Arial, sans-serif;
        }
        .background-section .container {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .background-section h1 { font-size: 3em; }
        .background-section p { font-size: 1.5em; }
        .background-section .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .background-section .btn:hover { background: #367c39; }
        .form-container {
            background: white;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 800px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #374151;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-group button {
            background-color: #00796b;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group button:hover { background-color: #004d40; }
        footer {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
        }
        footer a { color: #ffeb3b; text-decoration: none; }
    </style>
</head>
<body>
<header class="Encabezado">
        <img src="imagenes/logobien.jpg" alt="ZooAragon">
        <div>
            <h1>ZooAragon App</h1>
            <h3>Perfil Administrador</h3>
        </div>
        <div class="menu-icon" onclick="toggleMenu()">
            <i class="fa-solid fa-bars"></i>
        </div>
    </header>

    <nav id="nav-menu">
        <a href="admin.php">Inicio</a>
        <a href="lista_usuarios.php">Usuarios</a>
        <a href="MantenerPersonal.php">Personal</a>
        <a href="MantenerPaquetes.php">Paquetes</a>
        <a href="MantenerZonas.php">Zonas</a>
        <a href="tratamientos.php">Tratamientos</a>
        <a href="Gest_especies.php">Animales</a>
        <a href="actualizar_coordenadas.php">Mapa</a>
        <a href="admin.php">Administrador</a>
        <a href="inicio.php">Cerrar Sesión</a>
    </nav>  


    <div id="form-section" class="form-container">
        <h2>Registrar Tratamiento</h2>
        <form method="POST">
            <div class="form-group">
                <label for="fecha">Fecha del Tratamiento:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="tipoTratamiento">Tipo de Tratamiento:</label>
                <select id="tipoTratamiento" name="tipoTratamiento" required>
                    <option value="">Seleccione un tratamiento</option>
                    <option value="Vacunación">Vacunación</option>
                    <option value="Desparasitación">Desparasitación</option>
                    <option value="Cirugía">Cirugía</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="medicamentos">Medicamentos:</label>
                <textarea id="medicamentos" name="medicamentos" required></textarea>
            </div>
            <div class="form-group">
                <label for="seguimiento">Seguimiento:</label>
                <textarea id="seguimiento" name="seguimiento"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="registrar">Registrar Tratamiento</button>
            </div>
        </form>
    </div>
    <footer>
        <p>©CrossGen Coders <br> ZooAragon App</p>
        <p>Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, Gustavo A. Madero, 07920 Ciudad de México, CDMX</p>
        <p>Contacto 5557312412</p>
    </footer>
</body>
</html>
