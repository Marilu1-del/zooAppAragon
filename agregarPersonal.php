<?php include('connection.php');

$con = connection();

$sql = "SELECT * FROM personal";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personal | ZooAragon</title>
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
            max-width: 400px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9); /* Fondo semi-transparente */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #00796b;
            outline: none;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            border-radius: 10px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            input[type="text"], input[type="password"], input[type="submit"] {
                padding: 8px;
            }
        }

.boton-cancelar {
  margin-top: 20px;
  width: 100%;
  background: rgb(165, 20, 20);
  transition: background-color 0.3s;
  color: white;
  border-radius: 10px; /* Opcional: Quita el borde del botón */
  padding: 10px; /* Opcional: Añade padding al botón */
  cursor: pointer; /* Opcional: Cambia el cursor al pasar por encima */
}

        .footer {
            background: linear-gradient(90deg, #004d40, #00796b);
            color: white;
            padding: 20px;
            font-size: 16px;
            margin-top: 30px;
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

    <h1>Registro de Nuevo Personal</h1>
    <form action="insert.php" method="POST" style="max-width: 600px; margin: auto;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <div style="flex: 1; margin-right: 10px;">
            <label for="Nombre">Nombre:</label>
            <input type="text" name="Nombre" required style="width: 100%;">
        </div>
        <div style="flex: 1; margin-left: 10px;">
            <label for="Rol">Rol:</label>
            <select name="Rol" required style="width: 100%;">
                <option value="">Seleccione un rol</option>
                <option value="Veterinario">Veterinario</option>
                <option value="Cuidador">Cuidador</option>
                <option value="Intendente">Intendente</option>
                <option value="Vendedor">Vendedor</option>
            </select>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between;">
        <div style="flex: 1; margin-right: 10px;">
            <label for="Email">Email:</label>
            <input type="text" name="Email" required style="width: 100%;">
        </div>
        <div style="flex: 1; margin-left: 10px;">
            <label for="Telefono">Teléfono:</label>
            <input type="text" name="Telefono" required style="width: 100%;">
        </div>
    </div>

    <input type="submit" value="Agregar" style="margin-top: 20px; width: 100%;"> 
    <a href="MantenerPersonal.php"><input type="button" value="Cancelar" class="boton-cancelar" style="margin-top: 20px; width: 100%; background:rgb(165, 20, 20);; color: white;"></a>
</form>


    
    <footer class="footer">
        <p>©CrossGen Coders | ZooAragon App</p>
        <p><i class="fa-solid fa-location-dot"></i> Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, CDMX</p>
        <p><i class="fa-solid fa-phone"></i> Contacto: 5557312412</p>
    </footer>
</body>
</html>
