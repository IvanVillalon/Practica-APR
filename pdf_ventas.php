<?php
require_once('tcpdf/tcpdf.php');
require_once('conexionapr.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifica si se seleccionaron todas las ventas o si se seleccionaron ventas específicas
    if (isset($_POST['seleccionar_todos']) && $_POST['seleccionar_todos'] == 'todos') {
        // Obtener todas las ventas sin filtros
        $consulta = "SELECT * FROM ventas ORDER BY fecha_venta DESC";
    } else if (!empty($_POST['ventas_seleccionadas'])) {
        // Si se seleccionaron ventas específicas
        $ventas_ids = $_POST['ventas_seleccionadas'];
        $ids_str = implode(",", array_map('intval', $ventas_ids));
        $consulta = "SELECT * FROM ventas WHERE id IN ($ids_str) ORDER BY fecha_venta DESC";
    } else {
        echo "No se seleccionaron ventas para generar el PDF.";
        exit();
    }

    $resultado = mysqli_query($conexion, $consulta);

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

    $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetMargins(12, 9, 12);
    $pdf->SetAutoPageBreak(true, 50);
    $pdf->AddPage();

    // Título dinámico dependiendo de la fuente de los datos
    $pdf->SetFont('helvetica', 'B', 15);
    if (isset($_POST['seleccionar_todos']) && $_POST['seleccionar_todos'] == 'todos') {
        $pdf->Cell(0, 13, 'Todas las Ventas - APR Nontuela', 0, 1, 'C');
    } else {
        $pdf->Cell(0, 13, 'Ventas Seleccionadas - APR Nontuela', 0, 1, 'C');
    }
    $pdf->Ln(1);

    // Configuración de la tabla
    $pdf->SetFont('helvetica', '', 6);
    $tbl_header = '
    <table border="1" cellpadding="3">
        <thead>
            <tr style="background-color:#f0f0f0;">
                <th width="5%"><strong>ID</strong></th>
                <th width="20%"><strong>Cliente</strong></th>
                <th width="12%"><strong>RUT</strong></th>
                <th width="10%"><strong>Metros³</strong></th>
                <th width="13%"><strong>Valor M³</strong></th>
                <th width="13%"><strong>Total</strong></th>
                <th width="17%"><strong>Fecha</strong></th>
                <th width="10%"><strong>Estado</strong></th>
            </tr>
        </thead>
        <tbody>';

    $tbl_body = '';

    // Si hay resultados de la consulta
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $tbl_body .= '
            <tr>
                <td width="5%">' . $fila['id'] . '</td>
                <td width="20%">' . htmlspecialchars($fila['nombre_cliente']) . '</td>
                <td width="12%">' . htmlspecialchars($fila['rut_cliente']) . '</td>
                <td width="10%">' . $fila['metros_cubicos'] . '</td>
                <td width="13%">$' . number_format($fila['valor_m3'], 0, ',', '.') . '</td>
                <td width="13%">$' . number_format($fila['total'], 0, ',', '.') . '</td>
                <td width="17%">' . date('d/m/Y H:i', strtotime($fila['fecha_venta'])) . '</td>
                <td width="10%">' . htmlspecialchars($fila['Estado']) . '</td>
            </tr>';
        }
    } else {
        $tbl_body .= '
            <tr>
                <td colspan="8" align="center">No se encontraron ventas.</td>
            </tr>';
    }

    $tbl_footer = '</tbody></table>';

    // Escribir el contenido HTML de la tabla
    $pdf->writeHTML($tbl_header . $tbl_body . $tbl_footer, true, false, true, false, '');

    // Salida del archivo PDF
    $pdf->Output('ventas_apr_nontuela.pdf', 'I');
} else {
    echo "No se seleccionaron ventas para generar el PDF.";
}
?>
