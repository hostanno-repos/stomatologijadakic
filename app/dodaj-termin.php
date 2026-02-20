<?php 
session_start();
include_once('../connection.php'); 
include_once('./class/insertObject.php');
include_once('./class/termini.php');
include_once('./class/kartoni.php');
include_once('./class/users.php');
include_once('includes/head.php');

$now = time();
if(isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']){

    $users = new users;
    $users = $users->fetch_all();

    $kartoni = new kartoniPacijenata;
    $kartoni = $kartoni->fetch_all_kartonipacijenata();

    if(isset($_GET['datum'])){
        $datumZaSelekciju = $_GET['datum'];
        $datumZaSelekciju = str_replace("a", '0',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("b", '1',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("c", '2',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("d", '3',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("e", '4',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("f", '5',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("g", '6',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("h", '7',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("i", '8',$datumZaSelekciju);
        $datumZaSelekciju = str_replace("j", '9',$datumZaSelekciju);

        $datumZaSelekciju = date('Y-m-d', strtotime('+1 day', $datumZaSelekciju));
    }else{
        $datumZaSelekciju = date('Y-m-d');
    }

    class zakazaniDanas {
        public function fetch_all_samo_danas($danas) {
            global $pdo;
            $query = $pdo->prepare("SELECT * FROM termini WHERE termini_datum = ? AND termini_status = 'Zakazan' ORDER BY termini_datum, termini_vrijeme ASC");
            $query->bindValue(1, $danas);
            $query->execute();
            return $query->fetchAll();
        }
    }

    $danasnji = new zakazaniDanas;
    $danasnji = $danasnji->fetch_all_samo_danas($datumZaSelekciju);

    $niz0800 = [];
    $niz0830 = [];
    $niz0900 = [];
    $niz0930 = [];
    $niz1000 = [];
    $niz1030 = [];
    $niz1100 = [];
    $niz1130 = [];
    $niz1200 = [];
    $niz1230 = [];
    $niz1300 = [];
    $niz1330 = [];
    $niz1400 = [];
    $niz1430 = [];
    $niz1500 = [];
    $niz1530 = [];
    $niz1600 = [];
    $niz1630 = [];
    $niz1700 = [];
    $niz1730 = [];
    $niz1800 = [];
    $niz1830 = [];

    foreach($danasnji as $danasnji){
        // 08:00
        if($danasnji['termini_vrijeme'] ==  "08:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz0800, $danasnji['termini_napomena']);
            }else{
                array_push($niz0800, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);  
            }
            
        }
        // 08:30
        if($danasnji['termini_vrijeme'] ==  "08:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz0830, $danasnji['termini_napomena']);
            }else{
                array_push($niz0830, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
        }
        // 09:00
        if($danasnji['termini_vrijeme'] ==  "09:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz0900, $danasnji['termini_napomena']);
            }else{
                array_push($niz0900, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 09:30
        if($danasnji['termini_vrijeme'] ==  "09:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz0930, $danasnji['termini_napomena']);
            }else{
                array_push($niz0930, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 10:00
        if($danasnji['termini_vrijeme'] ==  "10:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1000, $danasnji['termini_napomena']);
            }else{
                array_push($niz1000, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 10:30
        if($danasnji['termini_vrijeme'] ==  "10:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1030, $danasnji['termini_napomena']);
            }else{
                array_push($niz1030, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 11:00
        if($danasnji['termini_vrijeme'] ==  "11:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1100, $danasnji['termini_napomena']);
            }else{
                array_push($niz1100, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 11:30
        if($danasnji['termini_vrijeme'] ==  "11:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1130, $danasnji['termini_napomena']);
            }else{
                array_push($niz1130, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 12:00
        if($danasnji['termini_vrijeme'] ==  "12:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1200, $danasnji['termini_napomena']);
            }else{
                array_push($niz1200, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 12:30
        if($danasnji['termini_vrijeme'] ==  "12:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1230, $danasnji['termini_napomena']);
            }else{
                array_push($niz1230, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 13:00
        if($danasnji['termini_vrijeme'] ==  "13:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1300, $danasnji['termini_napomena']);
            }else{
                array_push($niz1300, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 13:30
        if($danasnji['termini_vrijeme'] ==  "13:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1330, $danasnji['termini_napomena']);
            }else{
                array_push($niz1330, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 14:00
        if($danasnji['termini_vrijeme'] ==  "14:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1400, $danasnji['termini_napomena']);
            }else{
                array_push($niz1400, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 14:30
        if($danasnji['termini_vrijeme'] ==  "14:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1430, $danasnji['termini_napomena']);
            }else{
                array_push($niz1430, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 15:00
        if($danasnji['termini_vrijeme'] ==  "15:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1500, $danasnji['termini_napomena']);
            }else{
                array_push($niz1500, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 15:30
        if($danasnji['termini_vrijeme'] ==  "15:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1530, $danasnji['termini_napomena']);
            }else{
                array_push($niz1530, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 16:00
        if($danasnji['termini_vrijeme'] ==  "16:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1600, $danasnji['termini_napomena']);
            }else{
                array_push($niz1600, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 16:30
        if($danasnji['termini_vrijeme'] ==  "16:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1630, $danasnji['termini_napomena']);
            }else{
                array_push($niz1630, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 17:00
        if($danasnji['termini_vrijeme'] ==  "17:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1700, $danasnji['termini_napomena']);
            }else{
                array_push($niz1700, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 17:30
        if($danasnji['termini_vrijeme'] ==  "17:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1730, $danasnji['termini_napomena']);
            }else{
                array_push($niz1730, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 18:00
        if($danasnji['termini_vrijeme'] ==  "18:00:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1800, $danasnji['termini_napomena']);
            }else{
                array_push($niz1800, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
        // 18:30
        if($danasnji['termini_vrijeme'] ==  "18:30:00"){
            $pacijentZaVrijeme = new singleKarton;
            $pacijentZaVrijeme = $pacijentZaVrijeme->fetch_single_karton($danasnji['termini_idpacijenta']);
            if($pacijentZaVrijeme['kartonipacijenata_ime'] == "NOVI" && $pacijentZaVrijeme['kartonipacijenata_prezime'] == "PACIJENT"){
                array_push($niz1830, $danasnji['termini_napomena']);
            }else{
                array_push($niz1830, $pacijentZaVrijeme['kartonipacijenata_ime']." ".$pacijentZaVrijeme['kartonipacijenata_prezime']);
            }
            
        }
    }

?>

  <body>
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php'); ?>

    <div class="wrapper d-flex flex-column bg-light">

      <!-- HEADER -->
      <?php include_once('includes/header.php'); ?>

      <div class="body flex-grow-1 px-3">
        <div class="container-fluid">
          <!-- DESKTOP TERMINI -->
          <div class="row">
            <h3 class="mb-5">DODAJ TERMIN <?php if(isset($_GET['datum'])) { echo "za " . date('d.m.Y.',strtotime($datumZaSelekciju)); } ?></h3>
            <p id="test"></p>
            <form action="dodaj-termin.php" method="post" autocomplete="off" id="insert_termin" enctype='multipart/form-data'>
                <div class="form-body">
                    <div class="row">
                        <div class="col-lg-12 d-flex mobile-column">
                            <!-- PACIJENT -->
                            <label for="termini_idpacijenta">Izaberite pacijenta:</label>
                            <input type="number" name="termini_idpacijenta" style="display:none">
                            <select class="gettingIdSelect flex-grow-1" required>
                                <option value=""></option>
                                <?php foreach($kartoni as $kartoni){ ?>
                                    <option value="<?php echo $kartoni['kartonipacijenata_id'] ?>"><?php echo $kartoni['kartonipacijenata_ime']." ";if($kartoni['kartonipacijenata_roditelj'] != NULL){echo "(".$kartoni['kartonipacijenata_roditelj'].")";}; echo " ".$kartoni['kartonipacijenata_prezime'];if($kartoni['kartonipacijenata_datumrodjenja'] != NULL){echo " - ".date('d.m.Y.',strtotime($kartoni['kartonipacijenata_datumrodjenja']));} ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 d-flex mobile-column">
                            <!-- DOKTOR -->
                            <label for="termini_iddoktora">Izaberite doktora:</label>
                            <input type="number" name="termini_iddoktora" hidden>
                            <select class="gettingIdSelect flex-grow-1" required>
                                <option value=""></option>
                                <?php foreach($users as $users){ ?>
                                    <option value="<?php echo $users['user_id'] ?>"><?php echo $users['user_ime']." ".$users['user_prezime'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-12 d-flex mobile-column" <?php if(isset($_GET['datum'])) { echo('style="display:none!important;"'); } ?>>
                            <!-- DATUM -->
                            <label for="termini_datum">Datum:</label>
                            <input id="datepicker" class="flex-grow-1 w-100" type="date" name="termini_datum" value="<?php if(isset($_GET['datum'])){ echo $datumZaSelekciju;} ?>" required>
                        </div>
                        <div class="col-lg-12 d-flex mobile-column">
                            <!-- VRIJEME -->
                            <label for="termini_vrijeme">Vrijeme:</label>
                            <input id="termini_vrijeme" type="time" name="termini_vrijeme" hidden>
                            <div id="vremenaTermini">
                                <p class="gettingIdSelectp" value="08:00"><span class="me-2">08:00</span>
                                <?php   

                                    if(count($niz0800) == 1){
                                        echo $niz0800[0];
                                    }elseif(count($niz0800) != 0){
                                        for($i=0; $i<count($niz0800)-1; $i++){
                                            echo $niz0800[$i].", ";
                                            }
                                            echo $niz0800[count($niz0800)-1];
                                    } ?>
                                </p>
                                <p class="gettingIdSelectp" value="08:30"><span class="me-2">08:30</span><?php if(count($niz0830) == 1){echo $niz0830[0];}elseif(count($niz0830) != 0){for($i=0; $i<count($niz0830)-1; $i++){echo $niz0830[$i].", ";}echo $niz0830[count($niz0830)-1];} ?></p>
                                <p class="gettingIdSelectp" value="09:00"><span class="me-2">09:00</span><?php if(count($niz0900) == 1){echo $niz0900[0];}elseif(count($niz0900) != 0){for($i=0; $i<count($niz0900)-1; $i++){echo $niz0900[$i].", ";}echo $niz0900[count($niz0900)-1];} ?></p>
                                <p class="gettingIdSelectp" value="09:30"><span class="me-2">09:30</span><?php if(count($niz0930) == 1){echo $niz0930[0];}elseif(count($niz0930) != 0){for($i=0; $i<count($niz0930)-1; $i++){echo $niz0930[$i].", ";}echo $niz0930[count($niz0930)-1];} ?></p>
                                <p class="gettingIdSelectp" value="10:00"><span class="me-2">10:00</span><?php if(count($niz1000) == 1){echo $niz1000[0];}elseif(count($niz1000) != 0){for($i=0; $i<count($niz1000)-1; $i++){echo $niz1000[$i].", ";}echo $niz1000[count($niz1000)-1];} ?></p>
                                <p class="gettingIdSelectp" value="10:30"><span class="me-2">10:30</span><?php if(count($niz1030) == 1){echo $niz1030[0];}elseif(count($niz1030) != 0){for($i=0; $i<count($niz1030)-1; $i++){echo $niz1030[$i].", ";}echo $niz1030[count($niz1030)-1];} ?></p>
                                <p class="gettingIdSelectp" value="11:00"><span class="me-2">11:00</span><?php if(count($niz1100) == 1){echo $niz1100[0];}elseif(count($niz1100) != 0){for($i=0; $i<count($niz1100)-1; $i++){echo $niz1100[$i].", ";}echo $niz1100[count($niz1100)-1];} ?></p>
                                <p class="gettingIdSelectp" value="11:30"><span class="me-2">11:30</span><?php if(count($niz1130) == 1){echo $niz1130[0];}elseif(count($niz1130) != 0){for($i=0; $i<count($niz1130)-1; $i++){echo $niz1130[$i].", ";}echo $niz1130[count($niz1130)-1];} ?></p>
                                <p class="gettingIdSelectp" value="12:00"><span class="me-2">12:00</span><?php if(count($niz1200) == 1){echo $niz1200[0];}elseif(count($niz1200) != 0){for($i=0; $i<count($niz1200)-1; $i++){echo $niz1200[$i].", ";}echo $niz1200[count($niz1200)-1];} ?></p>
                                <p class="gettingIdSelectp" value="12:30"><span class="me-2">12:30</span><?php if(count($niz1230) == 1){echo $niz1230[0];}elseif(count($niz1230) != 0){for($i=0; $i<count($niz1230)-1; $i++){echo $niz1230[$i].", ";}echo $niz1230[count($niz1230)-1];} ?></p>
                                <p class="gettingIdSelectp" value="13:00"><span class="me-2">13:00</span><?php if(count($niz1300) == 1){echo $niz1300[0];}elseif(count($niz1300) != 0){for($i=0; $i<count($niz1300)-1; $i++){echo $niz1300[$i].", ";}echo $niz1300[count($niz1300)-1];} ?></p>
                                <p class="gettingIdSelectp" value="13:30"><span class="me-2">13:30</span><?php if(count($niz1330) == 1){echo $niz1330[0];}elseif(count($niz1330) != 0){for($i=0; $i<count($niz1330)-1; $i++){echo $niz1330[$i].", ";}echo $niz1330[count($niz1330)-1];} ?></p>
                                <p class="gettingIdSelectp" value="14:00"><span class="me-2">14:00</span><?php if(count($niz1400) == 1){echo $niz1400[0];}elseif(count($niz1400) != 0){for($i=0; $i<count($niz1400)-1; $i++){echo $niz1400[$i].", ";}echo $niz1400[count($niz1400)-1];} ?></p>
                                <p class="gettingIdSelectp" value="14:30"><span class="me-2">14:30</span><?php if(count($niz1430) == 1){echo $niz1430[0];}elseif(count($niz1430) != 0){for($i=0; $i<count($niz1430)-1; $i++){echo $niz1430[$i].", ";}echo $niz1430[count($niz1430)-1];} ?></p>
                                <p class="gettingIdSelectp" value="15:00"><span class="me-2">15:00</span><?php if(count($niz1500) == 1){echo $niz1500[0];}elseif(count($niz1500) != 0){for($i=0; $i<count($niz1500)-1; $i++){echo $niz1500[$i].", ";}echo $niz1500[count($niz1500)-1];} ?></p>
                                <p class="gettingIdSelectp" value="15:30"><span class="me-2">15:30</span><?php if(count($niz1530) == 1){echo $niz1530[0];}elseif(count($niz1530) != 0){for($i=0; $i<count($niz1530)-1; $i++){echo $niz1530[$i].", ";}echo $niz1530[count($niz1530)-1];} ?></p>
                                <p class="gettingIdSelectp" value="16:00"><span class="me-2">16:00</span><?php if(count($niz1600) == 1){echo $niz1600[0];}elseif(count($niz1600) != 0){for($i=0; $i<count($niz1600)-1; $i++){echo $niz1600[$i].", ";}echo $niz1600[count($niz1600)-1];} ?></p>
                                <p class="gettingIdSelectp" value="16:30"><span class="me-2">16:30</span><?php if(count($niz1630) == 1){echo $niz1630[0];}elseif(count($niz1630) != 0){for($i=0; $i<count($niz1630)-1; $i++){echo $niz1630[$i].", ";}echo $niz1630[count($niz1630)-1];} ?></p>
                                <p class="gettingIdSelectp" value="17:00"><span class="me-2">17:00</span><?php if(count($niz1700) == 1){echo $niz1700[0];}elseif(count($niz1700) != 0){for($i=0; $i<count($niz1700)-1; $i++){echo $niz1700[$i].", ";}echo $niz1700[count($niz1700)-1];} ?></p>
                                <p class="gettingIdSelectp" value="17:30"><span class="me-2">17:30</span><?php if(count($niz1730) == 1){echo $niz1730[0];}elseif(count($niz1730) != 0){for($i=0; $i<count($niz1730)-1; $i++){echo $niz1730[$i].", ";}echo $niz1730[count($niz1730)-1];} ?></p>
                                <p class="gettingIdSelectp" value="18:00"><span class="me-2">18:00</span><?php if(count($niz1800) == 1){echo $niz1800[0];}elseif(count($niz1800) != 0){for($i=0; $i<count($niz1800)-1; $i++){echo $niz1800[$i].", ";}echo $niz1800[count($niz1800)-1];} ?></p>
                                <p class="gettingIdSelectp" value="18:30"><span class="me-2">18:30</span><?php if(count($niz1830) == 1){echo $niz1830[0];}elseif(count($niz1830) != 0){for($i=0; $i<count($niz1830)-1; $i++){echo $niz1830[$i].", ";}echo $niz1830[count($niz1830)-1];} ?></p>
                            </div>
                            <!-- <select class="gettingIdSelect flex-grow-1" required>
                                <option value=""></option>
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                                <option value="18:00">18:00</option>
                                <option value="18:30">18:30</option>
                            </select> -->
                        </div>
                        <div class="col-lg-12 d-flex mobile-column">
                            <!-- NAPOMENA -->
                            <label for="termini_napomena">Unesite napomenu:</label>
                            <textarea class="flex-grow-1" name="termini_napomena" id="" cols="30" rows="10" placeholder="Napomena.."></textarea>
                        </div>
                        <div>
                            <input type="text" name="termini_status" value="Zakazan" hidden>
                        </div>
                        <div>
                            <input type="text" name="termini_autor" value="<?php echo $_SESSION['user_ime'].' '.$_SESSION['user_prezime']; ?>"  hidden>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary mb-5" name="submit_termini">Sačuvaj</button>
                    </div>
                </div>
            </form>

            </div>
          <!-- MOBILE TERMINI -->

        </div>
      </div>
    
    <!-- FOOTER -->
    <?php include_once('includes/footer.php'); ?>

    <style>
        #insert_termin label{
            width: 30%;
            text-align: left;
            margin-right: 10px;
            font-size: 16px;
        }

        #insert_termin input, #insert_termin textarea, #insert_termin select{
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 5px;
            margin: 10px 0;
            max-width: 300px;
        }

        #insert_termin .col-lg-3,
        #insert_termin .col-lg-4{
            display: flex;
            align-items: stretch;
            flex-direction: column;
        }
        .gettingIdSelectp {
            background:#fff; 
            border-bottom: 1px solid #ccc;
            padding: 0.5rem;
            min-width: 300px;
        }

        .gettingIdSelectp.selectedTime {
            background:#3c4b64; 
            color: #fff;
            border-bottom: 1px solid #ccc;
        }
        @media screen and (max-width:559px){
            .mobile-column{
                display: flex;
                flex-direction: column;
            }
            #insert_termin label{
                width: 100%;
            }
            #insert_termin input:not([type=radio]), #insert_termin textarea, #insert_termin select{
                width:100%!important;
                max-width: 100%;
                -webkit-appearance: none;
                min-height: 31px;
                background: #fff;
                text-align:left!important;
            }
            .gettingIdSelectp {
            background:#fff; 
            border-bottom: 1px solid #ccc;
            padding: 0.5rem;
            min-width: auto;
        }
        }
        
    </style>

<?php 
    include_once('includes/footer.php');
}else {  
    session_destroy();
    header("location:index.php");
    echo"<script>window.location.href = 'index.php';</script>";  
}  
?>

<script>
    <?php if(!isset($_GET['datum'])) { ?>
    document.getElementById('datepicker').valueAsDate = new Date();
    <?php } ?>
</script>

<script>

$(window).load(function() {
    $(".klasa").css('display', 'flex');
});

</script>