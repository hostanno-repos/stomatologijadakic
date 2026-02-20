<?php 

include_once("../connection.php");

if(isset($_GET['zakaziTermin'])){
    $zakaziTermin = $_GET['zakaziTermin'];
    $query = $pdo->prepare('UPDATE termini SET termini_status = "Zakazan" WHERE termini_id = '.$zakaziTermin);
    $query->execute();
    header('Location: admin.php'); 
}

?>