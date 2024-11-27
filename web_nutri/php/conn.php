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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST["hidden-registro"]) && !isset($_GET['id'])) {
    registrarUsuario();
}

// Verificar usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST["hidden-login"]) && !isset($_GET['id'])) {
    verificarUsuario();
}


function registrarUsuario(){
    global $conn;

    $username = $_POST['username'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $passwordsMatch = false;

    if ($password === $repeat_password) {
        $passwordsMatch = true;
    } else {
        echo "Error: Passwords do not match. Please try again.";
    }
    if($passwordsMatch){
        $sql = "INSERT INTO usuario (username, correo, telefono, password) VALUES ('$username', '$correo', '$telefono', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../main.html');
        } else {
            echo "Error en el registro: " . $conn->error;
        }
    }
}
function verificarUsuario(){
    global $conn;
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT password FROM usuario WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Comprobar si el usuario existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['username'] = $username; 
            header('Location: ../main.html'); 
            exit();
        } else {
            echo "Error: contraseña incorrecta";
        }
    } else {
        echo "Error: usuario no encontrado";
    }

    $stmt->close();

}
?>