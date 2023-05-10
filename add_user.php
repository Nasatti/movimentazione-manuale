<?php
session_start();
include("connection.php");
if(!isset($_SESSION['username'])) header("Location: index.php?error=accesso");
if(isset($_POST['nome'])){
  if($_POST['ruolo_ut']=="Lettura") $ruolo=0;
  else $ruolo=1;
  $sql = "INSERT INTO credenziali (nome, cognome, username, password, ruolo) VALUES ('".$_POST['nome']."','".$_POST['cognome']."','".$_POST['username']."','".hash("sha512",$_POST['password'],false)."','".$ruolo."')";
  if ($connection->query($sql)) echo "<script>alert('Utente aggiunto!')</script>";
  else echo "<script>alert('Operazione non riuscita!')</script>";
}
header("Location: dashboard.php");
?>