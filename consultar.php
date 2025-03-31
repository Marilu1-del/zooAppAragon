<?php include('connection.php');

$con = connection();

$sql = "SELECT * FROM personal";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Personal</title>
    <style>
        .container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9); /* Fondo semi-transparente */
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.details-container {
    display: grid; /* O display: flex; */
    grid-template-columns: 1fr 1fr; /* Dos columnas */
    gap: 10px;
}

.detail-row {
    display: flex;
    align-items: center; /* Alineación vertical */
}

.detail-label {
    font-weight: bold;
    width: 100px; /* Ancho fijo para las etiquetas */
}

.detail-value {
    /* ... estilos para los valores ... */
}
</style>
</head>
<body>
    <header class="Encabezado">
        </header>

    <nav id="nav-menu">
        </nav>

    <div class="container" action="insert.php" method="POST">  <h1>Detalles de Personal</h1>

                <div class="details-container">  <div class="detail-row">
                        <div class="detail-label">Nombre:</div>
                        <div class="detail-value"><?= $row['Nombre'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Rol:</div>
                        <div class="detail-value"><?= $row['Rol'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email:</div>
                        <div class="detail-value"><?= $row['Email'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Teléfono:</div>
                        <div class="detail-value"><?= $row['Telefono'] ?></div>
                    </div>
                    </div>

    </div>

    <footer class="footer">
        </footer>
</body>
</html>