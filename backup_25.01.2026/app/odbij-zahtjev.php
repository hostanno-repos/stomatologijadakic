<?php 
include_once("../connection.php");

if(isset($_GET['odbijZahtjev'])){
    $odbijZahtjev = $_GET['odbijZahtjev'];
    $query = $pdo->prepare('UPDATE termini SET termini_status = "Odbijen" WHERE termini_id = '.$odbijZahtjev);
    $query->execute();
    header('Location: zahtjevi-termini.php'); 
}

?>