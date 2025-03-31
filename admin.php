<?php 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Administrador | ZooAragon</title>
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
        h1 {
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
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
    </style>
</head>
<body>
    <header class="Encabezado">
        <img src="imagenes/logobien.jpg" alt="ZooAragon">
        <div>
            <h1>ZooAragon App</h1>
            <h2>Perfil Administrador</h2>
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

    <div class="perfil">
        <h1>Perfil Administrador</h1>
        <img src="imagenes/admin.png" alt="perfil imagen">
        <p><strong>Nombre:</strong> Gustavo Montero</p>
        <p><strong>Puesto:</strong> Administrador Zoológico</p>
        <p><strong>Email:</strong> Gustavo_montero25@gmail.com</p>
        <p><strong>Teléfono:</strong> (123) 456-7890</p>
    </div>

    <footer class="footer">
        <p>©CrossGen Coders | ZooAragon App</p>
        <p><i class="fa-solid fa-location-dot"></i> Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, CDMX</p>
        <p><i class="fa-solid fa-phone"></i> Contacto: 5557312412</p>
    </footer>
</body>
</html>
