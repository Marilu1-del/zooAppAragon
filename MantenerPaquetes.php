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

// Eliminar paquete
if (isset($_GET["eliminar"])) {
    $paqueteID = $_GET["eliminar"];
    $sql = "DELETE FROM Paquetes WHERE PaqueteID=$paqueteID";
    $conn->query($sql);
    header("Location: paquetes.php");
}

// Obtener lista de paquetes
$paquetes = $conn->query("SELECT * FROM Paquetes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Paquetes</title>
    <link rel="stylesheet" href="css/estilos_padmin.css">
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
        

        .footer {
            background: linear-gradient(90deg, #004d40, #00796b);
            color: white;
            padding: 20px;
            font-size: 16px;
            margin-top: 30px;
        }

        .footer {
            background: linear-gradient(90deg, #004d40, #00796b);
            color: white;
            padding: 20px;
            font-size: 16px;
            margin-top: 30px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            flex: 1; /* Hace que el contenido crezca y empuje el footer hacia abajo */
        }
        
        h1 {
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            color: #00796b;
        }

        h3 {
            text-align: center;
            color: #ebfffd;
        }

        .btn {
            background: #00796b;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .btn:hover {
            background: #004d40;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #00796b;
            color: white;
        }

        .actions i {
            cursor: pointer;
            margin: 0 5px;
            font-size: 18px;
        }

        .actions .edit {
            color: #fbc02d;
        }

        .actions .delete {
            color: #d32f2f;
        }

        .actions .view {
            color: #1976d2;
        }

        .actions .add {
            color: #388e3c;
        }

        @media (max-width: 768px) {
            th, td {
                padding: 8px;
            }
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
        <a href="MantenerPersonal.php">Personal</a>
        <a href="MantenerPaquetes.php">Paquetes</a>
        <a href="MantenerZonas.php">Zonas</a>
        <a href="tratamientos.php">Tratamientos</a>
        <a href="#">Animales</a>
        <a href="admin.php">Administrador</a>
        <a href="inicio.php">Cerrar Sesión</a>
    </nav>

    <div class="container">
        <h2>Gestión de Paquetes</h2>
        <button class="btn" onclick="window.location.href='registro.php'">
  <i class="fas fa-user-plus"></i> Agregar Paquete
</button>
        
    <div class="table-container">
        <table>
            <thead>
                <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
                </tr>
            </thead>
        <tbody>
            <?php while ($row = $paquetes->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["PaqueteID"]; ?></td>
                    <td><?php echo $row["Nombre"]; ?></td>
                    <td><?php echo $row["Descripcion"]; ?></td>
                    <td>
                        <a href="registro.php?editar=<?php echo $row["PaqueteID"]; ?>" class="actions"><i class="fas fa-edit edit"></i></a>
                        <a href="?eliminar=<?= $row['PaqueteID'] ?>" onclick="return confirmarEliminacion(event, <?= $row['PaqueteID'] ?>)" class="actions">
    <i class="fas fa-trash delete"></i>
</a>
<a href="registro.php?registro=<?= $row['PaqueteID']; ?>" class="actions">
    <i class="fas fa-user-plus add"></i>
</a>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
            </div>
            </div>
           
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarEliminacion(event, id) {
    event.preventDefault(); // Evita que el enlace navegue inmediatamente

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "deleteP.php?PersonalID=" + id;
        }
    });
}
</script>

    <footer class="footer">
        <p>©CrossGen Coders | ZooAragon App</p>
        <p><i class="fa-solid fa-location-dot"></i> Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, CDMX</p>
        <p><i class="fa-solid fa-phone"></i> Contacto: 5557312412</p>
    </footer>
    
    
</body>
</html>
