<?php 
session_start();
include_once("../connection.php");
//include_once('class/kartoni.php');
include_once('class/insertObject.php');
include_once('class/intervencije.php');
include_once('includes/head.php'); 
$_GET['administracija'] = 5; 

$now = time();
if(isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']){

    //GET ALL TIPOVI INTERVENCIJA
    $svi_tipovi_intervencija = new tipoviIntervencija;
    $svi_tipovi_intervencija = $svi_tipovi_intervencija->fetch_all_tipovi_intervencija();

    //GET ALL TIPOVI INTERVENCIJA
    $svi_tipovi_intervencija_ = new tipoviIntervencija;
    $svi_tipovi_intervencija_ = $svi_tipovi_intervencija_->fetch_all_tipovi_intervencija();

?>

  <body>
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php'); ?>

    <div class="wrapper d-flex flex-column bg-light">

        <!-- HEADER -->
        <?php include_once('includes/header.php'); ?>

        <div class="body flex-grow-1 px-3">
            <div class="container-fluid">
                <h3 class="mb-3">Tipovi intervencija</h3>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#insertIntervencijeModal">Dodaj tip intervencije</button>
                </div>

                <div class="row desktop-content">
                    <div class="col-lg-12">
                        <table class="table centeredTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Naziv tipa intervencije</th>
                                    <th scope="col" class="text-center">Datum kreiranja</th>
                                    <th scope="col" class="text-center">Autor</th>
                                    <th scope="col" class="text-center">Uredi</th>
                                    <th scope="col" class="text-center">Izbriši</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($svi_tipovi_intervencija as $tipoviintervencija){ ?>
                            <tr>
                                <th class="text-center" scope="row"><?php echo $tipoviintervencija['tipoviintervencija_id'] ?></th>
                                <td class="text-center"><?php echo $tipoviintervencija['tipoviintervencija_naziv'] ?></td>
                                <td class="text-center"><?php echo $tipoviintervencija['tipoviintervencija_timestamp'] ?></td>
                                <td class="text-center"><?php echo $tipoviintervencija['tipoviintervencija_autor'] ?></td>
                                <td class="text-center edit-intervencije">
                                    <i 
                                        class="fa-solid fa-user-pen"
                                        data-toggle="modal" 
                                        data-target="#editIntervencijeModal" 
                                        aria-hidden="true"
                                        dataID="<?php echo $tipoviintervencija['tipoviintervencija_id'] ?>"
                                        onclick="showEditIntervencije(<?php echo $tipoviintervencija['tipoviintervencija_id'] ?>)"
                                    ></i></td>

                                <td class="text-center">
                                    <i 
                                        class="fa-solid fa-trash delete-object"
                                        aria-hidden="true"
                                        data-toggle="modal" 
                                        data-target="#deleteIntervencijeModal"
                                        dataID_="<?php echo $tipoviintervencija['tipoviintervencija_id'] ?>"
                                        dataLink="tipovi-intervencija.php?deleteTipIntervencije=<?php echo $tipoviintervencija['tipoviintervencija_id'] ?>"
                                    
                                    ></i></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mobile-content">
                    <div class="col-lg-12">
                        <?php foreach($svi_tipovi_intervencija_ as $svi_tipovi_intervencija_) { ?>
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

    <!-- Modal insert -->
    <div class="modal fade" id="insertIntervencijeModal" tabindex="-1" role="dialog" aria-labelledby="insertIntervencijeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertIntervencijeModalLabel">Dodaj tip intervencije</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="tipovi-intervencija.php" method="post">
                <div class="modal-body">
                    <div class="d-flex mb-3">
                        <!-- NAZIV INTERVENCIJE -->
                        <label class="mb-0 mr-2" for="tipoviintervencija_naziv">Naziv: </label>
                        <input name="tipoviintervencija_naziv" type="text" value="" placeholder="Tip intervencije...">
                    </div>
                    <div>
                        <!-- AUTOR INTERVENCIJE -->
                        <label class="mb-0 mr-2" for="tipoviintervencija_autor">Autor:</label>
                        <input class="invisible-input" name="tipoviintervencija_autor" type="text" readonly value="<?php echo $_SESSION['user_ime']." ".$_SESSION['user_prezime'] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary" name="submit_tipoviintervencija">Sačuvaj</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="editIntervencijeModal" tabindex="-1" role="dialog" aria-labelledby="editIntervencijeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIntervencijeModalLabel">Uredi tip intervencije</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="tipovi-intervencija.php" method="post">
                <div class="modal-body">
                    <div id="polja_tip_intervencije"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary" name="submit_edit_tip_intervencije">Sačuvaj</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Modal delete -->
    <div class="modal fade" id="deleteIntervencijeModal" tabindex="-1" role="dialog" aria-labelledby="deleteIntervencijeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteIntervencijeModalLabel">Izbriši tip intervencije</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Da li ste sigurni da želite izbrisati odabrani tip intervencije?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                    <a id="submit_delete_tip_intervencije" href="">
                        <button type="submit" class="btn btn-primary" name="submit_delete_tip_intervencije">Izbriši</button>
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