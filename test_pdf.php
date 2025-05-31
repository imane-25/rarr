<?php
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 14);
$pdf->Write(0, '✅ TCPDF fonctionne parfaitement !');
$pdf->Output('test.pdf', 'I');
