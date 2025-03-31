<?php include('connection.php');

$con = connection();

$PersonalID=$_GET['PersonalID'];

$sql = "DELETE FROM personal WHERE PersonalID='$PersonalID'";

$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: MantenerPersonal.php");
};

?>