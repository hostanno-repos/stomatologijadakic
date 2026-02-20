<?php 

include_once("../connection.php");

if(isset($_GET['prihvatiZahtjev'])){
    $prihvatiZahtjev = $_GET['prihvatiZahtjev'];
    $query = $pdo->prepare('UPDATE termini SET termini_status = "Zakazan" WHERE termini_id = '.$prihvatiZahtjev);
    $query->execute();
    header('Location: zahtjevi-termini.php'); 
}

?>