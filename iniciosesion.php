<?php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #e0f7fa, #b2dfdb);
            display: flex;
            flex-direction: column;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        nav {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            font-family: 'Poppins', sans-serif;
        }

        nav h1 {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        nav h1 img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: #ffeb3b;
        }

        /* Contenedor principal */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Caja de login */
        .login-container {
            background-color: white;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .login-title {
            color: #00796b;
            margin-bottom: 2rem;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #a1a1aa;
            margin-top: 0.5rem;
        }

        .input-field:focus {
            border-color: #00796b;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 121, 107, 0.5);
        }

        .btn-green {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            margin-top: 1rem;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-green:hover {
            background: linear-gradient(90deg, #00695c, #004339);
        }

        .error-message {
            color: #d32f2f;
            margin-top: 1rem;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 1.5rem;
            text-align: center;
            width: 100%;
        }

        footer a {
            color: #ffeb3b;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <h1>
            <img src="imagenes/evento1.jpg" alt="Zoo Logo">
            Zoológico San Juan de Aragón
        </h1>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="mapaZooAragon.php">Mapa</a></li>
            <li><a href="animales.php">Animales</a></li>
            <li><a href="zonas.php">Zonas</a></li>
            <li><a href="actividades.php">Actividades</a></li>
            <li><a href="precios.php">Precios</a></li>
            <li><a href="nosotros.php">Sobre Nosotros</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <!-- Contenedor principal -->
    <div class="main-container">
        <div class="login-container">
            <h2 class="login-title">Inicio de Sesión</h2>
            <form id="admin-login-form">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text" id="username" name="username" class="input-field" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" class="input-field" required>
                </div>
                <button type="submit" class="btn-green">Iniciar Sesión</button>
            </form>
            <div id="message" class="error-message hidden">Credenciales inválidas. Por favor, inténtelo de nuevo.</div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Zoológico San Juan de Aragón | 
            <a href="iniciosesion.php">Administrador</a> | 
            <a href="perfil_usuario.php">Usuario</a>
        </p>
    </footer>

    <script>
        document.getElementById('admin-login-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username === 'ZooApp' && password === '123456789') {
                alert('Login exitoso!');
                window.location.href = 'admin.php';
            } else {
                document.getElementById('message').classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
