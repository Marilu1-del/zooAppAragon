<?php include('connection.php');

$con = connection();

$PersonalID = $_POST['PersonalID'];
$Nombre = $_POST['Nombre'];
$Rol = $_POST['Rol'];
$Email = $_POST['Email'];
$Telefono = $_POST['Telefono'];

$sql = "UPDATE personal SET Nombre='$Nombre', Rol='$Rol', Email='$Email', Telefono='$Telefono' WHERE PersonalID='$PersonalID'";

$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: MantenerPersonal.php");
};

?>