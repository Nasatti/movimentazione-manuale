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
            <h1 class="text-center">Movimentazione Manuale dei Carichi</h1>
        </div>
        <div class="center_form">
            <form method='POST' class="form" action='index.php'>
                <h1>Login<button type="button" data-bs-toggle="modal" data-bs-target="#info_modal" style="font-size:20px;background-color:transparent;border:0px">ℹ️</button></h1>
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
                $_SESSION['id_utente']=$data['id'];
                $_SESSION['nome']=$data['nome'];
                $_SESSION['cognome']=$data['cognome'];
                $_SESSION['username']=$data['username'];
                $_SESSION['password']=$data['password'];
                $_SESSION['ruolo']=$data['ruolo'];
                header('Location: dashboard.php');
            }
            else {
                header('Location: index.php?error=credenziali');
            }
        }
        if(isset($_GET['error'])){
            if ($_GET['error'] == 'credenziali') {
                echo '<div class="alert alert-danger" role="alert">Credenziali sbagliate!</div>';
            }
            elseif($_GET['error'] == 'accesso') {
                echo "<div class='alert alert-danger' role='alert'>Eseguire l'accesso!</div>";
            }
        }
        
        ?>
        </div>
        <div class="modal fade" id="info_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Informazioni</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color:transparent;border:0px">❌</button>
              </div>
              <div class="modal-body text-center">
                Benvetuto nel sistema di Movimentazione Manuale dei Carichi. <br>
                Per accedere al sistema inserisci le tue credenziali e clicca su Sign in. <br>
                Se non hai ancora un account contatta l'amministratore.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>