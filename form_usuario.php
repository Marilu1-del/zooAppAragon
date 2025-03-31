<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "zoologico";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["nom_cliente"] ?? null;
    $correo = $_POST["correo_elect"] ?? null;
    $ap_paterno = $_POST["ap_pcli"] ?? null;
    $ap_materno = $_POST["ap_mcli"] ?? null;
    $telefono = $_POST["telefono"] ?? null;

    // Validar que todos los campos estén presentes
    if ($nombre && $correo && $ap_paterno && $ap_materno && $telefono) {
        // Validar el correo electrónico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo "<script>
                alert('El correo electrónico no es válido.');
            </script>";
        } 
        // Validar que el teléfono solo contenga números
        elseif (!preg_match("/^[0-9]{10}$/", $telefono)) {
            echo "<script>
                alert('El teléfono debe contener solo números y tener 10 dígitos.');
            </script>";
        } 
        // Si todo está correcto, insertar en la base de datos
        else {
            // Preparar la consulta SQL
            $stmt = $conn->prepare("
                INSERT INTO usuarios (nombre, correo_elect, ap_paterno, ap_materno, telefono)
                VALUES (?, ?, ?, ?, ?)
            ");

            // Vincular los parámetros
            $stmt->bind_param("sssss", $nombre, $correo, $ap_paterno, $ap_materno, $telefono);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<script>
                    alert('Usuario registrado correctamente.');
                    window.location.href = 'lista_usuarios.php';
                </script>";
            } else {
                echo "<script>
                    alert('Error al registrar usuario: " . $stmt->error . "');
                </script>";
            }

            // Cerrar la declaración
            $stmt->close();
        }
    } else {
        echo "<script>
            alert('Todos los campos son obligatorios.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario | ZooAragon</title>
    <link rel="stylesheet" href="css/estilos_padmin.css">
    <script src="https://kit.fontawesome.com/ca7c7e6854.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function toggleMenu() {
            document.getElementById("nav-menu").classList.toggle("active");
        }

        // Validar el formulario antes de enviarlo
        function validarFormulario() {
            const nombre = document.querySelector('input[name="nom_cliente"]').value;
            const correo = document.querySelector('input[name="correo_elect"]').value;
            const apPaterno = document.querySelector('input[name="ap_pcli"]').value;
            const apMaterno = document.querySelector('input[name="ap_mcli"]').value;
            const telefono = document.querySelector('input[name="telefono"]').value;

            // Validar que todos los campos estén completos
            if (!nombre || !correo || !apPaterno || !apMaterno || !telefono) {
                alert('Todos los campos son obligatorios.');
                return false;
            }

            // Validar el correo electrónico
            if (!correo.includes('@') || !correo.includes('.')) {
                alert('El correo electrónico no es válido.');
                return false;
            }

            // Validar que el teléfono solo contenga números y tenga 10 dígitos
            if (!/^[0-9]{10}$/.test(telefono)) {
                alert('El teléfono debe contener solo números y tener 10 dígitos.');
                return false;
            }

            return true;
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://mexicocity.cdmx.gob.mx/wp-content/uploads/2020/11/aragon-zoo.jpg') no-repeat center center fixed;
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

        h1 {
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="tel"]:focus {
            border-color: #00796b;
            outline: none;
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

        .footer {
            background: linear-gradient(90deg, #004d40, #00796b);
            color: white;
            padding: 20px;
            font-size: 16px;
            margin-top: 30px;
            text-align: center;
        }

        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            input[type="text"], input[type="email"], input[type="tel"], button {
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
            <h3>Registro de Usuario</h3>
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
        <a href="#">Animales</a>
        <a href="perfil_admin.html">Administrador</a>
        <a href="inicio.php">Cerrar Sesión</a>
    </nav>

    <h1>Registro de Nuevo Usuario</h1>
    <form action="" method="POST" onsubmit="return validarFormulario()">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="flex: 1; margin-right: 10px;">
                <label for="nom_cliente">Nombre</label>
                <input type="text" name="nom_cliente" required>
            </div>
            <div style="flex: 1; margin-left: 10px;">
                <label for="correo_elect">Correo Electrónico</label>
                <input type="email" name="correo_elect" required>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="flex: 1; margin-right: 10px;">
                <label for="ap_pcli">Apellido Paterno</label>
                <input type="text" name="ap_pcli" required>
            </div>
            <div style="flex: 1; margin-left: 10px;">
                <label for="ap_mcli">Apellido Materno</label>
                <input type="text" name="ap_mcli" required>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="flex: 1; margin-right: 10px;">
                <label for="telefono">Teléfono</label>
                <input type="tel" name="telefono" pattern="[0-9]{10}" title="El teléfono debe contener solo números y tener 10 dígitos." required>
            </div>
        </div>

        <button type="submit">Registrar</button>
    </form>

    <footer class="footer">
        <p>©CrossGen Coders | ZooAragon App</p>
        <p><i class="fa-solid fa-location-dot"></i> Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, CDMX</p>
        <p><i class="fa-solid fa-phone"></i> Contacto: 5557312412</p>
    </footer>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>