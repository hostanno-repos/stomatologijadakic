<?php 

//GET ALL RACUNI
class allRacuni {
    public function fetch_all_racuni() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM racuni ORDER BY racuni_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL RAČUNI FOR ONE PACIJENT
class mojiRacuni {
    public function fetch_all_moji_racuni($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM racuni WHERE racuni_idpacijenta = ? ORDER BY racuni_id ASC");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetchAll();
    }
}

?>