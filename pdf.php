<?php
require('./pdf/fpdf.php');
include "connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID non specificato");
}

$sql = "SELECT * FROM valutazione WHERE id=$id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $user_id = $row['id_operatore'];
    $user_sql = "SELECT username FROM credenziali WHERE id = $user_id";
    $user_result = $connection->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $user_fullname = $user_row['username'];

    
$pdf = new FPDF();
$pdf->SetTitle('PDF_' . $row['cliente'] . '_' . $row['data']);
$pdf->SetAuthor('Creator');
$pdf->AddPage();
$pdf->SetFont('Arial','B',22);

$pdf->Cell(0, 20, 'Movimentazione manuale dei carichi', 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,10,'ID valutazione:',0,0);
$pdf->Cell(40,10,$row['id'],0,0);

$pdf->Ln();
$pdf->Cell(40,10,'Ragione sociale:',0,0);
$pdf->Cell(40,10,$row['cliente'],0,0);


$pdf->Ln();
$pdf->Cell(40,10,'Data:',0,0);
$pdf->Cell(40,10,$row['data'],0,0);

$pdf->Ln();
$pdf->Cell(40,10,'Redatto da:',0,0);
$pdf->Cell(40, 10, $user_fullname, 0, 0);

    $pdf->Ln(15);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Dettagli valutazione:', 0, 1, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',12,);

    $descrizioni = array(
        'Peso effettivo: '.$row['peso'].' Kg',
        'Altezza iniziale: '.$row['h_terra'].' cm',
        'Distanza verticale: '.$row['dist_verticale'].' cm',
        'Distanza orizzontale: '.$row['dist_orizzontale'].' cm',
        'Dislocazione angolare: '.$row['disl_angolare'].' gradi',
        'Presa: '.$row['giudizio'],
        'Frequenza '.$row['frequenza'].' (al minuto)',
        'Valido: '.$row['valido'],
        'Peso raccomandato: '.$row['peso_max'].' Kg',
        'Indice sollevamento: '.$row['idx_sollevamento'],
        'Prezzo: '.$row['prezzo'].' euro'
    );
$max_rows = 11;
$col_width = $pdf->GetPageWidth() / 2 - 5;
$row_height = 10;

for($row = 0; $row < $max_rows; $row++){
    //$pdf->Ln();
    $pdf->Cell(0,10,$descrizioni[$row],1,1,'C');
    $pdf->SetFillColor(200, 230, 255);
}
$pdf->Ln();
$idx=explode(' ', $descrizioni[9]);
if($idx[2] == -1){
    $pdf->SetFillColor(204, 51, 0);
    $pdf->Cell(190, 20, "Impossibile calcolare l'indice, il peso massimo risulta uguale a 0 kg", 1, 1, 'C', true);
} else if ($idx[2] <= 0.85) {
    $pdf->SetFillColor(0, 204, 1);
    $pdf->Cell(190, 20, "Situazione accettabile", 1, 1, 'C', true);
} else if ($idx[2] <= 0.99) {
    $pdf->SetFillColor(255, 153, 0);
    $pdf->Cell(190, 20, "Attenzione! Attivare la sorveglianza sanitaria formazione e informazione del personale", 1, 1, 'C', true);
} else {
    $pdf->SetFillColor(204, 51, 0);
    $pdf->Cell(190, 20, "Rischio! Eseguire interventi di prevenzione e attivare sorveglianza sanitaria annuale", 1, 1, 'C', true);
}
$pdf->Output();
}
?>