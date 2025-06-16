<?php
require_once('tcpdf/tcpdf.php');
require_once('conexionapr.php');

// Evitar cualquier salida antes de generar el PDF
ob_clean(); // Limpiar el buffer de salida si existe

class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-45);
        $image_file = "C:/xampp/htdocs/APRNONTUELA_PRACTICA/APR NONTUELA.png";
        if (file_exists($image_file)) {
            $this->Image($image_file, 80, $this->GetY(), 40, '', 'PNG');
        } else {
            $this->Cell(0, 8, 'Logo no encontrado', 0, 1, 'C');
        }
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 7);
        $this->Cell(0, 20, 'VENTA AGUA A GRANEL APR NONTUELA', 0, 0, 'C');
    }
}

// Verificar si se seleccionaron clientes por POST
if (isset($_POST['clientes_seleccionados']) && !empty($_POST['clientes_seleccionados'])) {
    $clientes_seleccionados = $_POST['clientes_seleccionados'];

    // Sanitizar los RUTs y preparar la consulta IN
    $clientes_limpios = array_map(function($rut) use ($conexion) {
        return "'" . mysqli_real_escape_string($conexion, $rut) . "'"; 
    }, $clientes_seleccionados);

    $lista_ruts = implode(',', $clientes_limpios);

    // Crear la consulta SQL con los RUTs seleccionados
    $consulta = "SELECT * FROM clientes WHERE Rut IN ($lista_ruts) ORDER BY Nombre ASC";
    $resultado = mysqli_query($conexion, $consulta);

    if (!$resultado || mysqli_num_rows($resultado) == 0) {
        die("No se encontraron clientes.");
    }
} elseif (isset($_POST['seleccionar_todos']) && $_POST['seleccionar_todos'] == 'todos') {
    // Si el botón "Seleccionar Todos" es presionado
    $consulta = "SELECT * FROM clientes ORDER BY Nombre ASC";
    $resultado = mysqli_query($conexion, $consulta);
    
    if (!$resultado || mysqli_num_rows($resultado) == 0) {
        die("No se encontraron clientes.");
    }
} else {
    die("No se seleccionaron clientes para generar el PDF.");
}

// Crear el PDF
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(12, 9, 12);
$pdf->SetAutoPageBreak(true, 50);
$pdf->AddPage();

// Título del PDF
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0, 5, 'Listado de Clientes APR Nontuela', 0, 1, 'C');
$pdf->Ln(1);

// Tabla
$tbl = '
<table border="1" cellpadding="5">
    <thead>
        <tr style="background-color:#f0f0f0;">
            <th><strong>RUT</strong></th>
            <th><strong>Nombre</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>Contacto</strong></th>
        </tr>
    </thead>
    <tbody>';

if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $tbl .= '
        <tr>
            <td>' . $fila['Rut'] . '</td>
            <td>' . $fila['Nombre'] . '</td>
            <td>' . $fila['Email'] . '</td>
            <td>' . $fila['Contacto'] . '</td>
        </tr>';
    }
} else {
    $tbl .= '
        <tr>
            <td colspan="4" align="center">No se encontraron clientes.</td>
        </tr>';
}

$tbl .= '</tbody></table>';

// Escribir el contenido de la tabla en el PDF
$pdf->writeHTML($tbl, true, false, true, false, '');

// Salida del PDF
$pdf->Output('clientes_apr_nontuela.pdf', 'I');
?>
