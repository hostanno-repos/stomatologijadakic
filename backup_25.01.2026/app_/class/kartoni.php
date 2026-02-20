<?php 

//GET ALL KARTONI PACIJENATA
class kartoniPacijenata {
    public function fetch_all_kartonipacijenata() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM kartonipacijenata ORDER BY kartonipacijenata_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET SINGLE KARTON BY ID
class singleKarton {
    public function fetch_single_karton($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM kartonipacijenata WHERE kartonipacijenata_id = ?");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetch();
    }
}

//BRIŠI KARTON
if(isset($_GET['delete_kartonipacijenata'])){
    $karton_id = $_GET['delete_kartonipacijenata'];
    $query = $pdo->prepare('DELETE FROM kartonipacijenata WHERE kartonipacijenata_id = ?');
    $query->bindValue(1, $karton_id);
    $query->execute();
    header('Location: pregled-kartona.php');
}

?>