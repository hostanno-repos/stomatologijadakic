<?php

//GET ALL INTERVENCIJE FOR ONE PACIJENT
class allInterventions
{
    public function fetch_all_intervencije()
    {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM intervencije ORDER BY intervencije_timestamp DESC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL INTERVENCIJE FOR ONE PACIJENT
class myInterventions
{
    public function fetch_all($pacijentid)
    {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM intervencije WHERE intervencije_idpacijenta = ? ORDER BY intervencije_timestamp DESC");
        $query->bindValue(1, $pacijentid);
        $query->execute();
        return $query->fetchAll();
    }
}

//GET SINGLE TIP INTERVENCIJE BY ID
class tipIntervencije
{
    public function fetch_single_tip_intervencije($id)
    {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM tipoviintervencija WHERE tipoviintervencija_id = ?");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetch();
    }
}

//GET ALL TIPOVI INTERVENCIJA
class tipoviIntervencija
{
    public function fetch_all_tipovi_intervencija()
    {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM tipoviintervencija ORDER BY tipoviintervencija_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}


//EDIT INTERVENCIJE
if (isset($_GET['get_edit_tip_intervencije'])) {
    include_once ('../../connection.php');
    $get_edit_tip_intervencije = intval($_GET['get_edit_tip_intervencije']);
    class editTipoviIntervencija
    {
        public function fetch_edit_tip_intervencije($get_edit_tip_intervencije)
        {
            global $pdo;
            $query = $pdo->prepare("SELECT * FROM tipoviintervencija WHERE tipoviintervencija_id = ?");
            $query->bindValue(1, $get_edit_tip_intervencije);
            $query->execute();
            return $query->fetch();
        }
    }
    $intervencije_edit = new editTipoviIntervencija;
    $intervencija_edit = $intervencije_edit->fetch_edit_tip_intervencije($get_edit_tip_intervencije);
    echo "
    <div class='d-flex mb-2'>
        <!-- ID INTERVENCIJE -->
        <label class='mb-0 mr-0' for='tipoviintervencija_id'>ID tipa intervencije:</label>
        <input class='invisible-input' name='tipoviintervencija_id' type='text' value='$intervencija_edit[tipoviintervencija_id]' readonly>

    </div>
    <div class='d-flex'>
        <!-- NAZIV INTERVENCIJE -->
        <label class='mb-0 mr-2' for='tipoviintervencija_naziv'>Naziv: </label>
        <input name='tipoviintervencija_naziv' type='text' value='$intervencija_edit[tipoviintervencija_naziv]' placeholder='Tip intervencije...'>
    </div>
    ";
}
if (isset($_POST['submit_edit_tip_intervencije'])) {
    foreach ($_POST as $key => $value) {
        $$key = $value;
        $$key = str_replace('"', '\"', $$key);
    }
    $query = $pdo->prepare('UPDATE tipoviintervencija SET tipoviintervencija_naziv ="' . $tipoviintervencija_naziv . '" WHERE tipoviintervencija_id=' . $tipoviintervencija_id);
    $query->execute();
    header('Location: tipovi-intervencija.php');
}

//POVUCI SVE TIPOVE INTERVENCIJA


/***** DELETE *****/
if (isset($_GET['deleteTipIntervencije'])) {
    $deleteTipIntervencije = $_GET['deleteTipIntervencije'];
    $query = $pdo->prepare('DELETE FROM tipoviintervencija WHERE tipoviintervencija_id = ?');
    $query->bindValue(1, $deleteTipIntervencije);
    $query->execute();
    header('Location: tipovi-intervencija.php');
}

//POVUCI SVE TIPOVE INTERVENCIJEE
// class Intervencijee {
//     public function fetch_all() {
//         global $pdo;
//         $query = $pdo->prepare("SELECT * FROM intervencijee ORDER BY intervencijee_id ASC");
//         $query->execute();
//         return $query->fetchAll();
//     }
// }
// $intervencijee = new Intervencijee;
// $intervencijaa = $intervencijee->fetch_all();

?>