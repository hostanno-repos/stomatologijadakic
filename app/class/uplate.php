<?php 

//GET ALL UPLATE
class allUplate {
    public function fetch_all_uplate() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM uplate ORDER BY uplate_id DESC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL UPLATE FOR ONE RAČUN
class mojeUplate {
    public function fetch_all_moje_uplate($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM uplate WHERE uplate_idracuna = ? ORDER BY uplate_datum DESC");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetchAll();
    }
}

?>