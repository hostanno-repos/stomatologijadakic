<?php 

//GET ALL RACUNI
class allRacuni {
    public function fetch_all_racuni() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM racuni ORDER BY racuni_id DESC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL RAČUNI FOR ONE PACIJENT
class mojiRacuni {
    public function fetch_all_moji_racuni($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM racuni WHERE racuni_idpacijenta = ? ORDER BY racuni_id DESC");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetchAll();
    }
}

//GET SINGLE RAČUN BY ID
class singleRacun {
    public function fetch_single_racun($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM racuni WHERE racuni_id = ?");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetch();
    }
}

/***** DELETE *****/
if(isset($_GET['deleteRacun'])){
    $racun_id = $_GET['deleteRacun'];
    $query = $pdo->prepare('DELETE FROM racuni WHERE racuni_id = ?');
    $query->bindValue(1, $racun_id);
    $query->execute();
    header('Location: pregled-racuna.php');
}

?>