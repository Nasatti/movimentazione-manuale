<?php
include('connection.php');
$sql = "SELECT * FROM valutazione WHERE id = '".$_POST['id']."';";
$result = $connection->query($sql);
if($result->num_rows > 0){
    $data = $result->fetch_array(); 
    echo json_encode($data);
}
?>