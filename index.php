<?php 
session_start();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="script.js"></script>
        <title>MMC</title>
    </head>
    <body>
        <div class="p-3 mb-2 bg-primary text-white">
            <h1 class="text-center">Movimentazione Manuale dei Carichi</h1>
        </div>
        <div style="text-align:center">
            <a href="login.php"><button type="button"  class="btn btn-primary">Login</button></a>
        </div>
    </body>
</html>