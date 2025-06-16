<?php
require 'conexionapr.php'; // Conexión a base de datos
require_once('tcpdf/tcpdf.php'); // Clase TCPDF para generar PDF
session_start();
// Primero, maneja la acción de cerrar sesión
if (isset($_GET['seccion']) && $_GET['seccion'] === 'cerrar_sesion') {
    $_SESSION = [];
    session_destroy();
    header("Location: login.php"); // Cambia a la página que desees
    exit();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>APR NONTUELA</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div id="fondo3d"></div>
<!--BARRA DE NAVEGACION -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: rgb(58, 96, 174);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="?seccion=inicio">
            <img src="LOGO.png" alt="Logo APR" width="60" height="60" class="me-2">
            APR NONTUELA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavbar" aria-controls="menuNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       <div class="collapse navbar-collapse" id="menuNavbar">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="?seccion=inicio">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="icono-nav" viewBox="0 0 16 16">
                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
                </svg>
                Inicio
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?seccion=registrar_cliente">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="icono-nav" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path d="M13 5v2h2v1h-2v2h-1V8h-2V7h2V5z"/>
                    <path d="M2 13s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H2z"/>
                </svg>
                Registrar Cliente
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?seccion=registrar_venta">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="icono-nav" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                </svg>
                Registrar Venta
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?seccion=historial_ventas">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="icono-nav" viewBox="0 0 16 16">
                    <path d="M6.445 11.688V6.354h-.633A13 13 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61z"/>
                    <path d="M8 8c0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23 0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2z"/>
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5A.5.5 0 0 1 3.5 0z"/>
                </svg>
                Historial Ventas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?seccion=estado_ventas">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="icono-nav" viewBox="0 0 16 16">
                    <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1z"/>
                    <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
                Estado Venta
             </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?seccion=consulta_clientes">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="icono-nav" viewBox="0 0 16 16">
                    <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1z"/>
                    <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
                Clientes Registrados
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?seccion=cerrar_sesion">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="icono-nav" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 15a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0V14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2.5a.5.5 0 0 1-1 0V2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708L13.172 5H8.5a.5.5 0 0 0 0 1H12.293l2.147 2.146a.5.5 0 0 0 .707 0z"/>
                </svg>
                Cerrar Sesión
            </a>
        </li>
    </ul>
</div>

    </div>
</nav>
<?php
$seccion = $_GET['seccion'] ?? 'inicio';
 if ($seccion == 'inicio') {
        ?>
        <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 70vh; text-align:center;">
        <h1 class="display-4 mb-3">¡Bienvenido a APR Nontuela!</h1>
        <p class="lead">Aquí podrás gestionar clientes, registrar ventas y consultar el historial fácilmente.</p>
        <img src="LOGO.png" alt="Logo APR" style="width: 200px; margin-top: 1px;">
        </div>
        <?php
    }
    if ($seccion == 'registrar_cliente') {
        ?>
        <!-- Formulario de registro de cliente -->
        <div class="login-container" >
            <form action="registroclientes.php" method="POST" >
                <h2 class="titulo-animado mb-4 text-center">Registrar Cliente</h2>
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" name="nombrecliente" class="form-control" placeholder="Nombre cliente" minlength="3" maxlength="30" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correocliente" class="form-control" placeholder="Correo cliente"  maxlength="300" minlength="2" title="Ingrese un correo válido" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">RUT</label>
                    <input type="text" id="rut" name="rut" class="form-control" maxlength="12" pattern="\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]" placeholder="12.345.678-5" title="Ingrese un RUT válido (formato: 12.345.678-5)" oninput="formatearRut(this)" required>

                </div>
                <div class="mb-3">
                    <label class="form-label">Contacto</label>
                    <input type="text" name="contacto" class="form-control" pattern="\d{9}" maxlength="9" placeholder="912345678" title="Debe contener exactamente 9 dígitos" required>
                </div>
                <button type="submit" name="registrarcliente" class="btn btn-primary w-100">Registrar</button>
            </form>
        </div>
        <script>
            function formatearRut(input) {
            let valor = input.value.replace(/\./g, '').replace('-', '').replace(/[^0-9kK]/g, '');
            if (valor.length > 1) {
                let cuerpo = valor.slice(0, -1);
                let dv = valor.slice(-1).toUpperCase();
                input.value = cuerpo
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + dv;
            } else {
                input.value = valor;
            }
            }
        </script>
<?php
    } elseif ($seccion == 'registrar_venta') {
        ?>
        <!-- Formulario de registro de venta -->
        <div class="login-container">
            <form action="registroventas.php" method="POST" >
                <h2 class="titulo-animado mb-4 text-center">Registrar Venta</h2>
                <div class="mb-3">
                    <label class="form-label">RUT Cliente</label>
                    <input type="text" name="rut_cliente" class="form-control" placeholder="12.345.678-5" maxlength="12" pattern="\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]"  title="Ingrese un RUT válido (formato: 12.345.678-5)" oninput="formatearRut(this)" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre Cliente</label>
                    <input type="text" name="nombre_cliente" class="form-control" placeholder="Nombre completo" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Metros Cúbicos</label>
                    <input type="number" name="metros_cubicos" class="form-control" min="1" placeholder="Metros Cúbicos" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Valor Metro Cúbico</label>
                    <input type="number" step="0.01" name="valor_m3" class="form-control" min="0" placeholder="Valor por metro cúbico" required>
                </div>
                <button type="submit" name="registrarventa" class="btn btn-primary w-100">Registrar Venta</button>
            </form>
        </div>
        <script>
        function formatearRut(input) {
            let valor = input.value.replace(/\./g, '').replace('-', '').replace(/[^0-9kK]/g, '');
            if (valor.length > 1) {
                let cuerpo = valor.slice(0, -1);
                let dv = valor.slice(-1).toUpperCase();
                input.value = cuerpo
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + dv;
            } else {
                input.value = valor;
            }
            }
            </script>
        <?php
    } elseif ($seccion == 'historial_ventas') {
    $mostrar_tabla = false;
    $resultado = null;
    $condiciones = [];
    $filtro = "";

    $form_enviado = !empty($_GET['fecha_inicio']) || !empty($_GET['fecha_fin']) || !empty($_GET['rut_cliente']) || !empty($_GET['ver_todo']);

    if ($form_enviado) {
        if (!empty($_GET['ver_todo'])) {
            $filtro = "";
        } else {
            if (!empty($_GET['fecha_inicio']) && !empty($_GET['fecha_fin'])) {
                $fecha_inicio = $_GET['fecha_inicio'];
                $fecha_fin = $_GET['fecha_fin'];
                $condiciones[] = "fecha_venta BETWEEN '$fecha_inicio 00:00:00' AND '$fecha_fin 23:59:59'";
            }
            if (!empty($_GET['rut_cliente'])) {
                $rut_cliente = mysqli_real_escape_string($conexion, $_GET['rut_cliente']);
                $condiciones[] = "rut_cliente LIKE '%$rut_cliente%'";
            }
            if (!empty($condiciones)) {
                $filtro = "WHERE " . implode(" AND ", $condiciones);
            }
        }

        $consulta = "SELECT * FROM ventas $filtro ORDER BY fecha_venta DESC";
        $resultado = mysqli_query($conexion, $consulta);
        $mostrar_tabla = true;
    }
?>
<div class="login-container my-5">

    <!-- Formulario de filtros -->
    <div class="container" >
        <h2 class="titulo-animado mb-4 text-center">Historial de Ventas</h2>
        <form method="GET" action="">
            <input type="hidden" name="seccion" value="historial_ventas">

            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                    value="<?php echo htmlspecialchars($_GET['fecha_inicio'] ?? '', ENT_QUOTES); ?>">
            </div>

            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha fin:</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                    value="<?php echo htmlspecialchars($_GET['fecha_fin'] ?? '', ENT_QUOTES); ?>">
            </div>

            <div class="mb-3">
                <label for="rut_cliente" class="form-label">RUT cliente:</label>
                <input type="text" class="form-control" id="rut_cliente" name="rut_cliente"
                    placeholder="Ej: 12.345.678-9" maxlength="12"
                    pattern="\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]"
                    title="Ingrese un RUT válido (formato: 12.345.678-5)"
                    oninput="formatearRut(this)"
                    value="<?php echo htmlspecialchars($_GET['rut_cliente'] ?? '', ENT_QUOTES); ?>">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="ver_todo" name="ver_todo" value="1"
                    <?php if (!empty($_GET['ver_todo'])) echo 'checked'; ?>>
                <label class="form-check-label" for="ver_todo">Ver todo el historial</label>
            </div>
    </div>            

            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </form>
    </div>
<?php if ($mostrar_tabla && isset($resultado)): ?>
    <form method="POST" action="pdf_ventas.php" target="_blank" id="formVentas">
    <input type="hidden" name="modo" value="seleccion"> <!-- Para el caso de las ventas seleccionadas -->
    
    <div class="card bg-light p-4 shadow">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th></th>
                        <th style="width:5%;">ID</th>
                        <th style="width:20%;">Cliente</th>
                        <th style="width:12%;">RUT</th>
                        <th style="width:10%;">Metros³</th>
                        <th style="width:13%;">Valor M³</th>
                        <th style="width:13%;">Total</th>
                        <th style="width:17%;">Fecha</th>
                        <th style="width:10%;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                            <tr class="text-center">
                                <td><input type="checkbox" name="ventas_seleccionadas[]" value="<?php echo $fila['id']; ?>"></td>
                                <td style="width:5%;"><?php echo $fila['id']; ?></td>
                                <td style="width:20%;"><?php echo htmlspecialchars($fila['nombre_cliente']); ?></td>
                                <td style="width:12%;"><?php echo htmlspecialchars($fila['rut_cliente']); ?></td>
                                <td style="width:10%;"><?php echo $fila['metros_cubicos']; ?></td>
                                <td style="width:13%;">$<?php echo number_format($fila['valor_m3'], 0, ',', '.'); ?></td>
                                <td style="width:13%;">$<?php echo number_format($fila['total'], 0, ',', '.'); ?></td>
                                <td style="width:17%;"><?php echo date('d/m/Y H:i', strtotime($fila['fecha_venta'])); ?></td>
                                <td style="width:10%;"><?php echo htmlspecialchars($fila['Estado']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No se encontraron resultados para el filtro.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Botón para generar PDF con ventas seleccionadas -->
        <button type="submit" class="btn btn-danger mt-3">Generar PDF de seleccionados</button><br>

        <!-- Botón para generar PDF con todas las ventas -->
        <button type="submit" name="seleccionar_todos" value="todos" class="btn btn-success w-100">Generar PDF con todas las ventas</button>
    </div>
</form>

<?php endif; ?>

<!-- Scripts -->
<script>
    function formatearRut(input) {
        let valor = input.value.replace(/\./g, '').replace('-', '').replace(/[^0-9kK]/g, '');
        if (valor.length > 1) {
            let cuerpo = valor.slice(0, -1);
            let dv = valor.slice(-1).toUpperCase();
            input.value = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + dv;
        } else {
            input.value = valor;
        }
    }

    document.getElementById('ver_todo').addEventListener('change', function () {
        const disabled = this.checked;
        document.getElementById('fecha_inicio').disabled = disabled;
        document.getElementById('fecha_fin').disabled = disabled;
        document.getElementById('rut_cliente').disabled = disabled;
    });

    window.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('ver_todo');
        if (checkbox.checked) {
            document.getElementById('fecha_inicio').disabled = true;
            document.getElementById('fecha_fin').disabled = true;
            document.getElementById('rut_cliente').disabled = true;
        }
    });

    document.querySelector('form[action=""]').addEventListener('submit', function (e) {
        const verTodo = document.getElementById('ver_todo').checked;
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;
        const rutCliente = document.getElementById('rut_cliente').value.trim();

        if (!verTodo && fechaInicio === '' && fechaFin === '' && rutCliente === '') {
            e.preventDefault();
            alert('Por favor, seleccione al menos un filtro o marque "Ver todo el historial".');
        }
    });

    document.getElementById('seleccionar_todos')?.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="ventas_seleccionadas[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    document.getElementById('formVentas')?.addEventListener('submit', function (e) {
    // Si se presionó el botón de "Generar PDF con todas las ventas", no se verifica si hay ventas seleccionadas
    if (document.querySelector('button[name="seleccionar_todos"]:focus')) {
        return; // Si el botón "Generar PDF con todas las ventas" está enfocado, no se hace nada.
    }

    // Verificar si hay ventas seleccionadas
    const seleccionados = document.querySelectorAll('input[name="ventas_seleccionadas[]"]:checked');
    if (seleccionados.length === 0) {
        e.preventDefault();
        alert('Por favor, seleccione al menos una venta para generar el PDF.');
    }
});

