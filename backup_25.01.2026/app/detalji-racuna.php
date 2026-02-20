<?php 
session_start();
include_once("../connection.php");
include_once('class/insertObject.php');
include_once('class/kartoni.php');
include_once('class/intervencije.php');
include_once('class/racuni.php');
include_once('class/uplate.php');
include_once('class/termini.php');
include_once('class/users.php');
include_once('includes/head.php'); 
$_GET['administracija'] = 2; 

$now = time();
if(isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']){

        //GET SINGLE RAČUN
        $single_racun_id = $_GET['detaljiRacuna'];
        $racuni = new singleRacun;
        $racuni = $racuni->fetch_single_racun($single_racun_id);

        //GET SINGLE KARTON
        $single_karton_id = $racuni['racuni_idpacijenta'];
        $kartoni_ = new singleKarton;
        $karton_ = $kartoni_->fetch_single_karton($single_karton_id);

        //GET DOKTOR WHO DID THE INTERVENTION
        $id_doktora = $racuni['racuni_iddoktora']; 
        $singleuser = new singleUser;
        $singleuser = $singleuser->fetch_single_user($id_doktora);

        //GET UPLATE FOR SINGLE RAČUN
        $sve_uplate = new mojeUplate;
        $sve_uplate = $sve_uplate->fetch_all_moje_uplate($single_racun_id);

        //GET UPLATE FOR SINGLE RAČUN
        $sve_uplate_1 = new mojeUplate;
        $sve_uplate_1 = $sve_uplate_1->fetch_all_moje_uplate($single_racun_id);

        $uplaceniIznos = 0;
        foreach($sve_uplate as $sve_uplate_){
            $uplaceniIznos = $uplaceniIznos + $sve_uplate_['uplate_iznos'];
        }
        $preostaliIznos = $racuni['racuni_iznos'] - $uplaceniIznos;

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
                <div class="col-lg-4 text-center" style="font-size: 14px; color:var(--blue);">
                    <!-- DOKTOR -->
                    <label for="">Doktor:</label> <?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?>
                    <br />
                    <!-- PACIJENT -->
                    <label for="">Pacijent:</label> <?php echo $karton_['kartonipacijenata_ime']." ".$karton_['kartonipacijenata_prezime'] ?>
                </div>
                <div class="col-lg-4 text-center" style="font-size: 14px; color:var(--blue);">
                    <!-- IZNOS -->
                    <label for="">Iznos računa:</label> <?php echo number_format($racuni['racuni_iznos'],2,'.','') ?>
                    <br />
                    <label for="">Uplaćeno:</label> <?php echo number_format($uplaceniIznos,2,'.','')." KM" ?>
                     / 
                    <label for="">Preostalo:</label> <?php echo number_format($preostaliIznos,2,'.','')." KM" ?>
                    <br />
                    <!-- VRSTA PLAĆANJA -->
                    <label for="">Vrsta plaćanja:</label> <?php echo $racuni['racuni_vrstaplacanja'] ?>
                </div>
                <div class="col-lg-4 text-center" style="font-size: 14px; color:var(--blue);">
                    <!-- AUTOR -->
                    <label for="">Račun kreirao: </label> <?php echo $racuni['racuni_autor'] ?>
                    <br />
                    <!-- DATUM RAČUNA -->
                    <label for="">Datum računa:</label> <?php echo $racuni['racuni_datum'] ?>
                    <br />
                    <!-- DATUM UNOSA -->
                    <label for="">Datum unosa:</label> <?php echo date('d.m.Y. H:m:s',strtotime($racuni['racuni_timestamp'])) ?>
                </div>
            </div>
            <br /><br />
            <div class="row desktop-content">
                <div class="col-lg-12">
                    <?php if($preostaliIznos != 0){ ?>
                    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#insertUplataModal">Dodaj uplatu po računu</button>
                    <?php } ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID uplate</th>
                                <th>ID računa</th>
                                <th>Datum uplate</th>
                                <th>Iznos uplate</th>
                                <th>Naplatio</th>
                                <th>Datum i vrijeme unosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sve_uplate as $sve_uplate) { ?>
                            <tr>
                                <td><?php echo $sve_uplate['uplate_id'] ?></td>
                                <td><?php echo $sve_uplate['uplate_idracuna'] ?></td>
                                <td><?php echo $sve_uplate['uplate_datum'] ?></td>
                                <td><?php echo number_format($sve_uplate['uplate_iznos'],2,'.','')." KM" ?></td>
                                <td><?php echo $sve_uplate['uplate_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($sve_uplate['uplate_timestamp'])) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mobile-content">
                <?php if($preostaliIznos != 0){ ?>
                <div class="col-lg-12">
                    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#insertUplataModal">Dodaj uplatu po računu</button>
                </div>
                <?php } ?>
                <div class="col-lg-12">
                    <?php foreach($sve_uplate_1 as $sve_uplate_) { ?>
                    <div class="card border-dark mb-3">
                        <div class="card-header bg-transparent border-dark">
                            <h5 class="card-title mb-0"><?php echo date('d.m.Y.',strtotime($sve_uplate_['uplate_datum'])) ?></h5>
                        </div>
                        <div class="card-body text-dark">
                            Iznos uplate: <?php echo number_format($sve_uplate_['uplate_iznos'],2,'.','')." KM" ?><br />
                            Naplatio: <?php echo $sve_uplate_['uplate_autor'] ?> <br />
                            Datum unosa: <?php echo date('d.m.Y. H:m:s',strtotime($sve_uplate_['uplate_timestamp'])) ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                </div>

            </div>
        </div>

    </div>

    <!-- MODAL INSTERT NEW RAČUN -->
    <div class="modal fade" id="insertUplataModal" tabindex="-1" role="dialog" aria-labelledby="insertUplataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertUplataModalLabel">Dodaj uplatu po računu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="detalji-racuna.php?detaljiRacuna=<?php echo $racuni['racuni_id'] ?>" method="post" enctype='multipart/form-data'>
                <div class="modal-body pb-0 pt-0">
                    <div class="d-flex mb-3 d-flex flex-column">
                        <!-- ID RAČUNA -->
                        <input name="uplate_idracuna" type="number" value="<?php echo $racuni['racuni_id'] ?>" hidden>
                        <!-- DATUM RAČUNA -->
                        <label for="uplate_datum">Datum uplate:</label>
                        <input type="date" name="uplate_datum">
                        <!-- IZNOS UPLATE -->
                        <label for="uplate_iznos">Iznos računa:</label>
                        <input type="number" name="uplate_iznos">
                        <!-- AUTOR INTERVENCIJE -->
                        <label class="mb-0" for="uplate_autor">Autor:</label>
                        <input class="invisible-input pl-0" name="uplate_autor" type="text" readonly value="<?php echo $_SESSION['user_ime']." ".$_SESSION['user_prezime'] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary" name="submit_uplate">Sačuvaj</button>
                </div>
            </form>
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