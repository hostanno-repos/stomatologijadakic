<?php 

include_once("../connection.php");

if(isset($_GET['idtermina'])){
    $potvrdiDolazak = $_GET['idtermina'];
    $query = $pdo->prepare('UPDATE termini SET termini_status = "Propušten" WHERE termini_id = '.$potvrdiDolazak);
    $query->execute();
    header('Location: admin.php'); 
}

?>