</script>
<?php } 
if ($seccion == 'consulta_clientes') {


// Asumiendo que ya tienes la conexión a la base de datos

$seccion = 'consulta_clientes';
$resultado = null;
$filtro = "";
$rut_cliente = "";
$ver_todos = !empty($_GET['ver_todos']);

if (!empty($_GET['rut_cliente']) || $ver_todos) {
    if ($ver_todos) {
        $filtro = "";
    } else {
        $rut_cliente = mysqli_real_escape_string($conexion, $_GET['rut_cliente']);
        $filtro = "WHERE Rut LIKE '%$rut_cliente%'";
    }

    $consulta = "SELECT * FROM clientes $filtro ORDER BY Nombre ASC";
    $resultado = mysqli_query($conexion, $consulta);
}
?>

<div class="login-container">
    <h2 class="titulo-animado mb-4 text-center">Consulta de Clientes</h2>
    <form method="GET" action="">
        <input type="hidden" name="seccion" value="consulta_clientes">

        <div class="mb-3">
            <label for="rut_cliente" class="form-label">Buscar por RUT:</label>
            <input type="text" class="form-control" id="rut_cliente" name="rut_cliente" placeholder="Ej: 12.345.678-9" maxlength="12" pattern="\d{1,2}\.?\d{3}\.?\d{3}-[\dkK]" value="<?php echo $rut_cliente; ?>" oninput="formatearRut(this)" <?php if ($ver_todos) echo 'disabled'; ?>>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="ver_todos" name="ver_todos" value="1" <?php if ($ver_todos) echo 'checked'; ?>>
            <label class="form-check-label" for="ver_todos">Ver todos los clientes</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Buscar</button>
    </form>
</div>

<script>
    // Función para formatear el RUT
    function formatearRut(input) {
        let valor = input.value.replace(/\./g, '').replace('-', '').replace(/[^0-9kK]/g, '');
        if (valor.length > 1) {
            let cuerpo = valor.slice(0, -1);
            let dv = valor.slice(-1).toUpperCase();
            input.value = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + dv;
        } else {
            input.value = valor;
        }
    }  
</script>

<?php if ($resultado): ?>
 <form method="POST" action="generar_pdf_clientes.php" target="_blank" id="formClientes">
    <div class="card bg-light p-4 shadow mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary text-center">
                    <tr>
                        <th></th>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                            <tr class="text-center">
                                <td><input type="checkbox" name="clientes_seleccionados[]" value="<?php echo $fila['Rut']; ?>"></td>
                                <td><?php echo $fila['Rut']; ?></td>
                                <td><?php echo $fila['Nombre']; ?></td>
                                <td><?php echo $fila['Email']; ?></td>
                                <td><?php echo $fila['Contacto']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No se encontraron clientes.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-danger mt-3" id="generateSelectedPdf">Generar PDF Seleccionados</button>
        <button type="button" class="btn btn-danger mt-3" id="generateAllPdf">Generar PDF Todos</button>
    </div>
</form>

<?php endif; ?>

<!--Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formClientes = document.getElementById('formClientes');
    const btnGenerarSeleccionados = document.getElementById('generateSelectedPdf');
    const btnGenerarTodos = document.getElementById('generateAllPdf');

    // Funcionalidad del botón "Generar PDF Seleccionados"
    btnGenerarSeleccionados.addEventListener('click', function (e) {
        e.preventDefault(); // Evita el envío del formulario si no hay selección

        // Verificar si hay al menos un cliente seleccionado
        const checkboxes = document.querySelectorAll('input[name="clientes_seleccionados[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor, seleccione al menos un cliente para generar el PDF.');
            return; // Si no hay selección, no enviamos el formulario
        }

        // Si hay selección, enviamos el formulario
        formClientes.submit();
    });

    // Funcionalidad del botón "Generar PDF Todos"
    btnGenerarTodos.addEventListener('click', function () {
        // Marcar todos los checkboxes antes de enviar el formulario
        const checkboxes = document.querySelectorAll('input[name="clientes_seleccionados[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = true);

        // Enviar el formulario
        formClientes.submit();
    });
});


