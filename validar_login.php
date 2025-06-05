<?php
session_start();
require 'conexionapr.php';

// Convertir el usuario a minúsculas y eliminar espacios
$usuario = strtolower(trim($_POST['usuario']));
$password = $_POST['password'];

$query = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "s", $usuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if ($fila = mysqli_fetch_assoc($resultado)) {
    if (password_verify($password, $fila['password'])) {
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['rol'] = $fila['rol'];
        header("Location: aprnontuela.php");
        exit();
    } else {
        $_SESSION['error'] = "Contraseña incorrecta.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Usuario no encontrado.";
    header("Location: login.php");
    exit();
}
?>