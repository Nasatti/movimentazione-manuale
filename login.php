<?php 
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Login</title>
    </head>
    <body>
    <div class="p-3 mb-2 bg-primary text-white">
            <h1 class="text-center">Login</h1>
        </div>
        <div class=center_form>
            <form method='POST' action='login.php'>
                <input type='text' name='us' placeholder='username' required >
                <input type='password' name='psw' placeholder='password' required>
                <input type='submit' class="btn btn-primary" value='Sign in'>
            </form>
        <?php
        include("connection.php");

        if(isset($_POST['us']) and isset($_POST['psw'])){
            $usern = $_POST['us'];
            $password = $_POST['psw'];
            $sql = 'SELECT * FROM credenziali WHERE username="'.$usern.'" AND password="'.hash("sha512",$password,false).'";';
            $response = $connection->query($sql);
            if ($response->num_rows > 0) {
                $data = $response->fetch_array();
                $_SESSION['id']=$data['id'];
                $_SESSION['nome']=$data['nome'];
                $_SESSION['cognome']=$data['cognome'];
                $_SESSION['username']=$data['username'];
                $_SESSION['password']=$data['password'];
                $_SESSION['ruolo']=$data['ruolo'];
                header('Location: dashboard.php');
            }
            else {
                header('Location: login.php?error=credenziali');
            }
        }
        if(isset($_GET['error'])){
            if ($_GET['error'] == 'credenziali') {
                echo '<div class="alert alert-danger" role="alert">Login incoretto!</div>';
            }
        }
        
        ?>
    </body>
</html>