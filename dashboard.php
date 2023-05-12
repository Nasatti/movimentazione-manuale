<?php
session_start();
include("connection.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Dashboard</title>
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
                          if($_SESSION['ruolo'] == 1 || $_SESSION['ruolo'] == 2) echo "<h6>Ruolo: Lettura e Scrittura</h6>";
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
                <?php 
                if($_SESSION['ruolo'] =="1" || $_SESSION['ruolo'] =="2"){
                  if($_SESSION['ruolo'] =="2")echo '<button id="view" class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_user">Aggiungi utente</button>';
                  echo '<button id="create" class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#create_modal">Nuova valutazione</button>';
                }
                ?>
                <a href="index.php"><button type="button" class="btn btn-outline-danger">Logout</button></a>
            </div>
            <div class="body">
              <div id="div_view">
                <table class="table-bordered border-dark text-center" style="width:100%">
                  <tr>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">ID</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Autore</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Ragione sociale</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Data</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Peso realmente sollevato(kg)</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Peso limite raccomandato(kg)</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Indice sollevamento</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Prezzo</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">PDF</th>
                    <th class="border-dark text-dark" style="background-color:#BCD2FF">Validità</th>
                    <?php
                    if($_SESSION['ruolo'] != 0){
                    echo'<th class="border-dark text-dark" style="background-color:#BCD2FF">Modifica</th>';
                    echo'<th class="border-dark text-dark" style="background-color:#BCD2FF">Elimina</th>';
                    }
                    ?>
                  </tr>
                    <?php
                    $sql = "SELECT id, id_operatore, cliente, data, peso, prezzo, idx_sollevamento, peso_max, valido FROM valutazione";
                    $result = $connection->query($sql);
                        if($result->num_rows >0){
                          $array = [];
                            while($row = $result->fetch_assoc()){
                                if(!in_array($row, $array)){
                                    array_push($array, $row);
                                }
                            }
                            $i = 0;
                            $ar_id = array();
                            foreach($array as $ar){
                              $sql="SELECT `username` FROM `credenziali` WHERE `id` = ".$ar['id_operatore'];
                              $result = $connection->query($sql);
                              if($result->num_rows >0){
                                $data = $result->fetch_array();
                                  $username = $data['username'];
                              }
                              if($_SESSION['ruolo'] == 2){
                                echo "<tr>";
                                echo '<td class="border-dark text-dark">'.$ar['id'].'</td>';
                                echo '<td class="border-dark text-dark">'.$username.'</td>';
                                echo '<td class="border-dark text-dark">'.$ar['cliente'].'</td>';
                                echo '<td class="border-dark text-dark">'.$ar['data'].'</td>';
                                echo '<td class="border-dark text-dark">'.$ar['peso'].'</td>';
                                if($ar['peso_max'] == -1) echo '<td class="border-dark text-dark" style="color:red">Non calcolabile</td>';
                                else echo '<td class="border-dark text-dark">'.$ar['peso_max'].'</td>';
                                if($ar['idx_sollevamento'] == -1)echo '<td class="border-dark text-dark" style="color:red">Non calcolabile</td>';
                                elseif($ar['idx_sollevamento']<= 0.85)echo '<td class="border-dark" style="color:green">'.$ar['idx_sollevamento'].'</td>';
                                elseif($ar['idx_sollevamento']> 0.85 && $ar['idx_sollevamento']<= 0.99)echo '<td class="border-dark" style="color:#e3b007">'.$ar['idx_sollevamento'].'</td>';
                                elseif($ar['idx_sollevamento']> 0.99)echo '<td class="border-dark" style="color:red">'.$ar['idx_sollevamento'].'</td>';
                                echo '<td class="border-dark text-dark">'.$ar['prezzo'].'€</td>';
                                echo '<td class="border-dark text-dark"><a href="pdf.php?id='.$ar['id'].'"><img height="25px" width="25px" src="./img/pdf.png"></a></td>';
                                if($ar['valido']) echo '<td class="border-dark text-dark"><img height="25px" width="25px" src="./img/valido.png"></td>';
                                else echo '<td class="border-dark text-dark"><img height="25px" width="25px" src="./img/non_valido.png"></td>';
                                echo '<td class="border-dark text-dark"><button id="Modifica'.$i.'" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="border:none;background-color:transparent"><img height="25px" width="25px" src="./img/modifica.png"></button></td>';
                                echo '<td class="border-dark text-dark"><button id="Elimina'.$i.'" style="border:none;background-color:transparent"><img height="25px" width="25px" src="./img/elimina.png"></button></td>';
                                echo "</tr>";
                              }
                              elseif($_SESSION['ruolo'] == 1){
                                if($ar['id_operatore'] == $_SESSION['id_utente']){
                                  echo "<tr>";
                                  echo '<td class="border-dark text-dark">'.$ar['id'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$username.'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['cliente'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['data'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['peso'].'</td>';
                                  if($ar['peso_max'] == -1) echo '<td class="border-dark text-dark" style="color:red">Non calcolabile</td>';
                                  else echo '<td class="border-dark text-dark">'.$ar['peso_max'].'</td>';
                                  if($ar['idx_sollevamento'] == -1)echo '<td class="border-dark text-dark" style="color:red">Non calcolabile</td>';
                                  elseif($ar['idx_sollevamento'] > 0.99 && $ar['idx_sollevamento'] == -1)echo '<td class="border-dark" style="color:red">'.$ar['idx_sollevamento'].'</td>';  
                                  elseif($ar['idx_sollevamento'] > 0.85 && $ar['idx_sollevamento']<= 0.99)echo '<td class="border-dark" style="color:#e3b007">'.$ar['idx_sollevamento'].'</td>';
                                  elseif($ar['idx_sollevamento'] <= 0.85 )echo '<td class="border-dark" style="color:green">'.$ar['idx_sollevamento'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['prezzo'].'€</td>';
                                  echo '<td class="border-dark text-dark"><a href="pdf.php?id='.$ar['id'].'"><img height="25px" width="25px" src="./img/pdf.png"></a></td>';
                                  if($ar['valido']) echo '<td class="border-dark text-dark"><img height="25px" width="25px" src="./img/valido.png"></td>';
                                  else echo '<td class="border-dark text-dark"><img height="25px" width="25px" src="./img/non_valido.png"></td>';
                                  echo '<td class="border-dark text-dark"><button id="Modifica'.$i.'" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="border:none;background-color:transparent"><img height="25px" width="25px" src="./img/modifica.png"></button></td>';
                                  echo '<td class="border-dark text-dark"><button id="Elimina'.$i.'" style="border:none;background-color:transparent"><img height="25px" width="25px" src="./img/elimina.png"></button></td>';
                                  echo "</tr>";
                                }
                              }
                              elseif($_SESSION['ruolo'] == 0){
                                if($ar['cliente'] == $_SESSION['username']){
                                  echo "<tr>";
                                  echo '<td class="border-dark text-dark">'.$ar['id'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$username.'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['cliente'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['data'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['peso'].'</td>';
                                  if($ar['peso_max'] == -1) echo '<td class="border-dark text-dark" style="color:red">Non calcolabile</td>';
                                  else echo '<td class="border-dark text-dark">'.$ar['peso_max'].'</td>';
                                  if($ar['idx_sollevamento'] == -1)echo '<td class="border-dark text-dark" style="color:red">Non calcolabile</td>';
                                  elseif($ar['idx_sollevamento']<= 0.85)echo '<td class="border-dark" style="color:green">'.$ar['idx_sollevamento'].'</td>';
                                  elseif($ar['idx_sollevamento']> 0.85 && $ar['idx_sollevamento']<= 0.99)echo '<td class="border-dark" style="color:#e3b007">'.$ar['idx_sollevamento'].'</td>';
                                  elseif($ar['idx_sollevamento']> 0.99)echo '<td class="border-dark" style="color:red">'.$ar['idx_sollevamento'].'</td>';
                                  echo '<td class="border-dark text-dark">'.$ar['prezzo'].'€</td>';
                                  echo '<td class="border-dark text-dark"><a href="pdf.php?id='.$ar['id'].'"><img height="25px" width="25px" src="./img/pdf.png"></a></td>';
                                  if($ar['valido']) echo '<td class="border-dark text-dark"><img height="25px" width="25px" src="./img/valido.png"></td>';
                                  else echo '<td class="border-dark text-dark"><img height="25px" width="25px" src="./img/non_valido.png"></td>';
                                  echo "</tr>";
                                }
                              }
                              array_push($ar_id, $ar['id']);
                              echo "<script>document.getElementById('Modifica$i').onclick = function () {  mod_id =".$ar_id[$i].";Compila_modifica()};</script>";
                              echo "<script>document.getElementById('Elimina$i').onclick = function () {  mod_id =".$ar_id[$i].";Elimina()};</script>";
                              $i++;
                            }

                        }
                    ?>
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
                    <form class="form_create" action="add.php" method="POST">
                    <div class="modal-body">
                        <label>Ragione sociale</label>
                        <input class="form-control my-2" type="text" name="cliente" required>
                        <label>Data di emissione</label>
                        <input class="form-control my-2" type="date" name="data" required>
                        <label>Peso reale(kg)</label>
                        <input class="form-control my-2" type="number" name="peso" required>
                        <label>Altezza da terra delle mani all'inizio del sollevamento(cm)</label>
                        <select class="form-control my-2" name="h_terr" id="h_terr" required>
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
                          <option>30</option>
                          <option>40</option>
                          <option>50</option>
                          <option>55</option>
                          <option>60</option>
                          <option>>63</option>
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
                        <label>Frequenza dei gesti</label>
                        <select class="form-control my-2" name="frequenza" id="disl_angolare" required>
                          <option>0.20</option>
                          <option>1</option>
                          <option>4</option>
                          <option>6</option>
                          <option>9</option>
                          <option>12</option>
                          <option>>15</option>
                        </select>
                        <label>Durata</label>
                        <select class="form-control my-2" name="durata" id="disl_angolare" required>
                          <option>< 1 ora</option>
                          <option>da 1 a 2 ore</option>
                          <option>da 2 a 8 ore</option>
                        </select>
                        <label>Prezzo(€)</label>
                        <input class="form-control my-2" type="number" name="prezzo" required>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Send">
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
                      <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Nuovo Utente</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form_create" action="add_user.php" method="POST">
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
                        <select class="form-control my-2" name="ruolo_ut" id="ruolo" required>
                          <option>Lettura</option>
                          <option>Lettura e scrittura</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              </div>
            </div>
        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">    
            <div class="modal-content">      
              <div class="modal-header">        
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modifica</h1>        
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>      
              </div>      
              <div class="modal-body">                    
                <form class="form_create" action="modifica.php" method="POST">
                  <div class="modal-body">
                    <input name='id' id="id_c" hidden value="">
                        <label>Ragione sociale</label>    
                        <input class="form-control my-2" type="text" name="cliente"  id="cliente" value="aa" required>    
                        <label>Data di emissione</label>    
                        <input class="form-control my-2" type="date" name="data" id="data" required>    
                        <label>Peso reale(kg)</label>    <input class="form-control my-2" type="number" name="peso" id="peso" required>
                            <label>Altezza da terra delle mani all inizio del sollevamento(cm)</label>    
                            <select class="form-control my-2" name="h_terr" id="h_terr" required>
                                    <option value="0">0</option>
                                    <option value="25">25</option>      
                                    <option value="50">50</option>      
                                    <option value="75">75</option>      
                                    <option value="100">100</option>      
                                    <option value="125">125</option>      
                                    <option value="150">150</option>      
                                    <option value=">175">>175</option>    
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
                            <label>Frequenza dei gesti</label>    
                            <select class="form-control my-2" name="frequenza" id="disl_angolare" required>      
                              <option>0.20</option>      
                              <option>1</option>      
                              <option>4</option>      
                              <option>6</option>      
                              <option>9</option>      
                              <option>12</option>      
                              <option>>15</option>    
                            </select>    
                            <label>Durata</label>    
                            <select class="form-control my-2" name="durata" id="disl_angolare" required>      
                              <option>< 1 ora</option>      
                              <option>da 1 a 2 ore</option>      
                              <option>da 2 a 8 ore</option>    
                            </select>    
                            <label>Prezzo(€)</label>    
                            <input class="form-control my-2" type="number" name="prezzo" id="prezzo" required>
                          </div>
                          <div class="modal-footer">  
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" onclick="Modifica()">Send</button>
                            </div>
                          </form>
                        </div>    
                      </div>  
                    </div>
      </div>
        <script>
          function Compila_modifica(){
            $.ajax({
              url: "compila_modifica.php",
              data: {id: mod_id},
              type: "POST",
              dataType: "json",
              success: function(data){
                var dati = data
                $("#id_c").val(mod_id);
                $("#cliente").val(dati['cliente']);
                $("#data").val(dati['data']);
                $("#peso").val(dati['peso']);
                $("#h_terr").val(dati['h_terr']);
                $("#dist_verticale").val(dati['dist_verticale']);
                $("#dist_orizzontale").val(dati['dist_orizzontale']);
                $("#disl_angolare").val(dati['disl_angolare']);
                $("#giud").val(dati['giudizio']);
                $("#frequenza").val(dati['frequenza']);
                $("#durata").val(dati['durata']);
                $("#prezzo").val(dati['prezzo']);
              },
              error: function(){
                alert("Errore!")
              }
            })
          }
          function Elimina(){
            console.log(mod_id)
            $.ajax({
              url: "elimina.php",
              data: {id: mod_id},
              type: "POST",

              success: function(data){
                alert(data)
                <?php $_SESSION['add']=0; ?>
                location.reload()
              },
              error: function(data){
                alert("Errore!")
              }
            })
          }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      </body>
</html>