<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "Zoologico";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Eliminar zona
if (isset($_GET["eliminar"])) {
    $zonaID = $_GET["eliminar"];
    $sql = "DELETE FROM Zonas WHERE ZonaID=$zonaID";
    $conn->query($sql);
    header("Location: zonas.php");
    exit;
}

// Obtener lista de zonas
$zonas = $conn->query("SELECT * FROM Zonas");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Zonas | ZooAragon</title>
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

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            flex: 1;
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
            text-align: center;
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

    <div class="container">
        <h2>Gestión Zonas</h2>
        <button class="btn" onclick="window.location.href='registroZonas.php'">
            <i class="fas fa-user-plus"></i> Agregar Zona
        </button>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $zonas->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row["ZonaID"]; ?></td>
                            <td><?php echo $row["Nombre"]; ?></td>
                            <td><?php echo $row["Descripcion"]; ?></td>
                            <td><?php echo $row["Disponibilidad"] == 'S' ? 'Disponible' : 'No Disponible'; ?></td>
                            <td class="actions">
                                <a href="registroZonas.php?editar=<?php echo $row["ZonaID"]; ?>"><i class="fas fa-edit edit"></i></a>
                                <a href="?eliminar=<?php echo $row['ZonaID']; ?>" onclick="confirmarEliminacion(event, <?php echo $row['ZonaID']; ?>)">
                                    <i class="fas fa-trash delete"></i>
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
        event.preventDefault(); // Evita la navegación inmediata
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d32f2f",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirige a la URL de eliminación usando el parámetro "eliminar"
                window.location.href = "?eliminar=" + id;
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
<?php
$conn->close();
?>
