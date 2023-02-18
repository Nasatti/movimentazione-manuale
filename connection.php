<?php
        $ip = '127.0.0.1';
        $username = 'root';
        $pwd = '';
        $database ='mmc';
        $connection= new mysqli($ip, $username, $pwd, $database);
        if($connection->connect_error){
            die('c\è stato un errore: '.$connection->connect_error);
        }
?>