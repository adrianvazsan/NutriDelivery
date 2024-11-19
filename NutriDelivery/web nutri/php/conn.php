<?php

$servername = "localhost";
$database = "nutridelivery";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Añadir usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    añadirUsuario();
}

function añadirUsuario(){
    global $conn;

    $username = $_POST['username'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (username, correo, telefono, password) VALUES ('$username', '$correo', '$telefono', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        header('Location: ../main.html');
    } else {
        echo "Error en el registro: " . $conn->error;
    }
}
?>