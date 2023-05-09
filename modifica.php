<?php
include("connection.php");
$sql = "UPDATE valutazione SET cliente='".$_POST['cliente']."', data='".$_POST['data']."', h_terra='".$_POST['h_terr']."', dist_verticale='".$_POST['dist_verticale']."', dist_orizzontale='".$_POST['dist_orizzontale']."', disl_angolare='".$_POST['disl_angolare']."', giudizio='".$_POST['giudizio']."', peso='".$_POST['peso']."', frequenza='".$_POST['frequenza']."', prezzo='".$_POST['prezzo']."' WHERE id=".$_POST['id'].";";
if ($connection->query($sql) === TRUE) {
    echo "Aggiornato!";
} else {
    echo "Errore!";
}
?>