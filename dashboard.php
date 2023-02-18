<?php 
session_start();
if($_SESSION['ruolo']!="1") header("Location: user.php");
if(isset($_POST['nome'])){
  include("connection.php");
  if($_SESSION['ruolo']=="Lettura") $ruolo=0;
  else $ruolo=1;
  $sql = "INSERT INTO credenziali (nome, cognome, username, password, ruolo) VALUES ('".$_POST['nome']."','".$_POST['cognome']."','".$_POST['username']."','".hash("sha512",$_POST['password'],false)."','".$ruolo."')";
  if ($connection->query($sql)) echo "<script>alert('Utente aggiunto!')</script>";
  else echo "<script>alert('Operazione non riuscita!')</script>";
}
if(isset($_POST['cliente'])){
  $ps=$_POST['peso']/$_POST['peso_max'];
  $sql = "INSERT INTO valutazione (id_operatore, cliente, data, h_terra, dist_verticale, dist_orizzontale, disl_angolare, giudizio, peso, frequenza, prezzo, peso_max, sollevamento) VALUES ('".$_SESSION['id_utente']."','".$_POST['cliente']."','".$_POST['data']."','".$_POST['h_terra']."','".$_POST['dist_verticale']."','".$_POST['dist_orizzontale']."','".$_POST['disl_angolare']."','".$_POST['giudizio']."','".$_POST['peso']."','".$_POST['frequenza']."','".$_POST['prezzo']."','".$_POST['peso_max']."','".$ps."')";
  if ($connection->query($sql)) echo "<script>alert('valutazione aggiunto!')</script>";
  else echo "<script>alert('Operazione non riuscita!')</script>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Admin</title>
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
                <button id="view" class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_user">Aggiungi utente</button>
                <button id="create" class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#create_modal">Nuova valutazione</button>
                <a href="index.php"><button type="button" class="btn btn-outline-danger">Logout</button></a>
            </div>
            <div class="body">
              <div id="div_view">
                <table class="table-bordered border-primary text-center">
                  <tr>
                    <th class="border-primary">ID</th>
                    <th class="border-primary">Ragione sociale</th>
                    <th class="border-primary">Data</th>
                    <th class="border-primary">Peso realmente sollevato</th>
                    <th class="border-primary">Altezza da terra delle mani</th>
                    <th class="border-primary">Distanza verticale di spostamento</th>
                    <th class="border-primary">Distanza orizzontale</th>
                    <th class="border-primary">Dislocazione angolare</th>
                    <th class="border-primary">Giudizio</th>
                    <th class="border-primary">Peso massimo consentito</th>
                    <th class="border-primary">Indice sollevamento</th>
                    <th class="border-primary">Frequenza gesti</th>
                    <th class="border-primary">Prezzo</th>
                  </tr>
                    <?php
                    //mostra valutazioni 
                    ?>
                  </tr>
                </table>
              </div>
              <div class="div_create">
              <div class="modal fade" id="create_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Nuova valutazione</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form_create" action="dashboard.php" method="POST">
                    <div class="modal-body">
                        <label>Ragione sociale</label>
                        <input class="form-control my-2" type="text" name="cliente" required>
                        <label>Data di emissione</label>
                        <input class="form-control my-2" type="date" name="data" required>
                        <label>Peso reale(kg)</label>
                        <input class="form-control my-2" type="number" name="peso" required>
                        <label>Altezza da terra delle mani all'inizio del sollevamento(cm)</label>
                        <select class="form-control my-2" name="h_terra" id="h_terra" required>
                          <option>0</option>
                          <option>25</option>
                          <option>50</option>
                          <option>75</option>
                          <option>100</option>
                          <option>125</option>
                          <option>150</option>
                          <option>>175</option>
                        </select>
                        <label>Distanza verticale di spostamento del peso fra inizio e fine sollevamento(cm)</label>
                        <select class="form-control my-2" name="dist_verticale" id="dist_verticale" required>
                          <option>25</option>
                          <option>50</option>
                          <option>75</option>
                          <option>100</option>
                          <option>125</option>
                          <option>150</option>
                          <option>>175</option>
                        </select>
                        <label>Distanza orizzontale tra mani e punto di mezzo delle caviglie(cm)</label>
                        <select class="form-control my-2" name="dist_orizzontale" id="dist_orizzontale" required>
                          <option>25</option>
                          <option>50</option>
                          <option>75</option>
                          <option>100</option>
                          <option>125</option>
                          <option>150</option>
                          <option>>175</option>
                        </select>
                        <label>Dislocazione angolare del peso in gradi(°)</label>
                        <select class="form-control my-2" name="disl_angolare" id="disl_angolare" required>
                          <option>0</option>
                          <option>30</option>
                          <option>60</option>
                          <option>90</option>
                          <option>120</option>
                          <option>135</option>
                          <option>>135</option>
                        </select>
                        <label>Giudizio sulla presa del carico</label>
                        <select class="form-control my-2" name="giudizio" id="giud" required>
                          <option>Buono</option>
                          <option>Scarso</option>
                        </select>
                        <label>Peso massimo consentito</label>
                        <input class="form-control my-2" type="number" name="peso_max" required>
                        <label>Frequenza dei gesti</label>
                        <input class="form-control my-2" type="number" name="frequenza" required>
                        <label>Prezzo(€)</label>
                        <input class="form-control my-2" type="number" name="prezzo" required>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submyt" class="btn btn-primary">Send</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              </div>
              <div class="div_add">
              <div class="modal fade" id="add_user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Nuova valutazione</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form_create" action="dashboard.php" method="POST">
                    <div class="modal-body">
                        <label>Nome</label>
                        <input class="form-control my-2" type="text" name="nome" required>
                        <label>Cognome</label>
                        <input class="form-control my-2" type="text" name="cognome"required>
                        <label>Username</label>
                        <input class="form-control my-2" type="text" name="username" required>
                        <label>Password</label>
                        <input class="form-control my-2" type="text" name="password" required>
                        <label>Ruolo</label>
                        <select class="form-control my-2" name="ruolo" id="ruolo" required>
                          <option>Lettura</option>
                          <option>Lettura e scrittura</option>
                        </select>
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submyt" class="btn btn-primary">Send</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              </div>
            </div>
        </div>   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>

