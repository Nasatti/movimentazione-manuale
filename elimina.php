<?php
session_start();
$_SESSION['add']=0;
include('connection.php');
$sql = "DELETE FROM valutazione WHERE id = '".$_POST['id']."';";
$result = $connection->query($sql);
if($result){
    echo "Eliminato!";
}
else{
    echo "Error";
}
?>