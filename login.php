<?php
// Conexión a la base de datos (reemplaza con tus datos)
$conn = new mysqli("localhost", "tu_usuario", "tu_contraseña", "tu_base_de_datos");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']));
}

$username = $_POST['username'];
$password = $_POST['password'];

// Consulta a la base de datos (reemplaza con tu consulta)
$stmt = $conn->prepare("SELECT user_type FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->bind_result($user_type);
$stmt->fetch();
$stmt->close();

if ($user_type) {
    echo json_encode(['success' => true, 'user_type' => $user_type]);
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas.']);
}

$conn->close();
?>