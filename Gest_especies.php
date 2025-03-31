<?php
// conexion.php
$host = "localhost";
$user = "root";
$pass = "";
$db = "zoologico";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Eliminar animal
if (isset($_GET["eliminar"])) {
    $animalID = intval($_GET["eliminar"]);
    
    // Recuperamos la ruta de la imagen
    $stmt = $conn->prepare("SELECT imagen FROM animales WHERE animalid = ?");
    $stmt->bind_param("i", $animalID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $imagen = $row['imagen'];
        if ($imagen && file_exists("uploads/" . $imagen)) {
            unlink("uploads/" . $imagen); // Elimina el archivo físico
        }
    }

    $stmt->close();

    // Borrar usando prepared statements
    $stmt = $conn->prepare("DELETE FROM animales WHERE animalid = ?");
    $stmt->bind_param("i", $animalID);
    if ($stmt->execute()) {
        header("Location: Gest_especies.php");
        exit;
    } else {
        echo "Error al eliminar el animal: " . $conn->error;
    }
    $stmt->close();
}

// Obtener lista de animales
$animales = $conn->query("SELECT * FROM animales");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Especies | ZooAragon</title>
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

        img {
            max-width: 80px;
            height: auto;
            border-radius: 4px;
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
            <h3>Gestión de Especies</h3>
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
        <a href="perfil_admin.html">Administrador</a>
        <a href="inicio.php">Cerrar Sesión</a>
    </nav>  
    <div class="container">
        <h2>Gestión de Especies</h2>
        <button class="btn" onclick="window.location.href='Especies_reg.php'">
            <i class="fas fa-plus"></i> Registrar Nueva Especie
        </button>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Especie</th>
                        <th>Clase</th>
                        <th>Orden</th>
                        <th>Familia</th>
                        <th>Descripción</th>
                        <th>Alimentación</th>
                        <th>Distribución</th>
                        <th>Peso (kg)</th>
                        <th>Talla (cm)</th>
                        <th>Gestación (días)</th>
                        <th>Crías</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
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
                    <tr>
                        <td><?= $nombre ?></td>
                        <td><?= $especie ?></td>
                        <td><?= $clase ?></td>
                        <td><?= $orden ?></td>
                        <td><?= $familia ?></td>
                        <td><?= $descripcion ?></td>
                        <td><?= $alimentacion ?></td>
                        <td><?= $distribucion ?></td>
                        <td><?= $peso ?> kg</td>
                        <td><?= $talla ?> cm</td>
                        <td><?= $gestacion ?> días</td>
                        <td><?= $crias ?></td>
                        <td>
                            <?php if (!empty($imagen)) { ?>
                                <img src="uploads/<?= $imagen ?>" alt="Imagen de <?= $nombre ?>">
                            <?php } else { ?>
                                No disponible
                            <?php } ?>
                        </td>
                        <td class="actions">
                            <a href="edit_especie.php?id=<?= $animalID ?>"><i class="fas fa-edit edit"></i></a>
                            <a href="?eliminar=<?= $animalID ?>" onclick="return confirmarEliminacion(event, <?= $animalID ?>)">
                                <i class="fas fa-trash delete"></i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='14'>No hay especies registradas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <p>©CrossGen Coders | ZooAragon App</p>
        <p><i class="fa-solid fa-location-dot"></i> Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, CDMX</p>
        <p><i class="fa-solid fa-phone"></i> Contacto: 5557312412</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmarEliminacion(event, id) {
        event.preventDefault();
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
                window.location.href = "?eliminar=" + id;
            }
        });
    }
    </script>
</body>
</html>

<?php
$conn->close();
?>