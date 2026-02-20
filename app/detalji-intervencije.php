<?php
session_start();
include_once ("../connection.php");
include_once ('class/getObject.php');
include_once ('includes/head.php');
$_GET['administracija'] = 2;

$now = time();
if (isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']) {

    //GET INTERVENCIJA
    $intervention = new singleObject;
    $intervention = $intervention->fetch_single_object("intervencije", "intervencije_id", $_GET['intervencija']);

    //GET PACIJENT
    $patijent = new singleObject;
    $patijent = $patijent->fetch_single_object("kartonipacijenata", "kartonipacijenata_id", $intervention['intervencije_idpacijenta']);

    //GET DOKTOR
    $doctor = new singleObject;
    $doctor = $doctor->fetch_single_object("user", "user_id", $intervention['intervencije_iddoktora']);

    //GET DTIP INTERVENCIJE
    $interventiontype = new singleObject;
    $interventiontype = $interventiontype->fetch_single_object("tipoviintervencija", "tipoviintervencija_id", $intervention['intervencije_idtipa']);

    ?>

    <body>
        <!-- SIDEBAR -->
        <?php include_once ('includes/sidebar.php'); ?>

        <div class="wrapper d-flex flex-column bg-light">

            <!-- HEADER -->
            <?php include_once ('includes/header.php'); ?>

            <div class="body flex-grow-1 px-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Pregled intervencije</h3>
                        </div>
                    </div>
                    <br>
                    <div class="row desktop-content d-flex">
                        <div class="col-lg-4">
                            <p><b>Ime pacijenta:</b>
                                <?php echo $patijent['kartonipacijenata_ime'] . " " . $patijent['kartonipacijenata_prezime'] ?>
                            </p>
                            <p><b>Ime doktora:</b>
                                <?php echo $doctor['user_ime'] . " " . $doctor['user_prezime'] ?>
                            </p>
                            <p><b>Datum: </b><?php echo $intervention['intervencije_datum'] ?></p>
                            <p><b>Autor: </b><?php echo $intervention['intervencije_autor'] ?></p>
                        </div>
                        <div class="col-lg-4">
                            <p><b>Intervencija: </b>
                                <?php echo $interventiontype['tipoviintervencija_naziv'] ?>
                            </p>
                            <p><b>Zub(i): </b>
                                <?php echo $intervention['intervencije_zub'] ?>
                            </p>
                            <p><b>Opis: </b><?php echo $intervention['intervencije_opis'] ?></p>

                        </div>
                        <div class="col-lg-4">
                            <p><b>Slika:</b></p>
                            <img class="lightboxed" data-link="<?php echo $intervention['intervencije_slika'] ?>"
                                src="<?php echo $intervention['intervencije_slika'] ?>" data-caption="<?php echo $intervention['intervencije_opis'] ?>" alt="" width="300" height="300"
                                style="object-fit:cover;">
                        </div>
                    </div>
                    <div class="row mobile-content">
                        <div class="col-lg-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include_once ('includes/footer.php'); ?>

        <?php
        include_once ('includes/footer.php');
} else {
    session_destroy();
    header("location:index.php");
    echo "<script>window.location.href = 'index.php';</script>";
}
?>