<?php
$h_terr = $_POST['h_terr'];
$dist_verticale = $_POST['dist_verticale'];
$dist_orizzontale = $_POST['dist_orizzontale'];
$disl_angolare = $_POST['disl_angolare'];
$giudizio = $_POST['giudizio'];
$freq = $_POST['frequenza'];
$cp=20;
switch($_POST['durata']){
    case '< 1 ora':
        $h=1;
        break;
    case 'da 1 a 2 ore':
        $h=2;
        break;
    case 'da 2 a 8 ore':
        $h=3;
        break;
}
switch($h_terr){
    case 0:
        $a=0.77;
        break;
    case 25:
        $a=0.85;
        break;
    case 50:
        $a=0.93;
        break;
    case 75:
        $a=1;
        break;
    case 100:
        $a=0.93;
        break;
    case 125:
        $a=0.85;
        break;
    case 150:
        $a=0.78;
        break;
    case ">175":
        $a=0;
        break;
}
switch($dist_verticale){
    case 25:
        $b=1;
        break;
    case 30:
        $b=0.97;
        break;
    case 40:
        $b=0.93;
        break;
    case 50:
        $b=0.91;
        break;
    case 70:
        $b=0.88;
        break;
    case 100:
        $b=0.87;
        break;
    case 150:
        $b=0.86;
        break;
    case ">175":
        $a=0;
        break;
}
switch($dist_orizzontale){
    case 25:
        $c=1;
        break;
    case 30:
        $c=0.83;
        break;
    case 40:
        $c=0.63;
        break;
    case 50:
        $c=0.50;
        break;
    case 55:
        $c=0.45;
        break;
    case 60:
        $c=0.42;
        break;
    case ">63":
        $a=0;
        break;
}
switch($disl_angolare){
    case 0:
        $d=1;
        break;
    case 30:
        $d=0.9;
        break;
    case 60:
        $d=0.81;
        break;
    case 90:
        $d=0.71;
        break;
    case 120:
        $d=0.52;
        break;
    case 135:
        $d=0.57;
        break;
    case ">135":
        $a=0;
        break;
}
switch($giudizio){
    case "Buono":
        $e=1;
        break;
    case "Scarso":
        $e=0.9;
        break;
}
if($h = 1){
    switch($freq){
        case 0.20:
            $f=1;
            break;
        case 1:
            $f=0.94;
            break;
        case 4:
            $f=0.84;
            break;
        case 6:
            $f=0.75;
            break;
        case 9:
            $f=0.52;
            break;
        case 12:
            $f=0.37;
            break;
        case ">15":
            $f=0;
            break;
    }
}
elseif($h = 2){
    switch($freq){
        case 0.20:
            $f=0.95;
            break;
        case 1:
            $f=0.88;
            break;
        case 4:
            $f=0.72;
            break;
        case 6:
            $f=0.5;
            break;
        case 9:
            $f=0.3;
            break;
        case 12:
            $f=0.21;
            break;
        case ">15":
            $f=0;
            break;
    }
}
elseif($h = 3){
    switch($freq){
        case 0.20:
            $f=0.85;
            break;
        case 1:
            $f=0.75;
            break;
        case 4:
            $f=0.45;
            break;
        case 6:
            $f=0.27;
            break;
        case 9:
            $f=0.12;
            break;
        case 12:
            $f=0.08;
            break;
        case ">15":
            $f=0;
            break;
    }
}
$ps=$cp*$a*$b*$c*$d*$e*$f;
if($ps>0){
    include('connection.php');
    $idx = $_POST['peso']/$ps;
}else{
    $ps = -1;
    $idx = -1;
}
?>