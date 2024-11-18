<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) { 
        $_SESSION['username'] = $user['username'];
        $_SESSION['rol'] = $user['rol'];

        if ($user['rol'] === 'teacher') {
            header("Location: ../screens/profesor.php");
        } else {
            header("Location: ../screens/alumno.php");
        }
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
    }
}
?>
