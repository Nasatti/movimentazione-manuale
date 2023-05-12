<?php
session_start();
$_SESSION['add']=0;
include("connection.php");
include("calcolo.php");

$sql = "UPDATE valutazione SET valido='0' WHERE id=".$_POST['id'].";";
if ($connection->query($sql) === TRUE) {
    include("add_valutazione.php");
    echo "<script>alert('valutazione aggiunto!')</script>";
    header("Location: dashboard.php");
}
else echo "<script>alert('Operazione non riuscita!Riprova')</script>";
?>