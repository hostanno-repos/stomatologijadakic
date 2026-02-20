<?php 
session_start();
include_once("../connection.php");
include_once('class/termini.php');
include_once('class/kartoni.php');
include_once('class/users.php');
include_once('includes/head.php'); 
$_GET['administracija'] = 3; 

$now = time();
if(isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']){

    $zakazani = new zakazaniTermini;
    $zakazani = $zakazani->fetch_all_zakazani();

    $zakazani_ = new zakazaniTermini;
    $zakazani_ = $zakazani_->fetch_all_zakazani();

?>

  <body>
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php'); ?>

    <div class="wrapper d-flex flex-column bg-light">

        <!-- HEADER -->
        <?php include_once('includes/header.php'); ?>

        <div class="body flex-grow-1 px-3">
            <div class="container-fluid">

                <div class="row">
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
                                
                                foreach($zakazani as $zakazani){ 

                                    $id_kartona = intval($zakazani['termini_idpacijenta']);
                                    $karton = new singleKarton;
                                    $karton = $karton->fetch_single_karton($id_kartona);
                                    
                                    $id_kdoktora = intval($zakazani['termini_iddoktora']);
                                    $doktor = new singleUser;
                                    $doktor = $doktor->fetch_single_user($id_kdoktora);

                                ?>
                                <tr>
                                    <td scope="row"><?php echo $zakazani['termini_id'] ?></td>
                                    <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                    <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                    <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                    <td><?php echo date('d.m.Y.',strtotime($zakazani['termini_datum'])) ?></td>
                                    <td><?php echo $zakazani['termini_vrijeme'] ?></td>
                                    <td><?php echo $zakazani['termini_napomena'] ?></td>
                                    <td><?php echo $zakazani['termini_status'] ?></td>
                                    <td><?php echo $zakazani['termini_autor'] ?></td>
                                    <td><?php echo date('d.m.Y. H:m:s',strtotime($zakazani['termini_timestamp'])) ?></td>
                                    <td><a href="potvrdiDolazak.php?idtermina=<?php echo($zakazani['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                    <td><a href="propustenTermin.php?idtermina=<?php echo($zakazani['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                    <td><a href="otkaziTermin.php?idtermina=<?php echo($zakazani['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12 mobile-content">
                        <?php foreach($zakazani_ as $zakazani_){ 
                                $id_kartona = intval($zakazani_['termini_idpacijenta']);
                                $karton = new singleKarton;
                                $karton = $karton->fetch_single_karton($id_kartona);
                                $id_kdoktora = intval($zakazani_['termini_iddoktora']);
                                $doktor = new singleUser;
                                $doktor = $doktor->fetch_single_user($id_kdoktora);
                            ?>
                            <div class="col-lg-12 mobile-content">
                                <div class="card border-dark mb-3">
                                  <div class="card-header bg-transparent border-dark">
                                    <h5 class="card-title mb-0"><?php echo date('d.m.Y.',strtotime($zakazani_['termini_datum'])) ?> u <?php echo $zakazani_['termini_vrijeme'] ?></h5>
                                  </div>
                                  <div class="card-body text-dark">
                                    <h5 class="card-title"><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></h5>
                                    Datum rođenja: <?php echo date('d.m.Y.',strtotime($karton['kartonipacijenata_datumrodjenja'])) ?><br />
                                    Telefon: <?php echo $karton['kartonipacijenata_telefon'] ?><br />
                                    <p class="card-text">
                                      Doktor: <?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?><br />
                                      Napomena: <?php echo $zakazani_['termini_napomena'] ?><br />
                                      Kreirao: <?php echo $zakazani_['termini_autor'] ?><br />
                                      Datum unosa: <?php echo date('d.m.Y. H:m:s',strtotime($zakazani_['termini_timestamp'])) ?>
                                    </p>
                                  </div>
                                  <div class="card-footer bg-transparent border-dark">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                                        <button onclick="location.href='potvrdi-dolazak.php?potvrdiDolazak=<?php echo($zakazani_['termini_id']); ?>'" class="btn btn-outline-info" type="button">Potvrdi</button>
                                        <button onclick="location.href='propusti-termin.php?propustiTermin=<?php echo($zakazani_['termini_id']); ?>'" class="btn btn-outline-info" type="button">Propušten</button>
                                        <button onclick="location.href='otkazi-termin.php?otkaziTermin=<?php echo($zakazani_['termini_id']); ?>'" class="btn btn-outline-info" type="button">Otkaži</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
    
    <!-- FOOTER -->
    <?php include_once('includes/footer.php'); ?>

<?php 
    include_once('includes/footer.php');
}else {  
    session_destroy();
    header("location:index.php");
    echo"<script>window.location.href = 'index.php';</script>";  
}  
?>