<?php
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 14);
$pdf->Write(0, '¡TCPDF funciona correctamente!');
$pdf->Output('ejemplo.pdf', 'I');
?>
