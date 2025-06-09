<?php
require 'conexionapr.php';



if (!empty($_POST['ventas_seleccionadas']) && !empty($_POST['nuevo_estado'])) {
    $ventas = $_POST['ventas_seleccionadas'];
    $nuevo_estado = mysqli_real_escape_string($conexion, $_POST['nuevo_estado']);

    foreach ($ventas as $id) {
        $id = (int)$id;
        $query = "UPDATE ventas SET Estado = '$nuevo_estado' WHERE id = $id";
        mysqli_query($conexion, $query);
    }

    header("Location: aprnontuela.php?seccion=estado_ventas&mensaje=ok");
    exit;
} else {
    echo "Debe seleccionar al menos una venta y un nuevo estado.";
}
?>

