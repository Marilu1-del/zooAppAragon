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

// Verificar si se recibió un ID para editar el animal
if (isset($_GET['id'])) {
    $animalID = intval($_GET['id']);

    // Recuperar los datos del animal
    $stmt = $conn->prepare("SELECT * FROM animales WHERE AnimalID = ?");
    $stmt->bind_param("i", $animalID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si existe el animal, cargar los datos
    if ($row = $result->fetch_assoc()) {
        // Guardar datos del animal en variables
        $nombre        = $row['nombre'];
        $especie       = $row['especie'];
        $clase         = $row['clase'];
        $orden         = $row['orden'];
        $familia       = $row['familia'];
        $descripcion   = $row['descripcion'];
        $alimentacion  = $row['alimentacion'];
        $distribucion  = $row['distribucion'];
        $peso          = $row['peso'];
        $talla         = $row['talla'];
        $gestacion     = $row['gestacion'];
        $crias         = $row['crias'];
        $imagen        = $row['imagen'];
    } else {
        echo "No se encontró el animal.";
        exit;
    }

    $stmt->close();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre        = $_POST['nombre'] ?? null;
    $especie       = $_POST['especie'] ?? null;
    $clase         = $_POST['clase'] ?? null;
    $orden         = $_POST['orden'] ?? null;
    $familia       = $_POST['familia'] ?? null;
    $descripcion   = $_POST['descripcion'] ?? null;
    $alimentacion  = $_POST['alimentacion'] ?? null;
    $distribucion  = $_POST['distribucion'] ?? null;
    $peso          = $_POST['peso'] ?? null;
    $talla         = $_POST['talla'] ?? null;
    $gestacion     = $_POST['gestacion'] ?? null;
    $crias         = $_POST['crias'] ?? null;

    $imagen = $_FILES['imagen']['name'] ?? null;
    $ruta   = "uploads/" . basename($imagen);

    // Si se sube una nueva imagen
    if ($imagen && move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        // Eliminar la imagen anterior si existe
        if (!empty($row['imagen']) && file_exists("uploads/" . $row['imagen'])) {
            unlink("uploads/" . $row['imagen']);
        }
    } else {
        // Mantener la imagen actual si no se sube una nueva
        $imagen = $row['imagen'];
    }

    // Actualizar los datos del animal en la base de datos
    $stmt = $conn->prepare("UPDATE animales SET nombre = ?, especie = ?, clase = ?, orden = ?, familia = ?, descripcion = ?, alimentacion = ?, distribucion = ?, peso = ?, talla = ?, gestacion = ?, crias = ?, imagen = ? WHERE AnimalID = ?");
    $stmt->bind_param("ssssssssiiissi", $nombre, $especie, $clase, $orden, $familia, $descripcion, $alimentacion, $distribucion, $peso, $talla, $gestacion, $crias, $imagen, $animalID);

    if ($stmt->execute()) {
        echo "<script>
            alert('Especie editada correctamente.');
            window.location.href = 'Gest_especies.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al editar la especie: " . $stmt->error . "');
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Especie</title>
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

        img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Especie: <?= htmlspecialchars($nombre) ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
        </div>

        <div class="mb-3">
            <label>Especie</label>
            <select name="especie" class="form-control" required>
                <option value="">Selecciona una especie</option>
                <?php
                if ($resultEspecies->num_rows > 0) {
                    while ($rowEspecie = $resultEspecies->fetch_assoc()) {
                        $selected = ($rowEspecie['especie'] === $especie) ? "selected" : "";
                        echo "<option value='" . $rowEspecie['especie'] . "' $selected>" . $rowEspecie['especie'] . "</option>";
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
                    while ($rowClase = $resultClases->fetch_assoc()) {
                        $selected = ($rowClase['clase'] === $clase) ? "selected" : "";
                        echo "<option value='" . $rowClase['clase'] . "' $selected>" . $rowClase['clase'] . "</option>";
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
                    while ($rowOrden = $resultOrdenes->fetch_assoc()) {
                        $selected = ($rowOrden['orden'] === $orden) ? "selected" : "";
                        echo "<option value='" . $rowOrden['orden'] . "' $selected>" . $rowOrden['orden'] . "</option>";
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
                    while ($rowFamilia = $resultFamilias->fetch_assoc()) {
                        $selected = ($rowFamilia['familia'] === $familia) ? "selected" : "";
                        echo "<option value='" . $rowFamilia['familia'] . "' $selected>" . $rowFamilia['familia'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($descripcion) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Alimentación</label>
            <input type="text" name="alimentacion" class="form-control" value="<?= htmlspecialchars($alimentacion) ?>" required>
        </div>

        <div class="mb-3">
            <label>Distribución</label>
            <input type="text" name="distribucion" class="form-control" value="<?= htmlspecialchars($distribucion) ?>" required>
        </div>

        <div class="mb-3">
            <label>Peso (kg)</label>
            <input type="number" name="peso" class="form-control" value="<?= htmlspecialchars($peso) ?>" required>
        </div>

        <div class="mb-3">
            <label>Talla (cm)</label>
            <input type="number" name="talla" class="form-control" value="<?= htmlspecialchars($talla) ?>" required>
        </div>

        <div class="mb-3">
            <label>Tiempo de Gestación (días)</label>
            <input type="number" name="gestacion" class="form-control" value="<?= htmlspecialchars($gestacion) ?>" required>
        </div>

        <div class="mb-3">
            <label>Promedio de Crías</label>
            <input type="number" name="crias" class="form-control" value="<?= htmlspecialchars($crias) ?>" required>
        </div>

        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control">
            <?php if (!empty($imagen)) { ?>
                <small>Imagen actual: <img src="uploads/<?= htmlspecialchars($imagen) ?>" alt="Imagen actual"></small>
            <?php } else { ?>
                <small>No hay imagen actual.</small>
            <?php } ?>
        </div>

        <button type="submit" class="btn-success">Guardar Cambios</button>
    </form>
</div>

</body>
</html>