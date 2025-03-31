<?php include('connection.php');

$con = connection();

$PersonalID=$_GET['PersonalID'];

$sql = "SELECT * FROM personal WHERE PersonalID='$PersonalID'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personal</title>
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

        h1 {
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        form {
            max-width: 600px;
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
            margin-top: 20px;
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

        .footer {
            background: linear-gradient(90deg, #004d40, #00796b);
            color: white;
            padding: 20px;
            font-size: 16px;
            margin-top: 30px;
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
        <a href="perfil_admin.html">Administrador</a>
        <a href="inicio.php">Cerrar Sesión</a>
    </nav>

    <h1>Editar Información de Personal</h1>
    <form action="edit.php" method="POST">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="flex: 1; margin-right: 10px;">
                <label for="PersonalID">ID:</label>
                <input type="hidden" name="PersonalID" value="<?= $row['PersonalID'] ?>">
            </div>    
            <div style="flex: 1; margin-right: 10px;">
                <label for="Nombre">Nombre:</label>
                <input type="text" name="Nombre" value="<?= $row['Nombre'] ?>">
            </div>
            <div style="flex: 1; margin-left: 10px;">
    <label for="Rol">Rol:</label>
    <select name="Rol">
        <option value="Veterinario" <?= ($row['Rol'] == 'Veterinario') ? 'selected' : '' ?>>Veterinario</option>
        <option value="Cuidador" <?= ($row['Rol'] == 'Cuidador') ? 'selected' : '' ?>>Cuidador</option>
        <option value="Intendente" <?= ($row['Rol'] == 'Intendente') ? 'selected' : '' ?>>Intendente</option>
        <option value="Vendedor" <?= ($row['Rol'] == 'Vendedor') ? 'selected' : '' ?>>Vendedor</option>
    </select>
</div>

            
        </div>

        <div style="display: flex; justify-content: space-between;">
            <div style="flex: 1; margin-right: 10px;">
                <label for="Email">Email:</label>
                <input type="text" name="Email" value="<?= $row['Email'] ?>">
            </div>
            <div style="flex: 1; margin-left: 10px;">
                <label for="Telefono">Teléfono:</label>
                <input type="text" name="Telefono" value="<?= $row['Telefono'] ?>">
            </div>
        </div>

        <input type="submit" value="Actualizar Información">
        <a href="MantenerPersonal.php"><input type="button" value="Cancelar" class="boton-cancelar" style="margin-top: 20px; width: 100%; background:rgb(165, 20, 20);; color: white;"></a>
    </form>

    <footer class="footer">
        <p>©CrossGen Coders | ZooAragon App</p>
        <p><i class="fa-solid fa-location-dot"></i> Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, CDMX</p>
        <p><i class="fa-solid fa-phone"></i> Contacto: 5557312412</p>
    </footer>
</body>
</html>
