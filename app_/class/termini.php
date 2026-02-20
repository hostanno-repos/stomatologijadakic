<?php

//GET ALL TERMINI FOR SINGLE PACIJENT
class mojiTermini {
    public function fetch_all_moji_termini($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_idpacijenta = ? ORDER BY termini_id ASC");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL ZAKAZANI TERMINI
class zakazaniTermini {
    public function fetch_all_zakazani() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_status = 'Zakazan' ORDER BY termini_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL ZAHTJEVI ZA TERMIN
class zahtjeviTermini {
    public function fetch_all_zahtjevi() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_status = 'Zahtjev' ORDER BY termini_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL OTKAZANI TERMINI
class otkazaniTermini {
    public function fetch_all_otkazani() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_status = 'Otkazan' ORDER BY termini_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL ZAVRSENI TERMINI
class zavrseniTermini {
    public function fetch_all_zavrseni() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_status = 'Završen' ORDER BY termini_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL PROPUSTENI TERMINI
class propusteniTermini {
    public function fetch_all_propusteni() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_status = 'Propušten' ORDER BY termini_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL ODBIJENI ZAHTJEVI
class odbijeniTermini {
    public function fetch_all_odbijeni() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_status = 'Odbijen' ORDER BY termini_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL TERMINI ZA JEDAN DAN
class zakazaniJedanDan {
    public function fetch_all_danas($danas) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_datum = ? AND termini_status = 'Zakazan' ORDER BY termini_id ASC");
        $query->bindValue(1, $danas);
        $query->execute();
        return $query->fetchAll();
    }
}

//GET ALL TERMINI ZA OVU SEDMICU
class zakazaniBetween {
    public function fetch_all_sedmica($ponedjeljak, $subota) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM termini WHERE termini_datum BETWEEN :start AND :end AND termini_status = 'Zakazan' ORDER BY termini_id ASC");
        $query->execute([':start' => $ponedjeljak, ':end' => $subota]);
        return $query->fetchAll();
    }
}

?>