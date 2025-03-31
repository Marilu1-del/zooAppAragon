<?php include('connection.php');

$con = connection();

$sql = "SELECT * FROM usuarios";
$query = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios | ZooAragon</title>
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

        .perfil {
            background: white;
            padding: 30px;
            margin: 40px auto;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
            border-radius: 15px;
        }

        .perfil img {
            width: 130px;
            border-radius: 50%;
            margin-bottom: 15px;
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
            <h3>Lista de Usuarios</h3>
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
        <h2>Gestión de Usuarios</h2>
        <button class="btn" onclick="window.location.href='form_usuario.php'">
            <i class="fas fa-user-plus"></i> Agregar Usuario
        </button>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?> 
                    <tr>
                        <td> <?= $row['nombre'] ?> </td>
                        <td> <?= $row['ap_paterno'] ?> </td>
                        <td> <?= $row['ap_materno'] ?> </td>
                        <td> <?= $row['telefono'] ?> </td>
                        <td> <?= $row['correo_elect'] ?> </td>
                        <td class="actions">
                            <a href="update.php?id=<?= $row['id'] ?>"><i class="fas fa-edit edit"></i></a>
                            <a href="deleteU.php" onclick="confirmarEliminacion(event, <?= $row['id'] ?>)">
                                <i class="fas fa-trash delete"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($query) == 0): ?>
                    <tr><td colspan="6">No se encontraron registros.</td></tr>
                <?php endif; ?>
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
                window.location.href = "deleteU.php?id=" + id;
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