<?php 
session_start();
include_once('../connection.php'); 
include_once('./class/termini.php');
include_once('./class/kartoni.php');
include_once('./class/users.php');
include_once('includes/head.php');

if(isset($_SESSION["logged_in"])){

$danas = date('Y-m-d');
//DANAŠNJI DESKTOP
$danasnji = new zakazaniJedanDan;
$danasnji = $danasnji->fetch_all_danas($danas);
//DANAŠNJI MOBILE
$danasnji_ = new zakazaniJedanDan;
$danasnji_ = $danasnji_->fetch_all_danas($danas);

$sutra = date("Y-m-d", strtotime("tomorrow"));
//SUTRAŠNJI DESKTOP
$sutrasnji = new zakazaniJedanDan;
$sutrasnji = $sutrasnji->fetch_all_danas($sutra);
//SUTRAŠNJI MOBILE
$sutrasnji_ = new zakazaniJedanDan;
$sutrasnji_ = $sutrasnji_->fetch_all_danas($sutra);

//check the current day
if(date('D')!='Mon')
{    
//take the last monday
$staticstart = date('Y-m-d',strtotime('last Monday'));

}else{
    $staticstart = date('Y-m-d');
}

//always next saturday

if(date('D')!='Sat')
{
    $staticfinish = date('Y-m-d',strtotime('next Saturday'));
}else{

        $staticfinish = date('Y-m-d'); 
}

$ovaSedmica = new zakazaniBetween;
$ovaSedmica = $ovaSedmica->fetch_all_sedmica($staticstart, $staticfinish);

$ovaSedmica_ = new zakazaniBetween;
$ovaSedmica_ = $ovaSedmica_->fetch_all_sedmica($staticstart, $staticfinish);

$first_day_this_month = date('Y-m-01');
$last_day_this_month  = date('Y-m-t');

$ovajMjesec = new zakazaniBetween;
$ovajMjesec = $ovajMjesec->fetch_all_sedmica($first_day_this_month, $last_day_this_month);

$ovajMjesec_ = new zakazaniBetween;
$ovajMjesec_ = $ovajMjesec_->fetch_all_sedmica($first_day_this_month, $last_day_this_month);

$timestamp = strtotime(date('F',strtotime('first day of +1 month'))." ".date('Y'));
$first_second = date('Y-m-01', $timestamp);
$last_second  = date('Y-m-t', $timestamp);

$sledeciMjesec = new zakazaniBetween;
$sledeciMjesec = $sledeciMjesec->fetch_all_sedmica($first_second, $last_second);

$sledeciMjesec_ = new zakazaniBetween;
$sledeciMjesec_ = $sledeciMjesec_->fetch_all_sedmica($first_second, $last_second);

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
            <h3 class="ms-2">ZAKAZANI TERMINI</h3>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <?php if(count($danasnji) != 0){ ?>
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="flush-headingZero">
                        <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                            <h4>DANAS</h4>
                        </button>
                    </h2>
                    <div class="accordion-collapse collapse" id="flush-collapseZero" aria-labelledby="flush-headingZero" data-coreui-parent="#accordionFlushExample" style="">
                        <div class="accordion-body ps-0 pe-0">
                            <!-- Content Column -->
                            <div class="col-lg-12 desktop-content">
                                <table class="table centeredTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Ime i prezime pacijenta</th>
                                            <th scope="col">Broj telefona pacijenta</th>
                                            <th scope="col">Ime doktora</th>
                                            <th scope="col">Datum termina</th>
                                            <th scope="col">Vrijeme termina</th>
                                            <th scope="col">Napomena</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Autor</th>
                                            <th scope="col">Datum unosa</th>
                                            <th scope="col">Potvrdi dolazak</th>
                                            <th scope="col">Propušten termin</th>
                                            <th scope="col">Otkaži</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($danasnji as $danasnji){ 
                                        $id_kartona = intval($danasnji['termini_idpacijenta']);
                                        $karton = new singleKarton;
                                        $karton = $karton->fetch_single_karton($id_kartona);
                                        $id_kdoktora = intval($danasnji['termini_iddoktora']);
                                        $doktor = new singleUser;
                                        $doktor = $doktor->fetch_single_user($id_kdoktora);
                                    ?>
                                        <tr>
                                            <td scope="row"><?php echo $danasnji['termini_id'] ?></td>
                                            <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                            <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                            <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                            <td><?php echo date('d.m.Y.',strtotime($danasnji['termini_datum'])) ?></td>
                                            <td><?php echo $danasnji['termini_vrijeme'] ?></td>
                                            <td><?php echo $danasnji['termini_napomena'] ?></td>
                                            <td><?php echo $danasnji['termini_status'] ?></td>
                                            <td><?php echo $danasnji['termini_autor'] ?></td>
                                            <td><?php echo date('d.m.Y. H:m:s',strtotime($danasnji['termini_timestamp'])) ?></td>
                                            <td><a href="potvrdi-dolazak.php?potvrdiDolazak=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                            <td><a href="propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                            <td><a href="otkazi-termin.php?otkaziTermin=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php foreach($danasnji_ as $danasnji_){ 
                                $id_kartona = intval($danasnji_['termini_idpacijenta']);
                                $karton = new singleKarton;
                                $karton = $karton->fetch_single_karton($id_kartona);
                                $id_kdoktora = intval($danasnji_['termini_iddoktora']);
                                $doktor = new singleUser;
                                $doktor = $doktor->fetch_single_user($id_kdoktora);
                            ?>
                            <div class="col-lg-12 mobile-content">
                              <div class="col-xl-12">
                                <div class="card border-dark mb-3">
                                  <div class="card-header bg-transparent border-dark">
                                    <h5 class="card-title mb-0"><?php echo date('d.m.Y.',strtotime($danasnji_['termini_datum'])) ?> u <?php echo $danasnji_['termini_vrijeme'] ?></h5>
                                  </div>
                                  <div class="card-body text-dark">
                                    <h5 class="card-title"><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></h5>
                                    Datum rođenja: <?php echo date('d.m.Y.',strtotime($karton['kartonipacijenata_datumrodjenja'])) ?><br />
                                    Telefon: <?php echo $karton['kartonipacijenata_telefon'] ?><br />
                                    <p class="card-text">
                                      Doktor: <?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?><br />
                                      Napomena: <?php echo $danasnji_['termini_napomena'] ?><br />
                                      Kreirao: <?php echo $danasnji_['termini_autor'] ?><br />
                                      Datum unosa: <?php echo date('d.m.Y. H:m:s',strtotime($danasnji_['termini_timestamp'])) ?>
                                    </p>
                                  </div>
                                  <div class="card-footer bg-transparent border-dark">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                                      <button onclick="location.href='potvrdi-dolazak.php?potvrdiDolazak=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Potvrdi</button>
                                      <button onclick="location.href='propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Propušten</button>
                                      <button onclick="location.href='otkazi-termin.php?otkaziTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Otkaži</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
              <?php } ?>
              <?php if(count($sutrasnji) != 0){ ?>
              <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"><h4>SUTRA</h4></button>
                </h2>
                <div class="accordion-collapse collapse" id="flush-collapseOne" aria-labelledby="flush-headingOne" data-coreui-parent="#accordionFlushExample" style="">
                  <div class="accordion-body ps-0 pe-0">
                    <div class="col-lg-12 desktop-content">
                        <table class="table centeredTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Ime i prezime pacijenta</th>
                                    <th scope="col">Broj telefona pacijenta</th>
                                    <th scope="col">Ime doktora</th>
                                    <th scope="col">Datum termina</th>
                                    <th scope="col">Vrijeme termina</th>
                                    <th scope="col">Napomena</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Autor</th>
                                    <th scope="col">Datum unosa</th>
                                    <th scope="col">Potvrdi dolazak</th>
                                    <th scope="col">Propušten termin</th>
                                    <th scope="col">Otkaži</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach($sutrasnji as $sutrasnji){ 

                                    $id_kartona = intval($sutrasnji['termini_idpacijenta']);
                                    $karton = new singleKarton;
                                    $karton = $karton->fetch_single_karton($id_kartona);
                                    
                                    $id_kdoktora = intval($sutrasnji['termini_iddoktora']);
                                    $doktor = new singleUser;
                                    $doktor = $doktor->fetch_single_user($id_kdoktora);

                                ?>
                                <tr>
                                    <td scope="row"><?php echo $sutrasnji['termini_id'] ?></td>
                                    <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                    <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                    <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                    <td><?php echo date('d.m.Y.',strtotime($sutrasnji['termini_datum'])) ?></td>
                                    <td><?php echo $sutrasnji['termini_vrijeme'] ?></td>
                                    <td><?php echo $sutrasnji['termini_napomena'] ?></td>
                                    <td><?php echo $sutrasnji['termini_status'] ?></td>
                                    <td><?php echo $sutrasnji['termini_autor'] ?></td>
                                    <td><?php echo date('d.m.Y. H:m:s',strtotime($sutrasnji['termini_timestamp'])) ?></td>
                                    <td><a href="potvrdi-dolazak.php?potvrdiDolazak=<?php echo($sutrasnji['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                    <td><a href="propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                    <td><a href="otkaziTermin.php?idtermina=<?php echo($sutrasnji['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php
                                
                    foreach($sutrasnji_ as $sutrasnji_){ 

                        $id_kartona = intval($sutrasnji_['termini_idpacijenta']);
                        $karton = new singleKarton;
                        $karton = $karton->fetch_single_karton($id_kartona);
                        
                        $id_kdoktora = intval($sutrasnji_['termini_iddoktora']);
                        $doktor = new singleUser;
                        $doktor = $doktor->fetch_single_user($id_kdoktora);

                    ?>

                    <div class="col-lg-12 mobile-content">
                      <div class="col-xl-12">
                        <div class="card border-dark mb-3">
                          <div class="card-header bg-transparent border-dark">
                            <h5 class="card-title mb-0"><?php echo date('d.m.Y.',strtotime($sutrasnji_['termini_datum'])) ?> u <?php echo $sutrasnji_['termini_vrijeme'] ?></h5>
                          </div>
                          <div class="card-body text-dark">
                            <h5 class="card-title"><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></h5>
                            Datum rođenja: <?php echo date('d.m.Y.',strtotime($karton['kartonipacijenata_datumrodjenja'])) ?><br />
                            Telefon: <?php echo $karton['kartonipacijenata_telefon'] ?><br />
                            <p class="card-text">
                              Doktor: <?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?><br />
                              Napomena: <?php echo $sutrasnji_['termini_napomena'] ?><br />
                              Kreirao: <?php echo $sutrasnji_['termini_autor'] ?><br />
                              Datum unosa: <?php echo date('d.m.Y. H:m:s',strtotime($sutrasnji_['termini_timestamp'])) ?>
                            </p>
                          </div>
                          <div class="card-footer bg-transparent border-dark">
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                              <button onclick="location.href='potvrdi-dolazak.php?potvrdiDolazak=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Potvrdi</button>
                              <button onclick="location.href='propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Propušten</button>
                              <button onclick="location.href='otkazi-termin.php?otkaziTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Otkaži</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php } ?>
              <?php if(count($ovaSedmica) != 0){ ?>
              <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="flush-headingTwo">
                  <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo"><h4>TEKUĆA SEDMICA</h4></button>
                </h2>
                <div class="accordion-collapse collapse" id="flush-collapseTwo" aria-labelledby="flush-headingTwo" data-coreui-parent="#accordionFlushExample" style="">
                  <div class="accordion-body ps-0 pe-0">
                  
                <div class="col-lg-12 desktop-content">
                    <table class="table centeredTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Ime i prezime pacijenta</th>
                                <th scope="col">Broj telefona pacijenta</th>
                                <th scope="col">Ime doktora</th>
                                <th scope="col">Datum termina</th>
                                <th scope="col">Vrijeme termina</th>
                                <th scope="col">Napomena</th>
                                <th scope="col">Status</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Datum unosa</th>
                                <th scope="col">Potvrdi dolazak</th>
                                <th scope="col">Propušten termin</th>
                                <th scope="col">Otkaži</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            foreach($ovaSedmica as $ovaSedmica){ 

                                $id_kartona = intval($ovaSedmica['termini_idpacijenta']);
                                $karton = new singleKarton;
                                $karton = $karton->fetch_single_karton($id_kartona);
                                
                                $id_kdoktora = intval($ovaSedmica['termini_iddoktora']);
                                $doktor = new singleUser;
                                $doktor = $doktor->fetch_single_user($id_kdoktora);

                            ?>
                            <tr>
                                <td scope="row"><?php echo $ovaSedmica['termini_id'] ?></td>
                                <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($ovaSedmica['termini_datum'])) ?></td>
                                <td><?php echo $ovaSedmica['termini_vrijeme'] ?></td>
                                <td><?php echo $ovaSedmica['termini_napomena'] ?></td>
                                <td><?php echo $ovaSedmica['termini_status'] ?></td>
                                <td><?php echo $ovaSedmica['termini_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($ovaSedmica['termini_timestamp'])) ?></td>
                                <td><a href="potvrdi-dolazak.php?potvrdiDolazak=<?php echo($ovaSedmica['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                <td><a href="otkaziTermin.php?idtermina=<?php echo($ovaSedmica['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <?php
                            
                            foreach($ovaSedmica_ as $ovaSedmica_){ 

                                $id_kartona = intval($ovaSedmica_['termini_idpacijenta']);
                                $karton = new singleKarton;
                                $karton = $karton->fetch_single_karton($id_kartona);
                                
                                $id_kdoktora = intval($ovaSedmica_['termini_iddoktora']);
                                $doktor = new singleUser;
                                $doktor = $doktor->fetch_single_user($id_kdoktora);

                            ?>

                <div class="col-lg-12 mobile-content">
                              <div class="col-xl-12">
                                <div class="card border-dark mb-3">
                                  <div class="card-header bg-transparent border-dark">
                                    <h5 class="card-title mb-0"><?php echo date('d.m.Y.',strtotime($ovaSedmica_['termini_datum'])) ?> u <?php echo $ovaSedmica_['termini_vrijeme'] ?></h5>
                                  </div>
                                  <div class="card-body text-dark">
                                    <h5 class="card-title"><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></h5>
                                    Datum rođenja: <?php echo date('d.m.Y.',strtotime($karton['kartonipacijenata_datumrodjenja'])) ?><br />
                                    Telefon: <?php echo $karton['kartonipacijenata_telefon'] ?><br />
                                    <p class="card-text">
                                      Doktor: <?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?><br />
                                      Napomena: <?php echo $ovaSedmica_['termini_napomena'] ?><br />
                                      Kreirao: <?php echo $ovaSedmica_['termini_autor'] ?><br />
                                      Datum unosa: <?php echo date('d.m.Y. H:m:s',strtotime($ovaSedmica_['termini_timestamp'])) ?>
                                    </p>
                                  </div>
                                  <div class="card-footer bg-transparent border-dark">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                                      <button onclick="location.href='potvrdi-dolazak.php?potvrdiDolazak=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Potvrdi</button>
                                      <button onclick="location.href='propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Propušten</button>
                                      <button onclick="location.href='otkazi-termin.php?otkaziTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Otkaži</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="flush-headingThree">
                  <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    <h4>TEKUĆI MJESEC</h4></button>
                </h2>
                <div class="accordion-collapse collapse" id="flush-collapseThree" aria-labelledby="flush-headingThree" data-coreui-parent="#accordionFlushExample">
                  <div class="accordion-body ps-0 pe-0">
                    <?php if(count($ovajMjesec) != 0){ ?>

                      <div class="col-lg-12 desktop-content">
                        <table class="table centeredTable">
                          <thead>
                            <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Ime i prezime pacijenta</th>
                              <th scope="col">Broj telefona pacijenta</th>
                              <th scope="col">Ime doktora</th>
                              <th scope="col">Datum termina</th>
                              <th scope="col">Vrijeme termina</th>
                              <th scope="col">Napomena</th>
                              <th scope="col">Status</th>
                              <th scope="col">Autor</th>
                              <th scope="col">Datum unosa</th>
                              <th scope="col">Potvrdi dolazak</th>
                              <th scope="col">Propušten termin</th>
                              <th scope="col">Otkaži</th>
                            </tr>
                          </thead>
                        <tbody>
                    
                      
                      <?php foreach($ovajMjesec as $ovajMjesec){ 
                          $id_kartona = intval($ovajMjesec['termini_idpacijenta']);
                          $karton = new singleKarton;
                          $karton = $karton->fetch_single_karton($id_kartona);
                          $id_kdoktora = intval($ovajMjesec['termini_iddoktora']);
                          $doktor = new singleUser;
                          $doktor = $doktor->fetch_single_user($id_kdoktora);
                      ?>
                                <tr>
                                    <td scope="row"><?php echo $ovajMjesec['termini_id'] ?></td>
                                    <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                    <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                    <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                    <td><?php echo date('d.m.Y.',strtotime($ovajMjesec['termini_datum'])) ?></td>
                                    <td><?php echo $ovajMjesec['termini_vrijeme'] ?></td>
                                    <td><?php echo $ovajMjesec['termini_napomena'] ?></td>
                                    <td><?php echo $ovajMjesec['termini_status'] ?></td>
                                    <td><?php echo $ovajMjesec['termini_autor'] ?></td>
                                    <td><?php echo date('d.m.Y. H:m:s',strtotime($ovajMjesec['termini_timestamp'])) ?></td>
                                    <td><a href="potvrdi-dolazak.php?potvrdiDolazak=<?php echo($ovajMjesec['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                    <td><a href="propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                    <td><a href="otkaziTermin.php?idtermina=<?php echo($ovajMjesec['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                      </div>

                      <?php foreach($ovajMjesec_ as $ovajMjesec_){ 
                          $id_kartona = intval($ovajMjesec_['termini_idpacijenta']);
                          $karton = new singleKarton;
                          $karton = $karton->fetch_single_karton($id_kartona);
                          $id_kdoktora = intval($ovajMjesec_['termini_iddoktora']);
                          $doktor = new singleUser;
                          $doktor = $doktor->fetch_single_user($id_kdoktora);
                      ?>

                      <div class="col-lg-12 mobile-content">
                        <div class="col-xl-12">
                          <div class="card border-dark mb-3">
                            <div class="card-header bg-transparent border-dark">
                              <h5 class="card-title mb-0"><?php echo date('d.m.Y.',strtotime($ovajMjesec_['termini_datum'])) ?> u <?php echo $ovajMjesec_['termini_vrijeme'] ?></h5>
                            </div>
                            <div class="card-body text-dark">
                              <h5 class="card-title"><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></h5>
                              Datum rođenja: <?php echo date('d.m.Y.',strtotime($karton['kartonipacijenata_datumrodjenja'])) ?><br />
                              Telefon: <?php echo $karton['kartonipacijenata_telefon'] ?><br />
                              <p class="card-text">
                                Doktor: <?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?><br />
                                Napomena: <?php echo $ovajMjesec_['termini_napomena'] ?><br />
                                Kreirao: <?php echo $ovajMjesec_['termini_autor'] ?><br />
                                Datum unosa: <?php echo date('d.m.Y. H:m:s',strtotime($ovajMjesec_['termini_timestamp'])) ?>
                              </p>
                            </div>
                            <div class="card-footer bg-transparent border-dark">
                              <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                                <button onclick="location.href='potvrdi-dolazak.php?potvrdiDolazak=<?php echo($ovajMjesec_['termini_id']); ?>'" class="btn btn-outline-info" type="button">Potvrdi</button>
                                <button onclick="location.href='propusti-termin.php?propustiTermin=<?php echo($ovajMjesec_['termini_id']); ?>'" class="btn btn-outline-info" type="button">Propušten</button>
                                <button onclick="location.href='otkazi-termin.php?otkaziTermin=<?php echo($ovajMjesec_['termini_id']); ?>'" class="btn btn-outline-info" type="button">Otkaži</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="flush-headingFour">
                  <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour"><h4>SLJEDEĆI MJESEC</h4></button>
                </h2>
                <div class="accordion-collapse collapse" id="flush-collapseFour" aria-labelledby="flush-headingFour" data-coreui-parent="#accordionFlushExample">
                  <div class="accordion-body ps-0 pe-0">
                  <?php if(count($sledeciMjesec) != 0){ ?>
                  <div class="col-lg-12 desktop-content">
                      <table class="table centeredTable">
                          <thead>
                              <tr>
                                  <th scope="col">ID</th>
                                  <th scope="col">Ime i prezime pacijenta</th>
                                  <th scope="col">Broj telefona pacijenta</th>
                                  <th scope="col">Ime doktora</th>
                                  <th scope="col">Datum termina</th>
                                  <th scope="col">Vrijeme termina</th>
                                  <th scope="col">Napomena</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Autor</th>
                                  <th scope="col">Datum unosa</th>
                                  <th scope="col">Potvrdi dolazak</th>
                                  <th scope="col">Propušten termin</th>
                                  <th scope="col">Otkaži</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              
                              foreach($sledeciMjesec as $sledeciMjesec){ 

                                  $id_kartona = intval($sledeciMjesec['termini_idpacijenta']);
                                  $karton = new singleKarton;
                                  $karton = $karton->fetch_single_karton($id_kartona);
                                  
                                  $id_kdoktora = intval($sledeciMjesec['termini_iddoktora']);
                                  $doktor = new singleUser;
                                  $doktor = $doktor->fetch_single_user($id_kdoktora);

                              ?>
                              <tr>
                                  <td scope="row"><?php echo $sledeciMjesec['termini_id'] ?></td>
                                  <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                  <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                  <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                  <td><?php echo date('d.m.Y.',strtotime($sledeciMjesec['termini_datum'])) ?></td>
                                  <td><?php echo $sledeciMjesec['termini_vrijeme'] ?></td>
                                  <td><?php echo $sledeciMjesec['termini_napomena'] ?></td>
                                  <td><?php echo $sledeciMjesec['termini_status'] ?></td>
                                  <td><?php echo $sledeciMjesec['termini_autor'] ?></td>
                                  <td><?php echo date('d.m.Y. H:m:s',strtotime($sledeciMjesec['termini_timestamp'])) ?></td>
                                  <td><a href="potvrdi-dolazak.php?potvrdiDolazak=<?php echo($sledeciMjesec['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                  <td><a href="propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                  <td><a href="otkaziTermin.php?idtermina=<?php echo($sledeciMjesec['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                              </tr>
                              <?php } ?>
                          </tbody>
                      </table>
                  </div>
                  <?php
                              
                              foreach($sledeciMjesec_ as $sledeciMjesec_){ 

                                  $id_kartona = intval($sledeciMjesec_['termini_idpacijenta']);
                                  $karton = new singleKarton;
                                  $karton = $karton->fetch_single_karton($id_kartona);
                                  
                                  $id_kdoktora = intval($sledeciMjesec_['termini_iddoktora']);
                                  $doktor = new singleUser;
                                  $doktor = $doktor->fetch_single_user($id_kdoktora);

                              ?>
                  <div class="col-lg-12 mobile-content">
                              <div class="col-xl-12">
                                <div class="card border-dark mb-3">
                                  <div class="card-header bg-transparent border-dark">
                                    <h5 class="card-title mb-0"><?php echo date('d.m.Y.',strtotime($sledeciMjesec_['termini_datum'])) ?> u <?php echo $sledeciMjesec_['termini_vrijeme'] ?></h5>
                                  </div>
                                  <div class="card-body text-dark">
                                    <h5 class="card-title"><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></h5>
                                    Datum rođenja: <?php echo date('d.m.Y.',strtotime($karton['kartonipacijenata_datumrodjenja'])) ?><br />
                                    Telefon: <?php echo $karton['kartonipacijenata_telefon'] ?><br />
                                    <p class="card-text">
                                      Doktor: <?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?><br />
                                      Napomena: <?php echo $sledeciMjesec_['termini_napomena'] ?><br />
                                      Kreirao: <?php echo $sledeciMjesec_['termini_autor'] ?><br />
                                      Datum unosa: <?php echo date('d.m.Y. H:m:s',strtotime($sledeciMjesec_['termini_timestamp'])) ?>
                                    </p>
                                  </div>
                                  <div class="card-footer bg-transparent border-dark">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                                      <button onclick="location.href='potvrdi-dolazak.php?potvrdiDolazak=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Potvrdi</button>
                                      <button onclick="location.href='propusti-termin.php?propustiTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Propušten</button>
                                      <button onclick="location.href='otkazi-termin.php?otkaziTermin=<?php echo($danasnji['termini_id']); ?>'" class="btn btn-outline-info" type="button">Otkaži</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                  <?php } ?>
                  </div>
                </div>
              </div>
            </div> 
            </div>
          <!-- MOBILE TERMINI -->
        </div>
      </div>
    <!-- FOOTER -->
    <?php include_once('includes/footer.php'); ?>

<?php 
    include_once('includes/footer.php');
}else {  
    header("location:index.php");  
}  
?>