</script>


<?php
}if($seccion == 'estado_ventas'){
    $resultado= null;
    $filtro= "";
    $mostrar_tabla= false;
    $ver_todos = !empty($_GET['ver_todo']);
    if ($ver_todos) {
        if(!empty($_GET['ver_todo'])){
            $filtro= "";
        }
        $consulta= "SELECT * FROM ventas $filtro ORDER BY fecha_venta DESC";
        $resultado = mysqli_query($conexion, $consulta);
        if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
        $mostrar_tabla= true;
    }
    ?>
    <div class="container my-5">
        <form method="GET" action="">
            <input type="hidden" name="seccion" value="estado_ventas">
       
            <button type="submit" class="btn btn-primary w-100" id="ver_todo" name="ver_todo" value="1">Ver Estados</button>
        </form>
   <?php if ($mostrar_tabla && isset($resultado)): ?>
<form method="POST" action="actualizarestado.php" class="form-group">
    <div class="card bg-light p-4 shadow mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Rut</th>
                        <th>Cliente</th>
                        <th>Metros³</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila= mysqli_fetch_assoc($resultado)): ?>
                        <tr class="text-center">
                            <td><input type="checkbox" name="ventas_seleccionadas[]" value="<?php echo $fila['id']; ?>"></td>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo $fila['rut_cliente']; ?></td>
                            <td><?php echo $fila['nombre_cliente']; ?></td>
                            <td><?php echo $fila['metros_cubicos']; ?></td>
                            <td><?php echo $fila['total']; ?></td>
                            <td><?php echo date('d/m/Y H:i',strtotime($fila['fecha_venta'])); ?></td>
                            <td><?php echo $fila['Estado']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Select oculto que se mostrará al hacer clic en el botón -->
        <div id="contenedorSelect" style="display: none;" class="mt-2">
            <label for="opciones">Elige nuevo estado:</label>
            <select id="opciones" name="nuevo_estado" class="form-select" required>
                <option value="">-- Selecciona --</option>
                <option value="Pagado">Pagado</option>
                <option value="Deuda">Deuda</option>
                <option value="Anulado">Anulado</option>
            </select>
            <button type="submit" class="btn btn-success mt-2">Guardar Cambios</button>
        </div>

        <!-- Botón que muestra el select -->
        <button type="button" class="btn btn-danger mt-3" onclick="mostrarSelect()">Actualizar Estado</button>
    </div>
</form>
<?php endif; ?>

    <?php
}?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vanta/dist/vanta.waves.min.js"></script>
<script>
document.getElementById('contenedorSelect').addEventListener('submit', function(e) {
  e.preventDefault(); // Evita que el formulario se recargue
  document.getElementById('contenedorSelect').style.display = 'block'; // Muestra el select

});
</script>
<script>
function mostrarSelect() {
    document.getElementById('contenedorSelect').style.display = 'block';
}
</script>
<script> function mostrarSelect(){
    document.getElementById("contenedorSelect").style.display= "block";
}
</script>
  <!-- Activar el fondo animado -->
  <script>
      VANTA.WAVES({
      el: "#fondo3d",
      mouseControls: true,
      touchControls: true,
      color: 0x0b2a4a,
      waveHeight: 20,
      waveSpeed: 1,
      zoom: 1.2
    })
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
