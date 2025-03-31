<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "zoologico";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar las opciones para los campos de selección
$sqlEspecies = "SELECT DISTINCT especie FROM animales";
$resultEspecies = $conn->query($sqlEspecies);

$sqlClases = "SELECT DISTINCT clase FROM animales";
$resultClases = $conn->query($sqlClases);

$sqlOrdenes = "SELECT DISTINCT orden FROM animales";
$resultOrdenes = $conn->query($sqlOrdenes);

$sqlFamilias = "SELECT DISTINCT familia FROM animales";
$resultFamilias = $conn->query($sqlFamilias);

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Usamos ?? null para evitar "Undefined array key"
    $nombre        = $_POST["nombre"]        ?? null;
    $especie       = $_POST["especie"]       ?? null;
    $clase         = $_POST["clase"]         ?? null;
    $orden         = $_POST["orden"]         ?? null;
    $familia       = $_POST["familia"]       ?? null;
    $descripcion   = $_POST["descripcion"]   ?? null;
    $alimentacion  = $_POST["alimentacion"]  ?? null;
    $distribucion  = $_POST["distribucion"]  ?? null;
    $peso          = $_POST["peso"]          ?? null;
    $talla         = $_POST["talla"]         ?? null;
    $gestacion     = $_POST["gestacion"]     ?? null;
    $crias         = $_POST["crias"]         ?? null;
    
    $imagen = $_FILES['imagen']['name'] ?? null;
    $ruta   = "uploads/" . basename($imagen);

    // Subimos el archivo a la carpeta "uploads/"
    if ($imagen && move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        // Usamos nombres de columnas en minúsculas
        $stmt = $conn->prepare("
            INSERT INTO animales 
            (nombre, especie, clase, orden, familia, descripcion, alimentacion, distribucion, peso, talla, gestacion, crias, imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        // Ajustar tipos según corresponda: s = string, i = integer
        $stmt->bind_param("ssssssssiiiss",
            $nombre,
            $especie,
            $clase,
            $orden,
            $familia,
            $descripcion,
            $alimentacion,
            $distribucion,
            $peso,
            $talla,
            $gestacion,
            $crias,
            $imagen
        );

        if ($stmt->execute()) {
            echo "<script>
                alert('Especie registrada correctamente.');
                window.location.href = 'Gest_especies.php';
            </script>";
        } else {
            echo "<script>
                alert('Error al registrar especie: " . $stmt->error . "');
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Error al subir la imagen.');
        </script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nueva Especie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ca7c7e6854.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 700px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #00796b;
            margin-bottom: 20px;
        }

        .btn-success {
            background-color: #00796b;
            border: none;
            padding: 12px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
            border-radius: 5px;
            width: 100%;
        }

        .btn-success:hover {
            background-color: #004d40;
        }

        label {
            font-weight: bold;
            margin-bottom: 6px;
            color: #333;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #00796b;
            outline: none;
        }

        .form-control::placeholder {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrar Nueva Especie</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ejemplo: León" required>
        </div>

        <div class="mb-3">
            <label>Especie</label>
            <select name="especie" class="form-control" required>
                <option value="">Selecciona una especie</option>
                <?php
                if ($resultEspecies->num_rows > 0) {
                    while ($row = $resultEspecies->fetch_assoc()) {
                        echo "<option value='" . $row['especie'] . "'>" . $row['especie'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Clase</label>
            <select name="clase" class="form-control" required>
                <option value="">Selecciona una clase</option>
                <?php
                if ($resultClases->num_rows > 0) {
                    while ($row = $resultClases->fetch_assoc()) {
                        echo "<option value='" . $row['clase'] . "'>" . $row['clase'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Orden</label>
            <select name="orden" class="form-control" required>
                <option value="">Selecciona un orden</option>
                <?php
                if ($resultOrdenes->num_rows > 0) {
                    while ($row = $resultOrdenes->fetch_assoc()) {
                        echo "<option value='" . $row['orden'] . "'>" . $row['orden'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Familia</label>
            <select name="familia" class="form-control" required>
                <option value="">Selecciona una familia</option>
                <?php
                if ($resultFamilias->num_rows > 0) {
                    while ($row = $resultFamilias->fetch_assoc()) {
                        echo "<option value='" . $row['familia'] . "'>" . $row['familia'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Resto del formulario -->
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" placeholder="Descripción detallada del animal" required></textarea>
        </div>

        <div class="mb-3">
            <label>Alimentación</label>
            <input type="text" name="alimentacion" class="form-control" placeholder="Ejemplo: Carnívoro" required>
        </div>

        <div class="mb-3">
            <label>Distribución</label>
            <input type="text" name="distribucion" class="form-control" placeholder="Ejemplo: África" required>
        </div>

        <div class="mb-3">
            <label>Peso (kg)</label>
            <input type="number" name="peso" class="form-control" placeholder="Ejemplo: 190" required>
        </div>

        <div class="mb-3">
            <label>Talla (cm)</label>
            <input type="number" name="talla" class="form-control" placeholder="Ejemplo: 120" required>
        </div>

        <div class="mb-3">
            <label>Tiempo de Gestación (días)</label>
            <input type="number" name="gestacion" class="form-control" placeholder="Ejemplo: 110" required>
        </div>

        <div class="mb-3">
            <label>Promedio de Crías</label>
            <input type="number" name="crias" class="form-control" placeholder="Ejemplo: 2" required>
        </div>

        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control" required>
        </div>

        <button type="submit" class="btn-success">Registrar Especie</button>
    </form>
</div>

</body>
</html>