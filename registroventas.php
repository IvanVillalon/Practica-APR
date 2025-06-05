<?php
require 'conexionapr.php';

if (isset($_POST['registrarventa'])) {
    date_default_timezone_set("America/Santiago");

    $rut = $_POST['rut_cliente'];
    $nombre = $_POST['nombre_cliente'];
    $total_metros_cubicos = $_POST['metros_cubicos'];
    $valor_metro_cubico = $_POST['valor_m3'];

    // Verificar si el RUT existe y el nombre coincide
    $consulta = $conexion->prepare("SELECT * FROM clientes WHERE rut = ? AND nombre = ?");
    $consulta->bind_param("ss", $rut, $nombre);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows === 0) {
        // RUT y nombre no coinciden
        echo "<script>alert('El RUT y el nombre no coinciden con un cliente registrado.'); window.history.back();</script>";
        exit(); // Detener la ejecución
    }

    // Si todo está correcto, registramos la venta
    $total = $total_metros_cubicos * $valor_metro_cubico;

    $stmt = $conexion->prepare("INSERT INTO ventas (rut_cliente, nombre_cliente, metros_cubicos, valor_m3, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidd", $rut, $nombre, $total_metros_cubicos, $valor_metro_cubico, $total);

    if ($stmt->execute()) {
        echo "<script>alert('Venta registrada correctamente.'); window.location.href='aprnontuela.php?seccion=registrar_venta';</script>";
    } else {
        echo "<script>alert('Error al registrar la venta.'); window.history.back();</script>";
    }

    $stmt->close();
    $consulta->close();
    $conexion->close();
}
?>
