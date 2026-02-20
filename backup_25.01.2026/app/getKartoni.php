<?php

include_once ('../connection.php');

$whereString = "";
if ($_POST['getKarton'] == "YES") {
    foreach ($_POST as $index => $value) {
        if ($value != "" && $index != "getKarton") {
            if ($whereString == "") {
                $whereString .= $index . "='" . $value . "'";
            } else {
                $whereString .= " AND " . $index . "='" . $value . "'";
            }
        }
    }
}

class customKartoni
{
    public function fetch_all($whereString)
    {
        global $pdo;
        if ($whereString != "") {
            $query = $pdo->prepare("SELECT * FROM kartonipacijenata WHERE " . $whereString . " ORDER BY kartonipacijenata_prezime ASC");
        } else {
            $query = $pdo->prepare("SELECT * FROM kartonipacijenata ORDER BY kartonipacijenata_prezime ASC");
        }
        $query->execute();
        return $query->fetchAll();
    }
}
$customKartoni = new customKartoni;
$customKartoni = $customKartoni->fetch_all($whereString);

echo json_encode($customKartoni, JSON_UNESCAPED_UNICODE);

?>