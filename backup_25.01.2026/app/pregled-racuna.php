<?php 
session_start();
include_once("../connection.php");
include_once('class/racuni.php');
include_once('class/uplate.php');
include_once('class/kartoni.php');
include_once('class/users.php');
include_once('includes/head.php'); 
$_GET['administracija'] = 6; 

$now = time();
if(isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']){

    //GET ALL RACUNI
    $allracuni = new allRacuni;
    $allracuni = $allracuni->fetch_all_racuni();

    //GET ALL RACUNI
    $allracuni_ = new allRacuni;
    $allracuni_ = $allracuni_->fetch_all_racuni();

?>

  <body>
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php'); ?>

    <div class="wrapper d-flex flex-column bg-light">

        <!-- HEADER -->
        <?php include_once('includes/header.php'); ?>

        <div class="body flex-grow-1 px-3">
            <div class="container-fluid">
                <h3 class="mb-3">Pregled računa</h3>
                <div class="row desktop-content">
                    <div class="col-lg-12">
                        <table class="table centeredTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <!-- <th scope="col">ID intervencije</th> -->
                                    <!-- <th scope="col">ID pacijenta</th> -->
                                    <th scope="col">Ime i prezime pacijenta</th>
                                    <!-- <th scope="col">ID doktora</th> -->
                                    <th scope="col">Ime doktora</th>
                                    <th scope="col">Datum računa</th>
                                    <th scope="col">Iznos računa</th>
                                    <th scope="col">Vrsta plaćanja</th>
                                    <th scope="col">Plaćeno</th>
                                    <th scope="col">Djelimično plaćeno</th>
                                    <th scope="col">Autor</th>
                                    <th scope="col">Datum unosa</th>
                                    <th scope="col">Detalji</th>
                                    <?php if($_SESSION['user'] == "milan.dakic"){ ?>
                                    <th scope="col">Izbriši</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($allracuni as $racun){ 
                                
                                //POKUPI PACIJENTA ČIJI JE RAČUN
                                $id_kartona = intval($racun['racuni_idpacijenta']); 
                                $karton = new singleKarton;
                                $karton = $karton->fetch_single_karton($id_kartona);
    
                                //POKUPI DOKTORA KOJI JE RADIO
                                $id_doktora = intval($racun['racuni_iddoktora']); 
                                $doktor = new singleUser;
                                $doktor = $doktor->fetch_single_user($id_doktora);
    
                                ?>
                                <tr>
                                    <td scope="row"><?php echo $racun['racuni_id'] ?></td>
                                    <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                    <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                    <td><?php echo date('d.m.Y.',strtotime($racun['racuni_datum'])) ?></td>
                                    <td><?php echo number_format($racun['racuni_iznos'],2,'.','') ?> KM</td>
                                    <td><?php echo $racun['racuni_vrstaplacanja'] ?></td>
                                    <td><?php if($racun['racuni_placeno'] == 0){echo "NE";}else{echo "DA";} ?></td>
                                    <td><?php if($racun['racuni_djelimicnoplaceno'] == 0){echo "NE";}else{echo "DA";} ?></td>
                                    <td><?php echo $racun['racuni_autor'] ?></td>
                                    <td><?php echo date('d.m.Y. H:m:s',strtotime($racun['racuni_timestamp'])) ?></td>
                                    <td>
                                        <a class="clearCookieSectionActive" href="detalji-racuna.php?detaljiRacuna=<?php echo $racun['racuni_id'] ?>">
                                            <button type="button" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square"></i> Detalji</button>
                                        </a></td>
                                    </td>
                                    <!-- <td>
                                        <a href="uredi-racun.php?id=<?php //echo $racun['racuni_id'] ?>">
                                            <button type="button" class="btn btn-warning"><i class="fa-solid fa-user-pen"></i> Uredi</button>
                                        </a>
                                    </td> -->
                                    <?php if($_SESSION['user'] == "milan.dakic"){ ?>
                                    <td>
                                        <button 
                                            type="button" 
                                            class="btn btn-danger delete-object"
                                            data-toggle="modal" 
                                            data-target="#deleteRacuniModal"
                                            dataID_="<?php echo $racun['racuni_id'] ?>"
                                            dataLink="pregled-racuna.php?deleteRacun=<?php echo $racun['racuni_id'] ?>"
                                            ><i class="fa-solid fa-trash"></i> Izbriši</button>
                                    </td>
                                    <?php } ?>
                                    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mobile-content">
                    <div class="col-lg-12">
                        <?php foreach($allracuni_ as $allracuni_) {

                        //GET DOKTOR WHO CREATED THE RAČUN
                        $moj_racun_id = intval($allracuni_['racuni_iddoktora']); 
                        $singleuser_0 = new singleUser;
                        $singleuser = $singleuser_0->fetch_single_user($moj_racun_id);

                        //GET PATIENT
                        $moj_karton_id = intval($allracuni_['racuni_idpacijenta']); 
                        $singlepatient = new singleKarton;
                        $singlepatient = $singlepatient->fetch_single_karton($moj_karton_id);

                        //GET ALL UPLATE FOR THIS RAČUN
                        $this_racun_id = $allracuni_['racuni_id'];
                        $sve_uplate = new mojeUplate;
                        $sve_uplate = $sve_uplate->fetch_all_moje_uplate($this_racun_id);

                        $uplaceniIznos = 0;
                        foreach($sve_uplate as $sve_uplate_){
                            $uplaceniIznos = $uplaceniIznos + $sve_uplate_['uplate_iznos'];
                        }
                        $preostaliIznos = $allracuni_['racuni_iznos'] - $uplaceniIznos;
                            
                        ?>
                        <div class="card border-dark mb-3">
                            <div class="card-header bg-transparent border-dark">
                                <h5 class="card-title mb-0"><?php echo number_format($allracuni_['racuni_iznos'],2,'.','') ?> KM</h5>
                            </div>
                            <div class="card-body text-dark">
                                Datum: <?php echo date('d.m.Y.',strtotime($allracuni_['racuni_datum'])) ?><br />
                                Pacijent: <?php echo $singlepatient['kartonipacijenata_ime'] ?> <?php echo $singlepatient['kartonipacijenata_prezime'] ?> <br />
                                Doktor: <?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?> <br />
                                Vrsta plaćanja: <?php echo $allracuni_['racuni_vrstaplacanja'] ?> <br />
                                Uplaćeno: <?php echo $uplaceniIznos." KM" ?><br />
                                Preostali dug: <?php echo $preostaliIznos." KM" ?>
                            </div>
                            <div class="card-footer bg-transparent border-dark">
                                <button onclick="location.href='detalji-racuna.php?detaljiRacuna=<?php echo $allracuni_['racuni_id'] ?>'" type="button" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square"></i> Detalji</button>
                                <?php if($_SESSION['user'] == "milan.dakic"){ ?>
                                <button 
                                        type="button" 
                                        class="btn btn-danger delete-object"
                                        data-toggle="modal" 
                                        data-target="#deleteRacuniModal"
                                        dataID_="<?php echo $allracuni_['racuni_id'] ?>"
                                        dataLink="pregled-racuna.php?deleteRacun=<?php echo $allracuni_['racuni_id'] ?>"
                                        ><i class="fa-solid fa-trash"></i> Izbriši
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal delete -->
    <div class="modal fade" id="deleteRacuniModal" tabindex="-1" role="dialog" aria-labelledby="deleteRacuniModalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRacuniModalModalLabel">Izbriši račun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Da li ste sigurni da želite izbrisati odabrani račun?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                    <a id="submit_delete_tip_intervencije" href="">
                        <button type="submit" class="btn btn-primary" name="submit_delete_racun">Izbriši</button>
                    </a>
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