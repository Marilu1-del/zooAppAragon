<?php
// Verificar si la sesión ya está activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuración de la conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Zoologico");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Insertar tratamiento si se envió el formulario
if (isset($_POST['registrar'])) {
    // Verificar que todos los campos estén presentes
    if (empty($_POST['fecha']) || empty($_POST['tipoTratamiento']) || empty($_POST['medicamentos'])) {
        $mensaje = "<p style='color: red; text-align: center;'>Todos los campos son obligatorios.</p>";
    } else {
        // Verificar si hay una sesión activa
        if (!isset($_SESSION['veterinario'])) {
            header("Location: login.php"); // Redirige a la página de inicio de sesión
            exit();
        }

        // Validar formato de fecha
        if (!DateTime::createFromFormat('Y-m-d', $_POST['fecha'])) {
            $mensaje = "<p style='color: red; text-align: center;'>Formato de fecha inválido.</p>";
        } else {
            $veterinario = $_SESSION['veterinario']; // Nombre del veterinario desde la sesión
            $fecha = $_POST['fecha'];
            $tipoTratamiento = $_POST['tipoTratamiento'];
            $medicamentos = $_POST['medicamentos'];
            $seguimiento = $_POST['seguimiento'] ?? ''; // Si no se envía, se asigna una cadena vacía

            // Sentencia preparada para evitar inyecciones SQL
            $query = $conexion->prepare("INSERT INTO Tratamientos (Fecha, TipoTratamiento, Medicamentos, VeterinarioResponsable, Seguimiento)
                                         VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("sssss", $fecha, $tipoTratamiento, $medicamentos, $veterinario, $seguimiento);

            // Ejecutar la consulta
            if ($query->execute()) {
                $mensaje = "<p style='color: green; text-align: center;'>Tratamiento registrado exitosamente.</p>";
            } else {
                $mensaje = "<p style='color: red; text-align: center;'>Error al registrar el tratamiento: " . $conexion->error . "</p>";
            }

            // Cerrar la consulta preparada
            $query->close();
        }
    }

    // Almacenar mensaje en sesión para mostrarlo después de redirigir
    $_SESSION['mensaje'] = $mensaje;
    header("Location: tratamientos.php"); // Redirige a la página de tratamientos
    exit();
}

// Cerrar la conexión
$conexion->close();
?>