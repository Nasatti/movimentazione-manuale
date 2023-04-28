require("pdf/fpdf.php");
  $pdf=new FPDF();
//setto l'autore, il creatore e il soggetto del pdf
$pdf->SetAuthor($_SESSION['nome'], true);
$pdf->SetCreator($_SESSION['cognome'], true);
$pdf->SetSubject($_POST['cliente'], true);

//setto i margini sinistro, superiore e destro
$margine_sx=20;
$margine_top=15;
$margine_dx=20;
$pdf->SetMargins($margine_sx, $margine_top, $margine_dx);
$pdf->SetFont('Times');

$pdf->Cell(100, 5, "Questo è un testo di prova", 1, 0);


//crea il file temporaneo con permessi 0600, ovvero scrittura/lettura solo dal mio sito (gli utenti esterni non possono accedervi)
$dir="pdf_tmp/";
$file = basename(tempnam($dir, 'tmp'));

//percorso + file temporaneo
$dir_file=$dir."".$file;

//rinomino il file temporaneo con l'estensione .pdf
rename($dir_file, $dir_file.'.pdf');
$file.= '.pdf';

//percorso + file rinominato in pdf
$dir_file2=$dir."".$file;

//salva il contenuto voluto nel file appena rinominato
$pdf->Output($dir_file2, 'F');

//cambio i permessi del file creato
chmod($dir_file2, 0755);

//Reindirizzamento
header('Location: '.$dir_file2);