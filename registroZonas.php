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

// Inicializar variables
$nombre = "";
$descripcion = "";
$disponibilidad = "S";
$zonaID = 0;
$imagenActual = "";
$editando = false;

// Editar zona
if (isset($_GET["editar"])) {
    $zonaID = $_GET["editar"];
    $result = $conn->query("SELECT * FROM Zonas WHERE ZonaID=$zonaID");
    if ($row = $result->fetch_assoc()) {
        $nombre = $row["Nombre"];
        $descripcion = $row["Descripcion"];
        $disponibilidad = $row["Disponibilidad"];
        $imagenActual = $row["Imagen"];
        $editando = true;
    }
}

// Guardar zona
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $disponibilidad = $_POST["disponibilidad"];

    // Procesar imagen si se sube
    $imagenNueva = "";
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagenFile = $_FILES['imagen'];
        $nombre_imagen = uniqid() . '_' . basename($imagenFile['name']);
        $destino = 'uploads/' . $nombre_imagen;
        if(move_uploaded_file($imagenFile['tmp_name'], $destino)){
            $imagenNueva = $nombre_imagen;
        }
    }

    if ($editando) {
        // Si se subió una nueva imagen, actualizar el campo; si no, conservar la actual
        if ($imagenNueva != "") {
            $sql = "UPDATE Zonas SET Nombre='$nombre', Descripcion='$descripcion', Disponibilidad='$disponibilidad', Imagen='$imagenNueva' WHERE ZonaID=$zonaID";
        } else {
            $sql = "UPDATE Zonas SET Nombre='$nombre', Descripcion='$descripcion', Disponibilidad='$disponibilidad' WHERE ZonaID=$zonaID";
        }
    } else {
        $sql = "INSERT INTO Zonas (Nombre, Descripcion, Disponibilidad, Imagen) VALUES ('$nombre', '$descripcion', '$disponibilidad', '$imagenNueva')";
    }
    $conn->query($sql);
    header("Location: zonas.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar/Editar Zona</title>
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
            background: url('https://c.wallhere.com/photos/25/91/zoo_nikon_felinos_felines_lioness_bigcats_leona_nikond3200-955743.jpg!d') no-repeat center center fixed;
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
        /* Contenedor principal */
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: #374151;
        }
        /* Título */
        h4 {
            text-align: center;
            font-size: 24px;
            color: #00796b;
        }
        /* Etiquetas de los campos */
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #555;
        }
        /* Campos de entrada */
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }
        /* Estilos para textarea */
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        /* Botón */
        button {
            display: block;
            width: 100%;
            background: #00796b;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #004d40;
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
        <a href="Gest_especies.php ">Animales</a>
        <a href="MantenerPersonal.php">Personal</a>
        <a href="admin.php">Administrador</a>
        <a href="inicio.php">Cerrar Sesión</a>
    </nav>
    <h4><?php echo $editando ? "Editar Zona" : "Registrar Zona"; ?></h4>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
            
            <label>Descripción:</label>
            <textarea name="descripcion" required><?php echo $descripcion; ?></textarea>
            
            <label>Disponibilidad:</label>
            <select name="disponibilidad">
                <option value="S" <?php echo $disponibilidad == 'S' ? 'selected' : ''; ?>>Disponible</option>
                <option value="N" <?php echo $disponibilidad == 'N' ? 'selected' : ''; ?>>No Disponible</option>
            </select>

            <label>Imagen:</label>
            <input type="file" name="imagen" accept="image/*">
            
            <button type="submit">Guardar</button>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>
