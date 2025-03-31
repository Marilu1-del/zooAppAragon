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

// CRUD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    
    if (!empty($_POST["PaqueteID"])) {
        // Actualizar paquete existente
        $paqueteID = $_POST["PaqueteID"];
        $sql = "UPDATE paquetes SET Nombre='$nombre', Descripcion='$descripcion' WHERE PaqueteID=$paqueteID";
    } else {
        // Insertar nuevo paquete
        $sql = "INSERT INTO paquetes (Nombre, Descripcion) VALUES ('$nombre', '$descripcion')";
    }
    $conn->query($sql);
    header("Location: MantenerPaquetes.php");
}

$nombre = "";
$descripcion = "";
$paqueteID = "";

if (isset($_GET["editar"])) {
    $paqueteID = $_GET["editar"];
    $resultado = $conn->query("SELECT * FROM paquetes WHERE PaqueteID=$paqueteID");
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $nombre = $fila["Nombre"];  
        $descripcion = $fila["Descripcion"];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar/Editar Paquete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ca7c7e6854.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function toggleMenu() {
            document.getElementById("nav-menu").classList.toggle("active");
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://eltiempolatino.com/wp-content/uploads/2023/03/elefanta-Ely.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
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
        <a href="lista_usuarios.html">Usuarios</a>
        <a href="#">Animales</a>
        <a href="MantenerPersonal.php">Personal</a>
        <a href="admin.php">Administrador</a>
        <a href="inicio.php">Cerrar Sesión</a>
    </nav>

    <div class="container mt-4">
    <h2 class="text-center mb-4"><?php echo isset($_GET["editar"]) ? "Editar Paquete" : "Agregar Paquete"; ?></h2>

    <form method="POST" class="w-50 mx-auto border p-4 rounded shadow">
        <input type="hidden" name="PaqueteID" value="<?php echo $paqueteID; ?>">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required value="<?php echo $nombre; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required value="<?php echo $descripcion; ?>">
        </div>
        <button type="submit" class="btn btn-success w-100">Guardar</button>
    </form>
    </div>

</body>
</html>
