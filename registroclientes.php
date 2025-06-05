<?php
include 'conexionapr.php';

if (isset($_POST['registrarcliente'])) {
    $rut      = trim($_POST['rut']);
    $nombre   = trim($_POST['nombrecliente']);
    $correo   = trim($_POST['correocliente']);
    $contacto = trim($_POST['contacto']);

    // Validar contacto: solo números y 9 dígitos exactos
    if (!preg_match('/^\d{9}$/', $contacto)) {
        echo "<script>
            alert('El número de contacto debe tener exactamente 9 dígitos.');
            setTimeout(function() {
                window.location.href = 'aprnontuela.php';
            }, 2000);
        </script>";
        exit;
    }

    // Validar formato básico del RUT
    if (!preg_match('/^\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]$/', $rut)) {
        echo "<script>
            alert('El RUT no tiene un formato válido.');
            setTimeout(function() {
                window.location.href = 'aprnontuela.php';
            }, 500);
        </script>";
        exit;
    }

    // Validar correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('El correo no es válido.');
            setTimeout(function() {
                window.location.href = 'aprnontuela.php';
            }, 2000);
        </script>";
        exit;
    }

    // Verificar que el RUT, Email o Nombre no estén ya registrados
    $verificar = $conexion->prepare("SELECT * FROM clientes WHERE Rut = ? OR Email = ? OR Nombre = ?");
    $verificar->bind_param("sss", $rut, $correo, $nombre);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        // Averiguar qué campo está repetido
        $fila = $resultado->fetch_assoc();
        if ($fila['Rut'] === $rut) {
            $mensaje = "El RUT ya está registrado.";
        } elseif ($fila['Email'] === $correo) {
            $mensaje = "El correo ya está registrado.";
        } elseif ($fila['Nombre'] === $nombre) {
            $mensaje = "El nombre ya está registrado.";
        } else {
            $mensaje = "Ya existe un cliente con estos datos.";
        }

        echo "<script>
            alert('".$mensaje."');
            setTimeout(function() {
                window.location.href = 'aprnontuela.php?seccion=registrar_cliente';
            }, 500);
        </script>";
        exit;
    }

    // Insertar si todo es válido
    $stmt = $conexion->prepare("INSERT INTO clientes (Rut, Nombre, Email, Contacto) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Error en prepare(): " . $conexion->error);
    }

    $stmt->bind_param("ssss", $rut, $nombre, $correo, $contacto);

    if ($stmt->execute()) {
        echo "<script>
            alert('Cliente registrado correctamente.');
            setTimeout(function() {
                window.location.href = 'aprnontuela.php?seccion=registrar_cliente.php';
            }, 1000);
        </script>";
    } else {
        echo "<script>
            alert('Error al registrar cliente: " . $stmt->error . "');
            setTimeout(function() {
                window.location.href = 'aprnontuela.php?seccion=registrar_cliente.php';
            }, 1000);
        </script>";
    }
}
?>

