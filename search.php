<?php
include("connection.php");
$sql = "SELECT * FROM valutazione WHERE cliente = '".$_POST['rag_soc']."'";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
}
else
echo json_encode("a");
?>