<?php
include('connection.php');

$con = connection();

$PersonalID = null;
$Nombre = $_POST['Nombre'];
$Rol = $_POST['Rol'];
$Email = $_POST['Email'];
$Telefono = $_POST['Telefono'];

// Especifica las columnas a las que pertenecen los valores
$sql = "INSERT INTO personal (PersonalID, Nombre, Rol, Email, Telefono) VALUES ('$PersonalID', '$Nombre', '$Rol', '$Email', '$Telefono')";

$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: MantenerPersonal.php");
} else {
    // Manejo de errores: Imprime el mensaje de error de MySQL para depurar
    echo "Error al insertar datos: " . mysqli_error($con); 
}
?>