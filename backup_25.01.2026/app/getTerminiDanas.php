<?php 

    include_once('../connection.php');
    include_once('class/kartoni.php');
    include_once('class/users.php');

    class todayTermini {
        public function fetch_all() {
            $datum = $_GET['datum'];
            global $pdo;
            $query = $pdo->prepare("SELECT * FROM termini WHERE termini_status = 'Zakazan' AND termini_datum = '".$datum."' ORDER BY termini_datum, termini_vrijeme ASC");
            $query->execute();
            return $query->fetchAll();
        }
    }
    $terminiDanas = new todayTermini;
    $terminiDanas = $terminiDanas->fetch_all();



    $svi_termini = array();

    foreach($terminiDanas as $terminiDanas_){
        $array_temp = array();
        $array_temp["termini_id"]=$terminiDanas_['termini_id'];

        $pacijent = new singleKarton;
        $pacijent = $pacijent->fetch_single_karton($terminiDanas_['termini_idpacijenta']);

        $array_temp["termini_idpacijenta"]=$terminiDanas_['termini_idpacijenta'];

        $array_temp["termini_pacijent"]=$pacijent['kartonipacijenata_ime']." ".$pacijent['kartonipacijenata_prezime'];

        $doktor = new singleUser;
        $doktor = $doktor->fetch_single_user($terminiDanas_['termini_iddoktora']);

        $array_temp["termini_doktor"]=$doktor['user_ime']." ".$doktor['user_prezime'];

        $array_temp["termini_datum"]=$terminiDanas_['termini_datum'];

        $array_temp["termini_vrijeme"]=$terminiDanas_['termini_vrijeme'];

        $array_temp["termini_napomena"]=$terminiDanas_['termini_napomena'];

        $array_temp["termini_status"]=$terminiDanas_['termini_status'];

        $array_temp["termini_autor"]=$terminiDanas_['termini_autor'];

        $array_temp["termini_timestamp"]=$terminiDanas_['termini_timestamp'];
     
        array_push($svi_termini, $array_temp);
    }
    echo json_encode($svi_termini, JSON_UNESCAPED_UNICODE);

?>