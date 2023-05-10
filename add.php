<?php
session_start();
$_SESSION['add']=1;

if(isset($_POST['cliente']) && $_SESSION['add'] == 1){ 
  $_SESSION['add']=0;
  require("add_valutazione.php");
  header("Location: dashboard.php");
}
else{
  echo "no";
}

?>