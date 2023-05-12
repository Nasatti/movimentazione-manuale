<?php
session_start();
include("connection.php");
include("calcolo.php");
$sql = "INSERT INTO valutazione (id_operatore, cliente, data, h_terra, dist_verticale, dist_orizzontale, disl_angolare, giudizio, peso, frequenza, prezzo, peso_max, idx_sollevamento, valido) VALUES ('".$_SESSION['id_utente']."','".$_POST['cliente']."','".$_POST['data']."','".$_POST['h_terr']."','".$_POST['dist_verticale']."','".$_POST['dist_orizzontale']."','".$_POST['disl_angolare']."','".$_POST['giudizio']."','".$_POST['peso']."','".$_POST['frequenza']."','".$_POST['prezzo']."','".$ps."','".$idx."', 1)";
if ($connection->query($sql)) echo "<script>alert('valutazione aggiunto!')</script>";
else echo "<script>alert('Operazione non riuscita!Riprova')</script>";
header("dashboard.php");
?>