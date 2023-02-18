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
        <title>Dashhboard</title>
    </head>
    <body>
        <div class="p-3 mb-2 bg-primary text-white">
            <h1 class="text-center">Movimentazione Manuale dei Carichi</h1>
        </div>
        <div class="contenitore">
            <div class="left">
            <button type="button" class="btn btn-primary" style="border:none; background:transparent;color:black" data-bs-toggle="modal" data-bs-target="#exampleModal"><h4><?php echo $_SESSION["nome"]." ".$_SESSION["cognome"] ?></h4></button>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo $_SESSION["nome"]." ".$_SESSION["cognome"] ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
            echo "<h6>Nome: ".$_SESSION["nome"]."</h6>";
            echo "<h6>Cogome: ".$_SESSION["cognome"]."</h6>";
            echo "<h6>Username: ".$_SESSION["username"]."</h6>";
            if($_SESSION['ruolo'] == 1) echo "<h6>Ruolo: Lettura e Scrittura</h6>";
            else echo "<h6>Ruolo: Lettura e Scrittura</h6>";
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
            </div>
            <div class="right">
                <button class="btn btn-outline-primary" type="button">Visualizza valutazioni</button>
                <button class="btn btn-outline-primary" type="button">Nuova valutazione</button>
            </div>
        </div>   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>