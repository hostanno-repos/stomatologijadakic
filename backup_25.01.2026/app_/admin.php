<?php  
session_start();
include_once('../connection.php'); 
include_once('./class/termini.php');
include_once('./class/kartoni.php');
include_once('./class/users.php');
include_once('includes/head.php');
$_GET['administracija'] = 1;

//PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
if(isset($_SESSION["logged_in"])){  

    $danas = date('Y-m-d');
    $danasnji = new zakazaniJedanDan;
    $danasnji = $danasnji->fetch_all_danas($danas);

    $sutra = date("Y-m-d", strtotime("tomorrow"));
    $sutrasnji = new zakazaniJedanDan;
    $sutrasnji = $sutrasnji->fetch_all_danas($sutra);

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

    $first_day_this_month = date('Y-m-01');
    $last_day_this_month  = date('Y-m-t');

    $ovajMjesec = new zakazaniBetween;
    $ovajMjesec = $ovajMjesec->fetch_all_sedmica($first_day_this_month, $last_day_this_month);

    $timestamp = strtotime(date('F',strtotime('first day of +1 month'))." ".date('Y'));
    $first_second = date('Y-m-01', $timestamp);
    $last_second  = date('Y-m-t', $timestamp);
    $sledeciMjesec = new zakazaniBetween;
    $sledeciMjesec = $sledeciMjesec->fetch_all_sedmica($first_second, $last_second);

?>

<!-- Page Wrapper -->
<div id="wrapper">

<?php include_once('includes/sidebar.php') ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php include_once('includes/header.php') ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <!-- <h1 class="h3 mb-0 text-gray-800">Dobrodošli</h1> -->
                <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> 
                    Generate Report
                </a> -->
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Content Column -->
                <div class="col-lg-12">
                    <h4>Termini za danas</h4>
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
                            
                            foreach($danasnji as $danasnji){ 

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
                                <td><a href="potvrdiDolazak.php?idtermina=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="propustenTermin.php?idtermina=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                <td><a href="otkaziTermin.php?idtermina=<?php echo($danasnji['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    <h4>Termini za sutra</h4>
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
                                <td><a href="potvrdiDolazak.php?idtermina=<?php echo($sutrasnji['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="propustenTermin.php?idtermina=<?php echo($sutrasnji['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                <td><a href="otkaziTermin.php?idtermina=<?php echo($sutrasnji['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    <h4>Termini za tekuću sedmicu</h4>
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
                                <td><a href="potvrdiDolazak.php?idtermina=<?php echo($ovaSedmica['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="propustenTermin.php?idtermina=<?php echo($ovaSedmica['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                <td><a href="otkaziTermin.php?idtermina=<?php echo($ovaSedmica['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    <h4>Termini za tekući mjesec</h4>
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
                            
                            foreach($ovajMjesec as $ovajMjesec){ 

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
                                <td><a href="potvrdiDolazak.php?idtermina=<?php echo($ovajMjesec['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="propustenTermin.php?idtermina=<?php echo($ovajMjesec['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                <td><a href="otkaziTermin.php?idtermina=<?php echo($ovajMjesec['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    <h4>Termini za sljedeći mjesec</h4>
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
                                <td><a href="potvrdiDolazak.php?idtermina=<?php echo($sledeciMjesec['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="propustenTermin.php?idtermina=<?php echo($sledeciMjesec['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                <td><a href="otkaziTermin.php?idtermina=<?php echo($sledeciMjesec['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

<?php 
    include_once('includes/footer.php');
}else {  
    header("location:index.php");  
}  
?>