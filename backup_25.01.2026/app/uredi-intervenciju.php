<?php
session_start();
include_once ("../connection.php");
include_once ('./class/editObject.php');
include_once ('class/getObject.php');
include_once ('includes/head.php');
$_GET['administracija'] = 2;

$now = time();
if (isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']) {

    //GET INTERVENCIJA
    $intervencija = $_GET['intervencija'];
    $intervention = new singleObject;
    $intervention = $intervention->fetch_single_object("intervencije", "intervencije_id", $intervencija);

    //GET PACIJENT
    $patijent = new singleObject;
    $patijent = $patijent->fetch_single_object("kartonipacijenata", "kartonipacijenata_id", $intervention['intervencije_idpacijenta']);

    //GET DOKTOR
    $doctor = new singleObject;
    $doctor = $doctor->fetch_single_object("user", "user_id", $intervention['intervencije_iddoktora']);

    //GET DTIP INTERVENCIJE
    $interventiontype = new allObjects;
    $interventiontype = $interventiontype->fetch_all_objects("tipoviintervencija", "tipoviintervencija_id", "ASC");


    ?>

    <body>
        <!-- SIDEBAR -->
        <?php include_once ('includes/sidebar.php'); ?>

        <div class="wrapper d-flex flex-column bg-light">

            <!-- HEADER -->
            <?php include_once ('includes/header.php'); ?>

            <div class="body flex-grow-1 px-3">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h5 class="mb-0 text-gray-800">Uredi intervenciju</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="uredi-intervenciju.php?id=<?php echo $intervention['intervencije_id']; ?>"
                                method="post" autocomplete="off" id="" enctype='multipart/form-data'>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-lg-4 d-flex flex-column mb-3">
                                            <!-- PACIJENT -->
                                            <label for="intervencije_idpacijenta">Pacijent:</label>
                                            <input type="text" name="intervencije_idpacijenta"
                                                value="<?php echo $intervention['intervencije_idpacijenta'] ?>"
                                                style="background:#eee!important;" hidden>
                                            <input type="text" name=""
                                                value="<?php echo $patijent['kartonipacijenata_ime'] . " " . $patijent['kartonipacijenata_prezime']; ?>"
                                                style="background:#eee!important;" disabled>
                                        </div>
                                        <div class="col-lg-4 d-flex flex-column mb-3">
                                            <!-- DOKTOR -->
                                            <label for="intervencije_iddoktora">Doktor:</label>
                                            <input type="text" name="intervencije_iddoktora"
                                                value="<?php echo $doctor['user_ime'] . " " . $doctor['user_prezime']; ?>"
                                                style="background:#eee!important;" disabled>
                                        </div>
                                        <div class="col-lg-4 d-flex flex-column mb-3">
                                            <!-- ZUB -->
                                            <label for="intervencije_zub">Zub(i):</label>
                                            <input type="text" name="intervencije_zub" placeholder=""
                                                value="<?php echo $intervention['intervencije_zub']; ?>" required>
                                        </div>
                                        <div class="col-lg-4 d-flex flex-column mb-3">
                                            <!-- Tip intervencije -->
                                            <label for="intervencije_idtipa">Tip intervencije:</label>
                                            <input type="number" name="intervencije_idtipa"
                                                value="<?php echo $intervention['intervencije_idtipa']; ?>" hidden>
                                            <select name="" class="selectElement_">
                                                <option value=""></option>
                                                <?php foreach ($interventiontype as $interventiontype_) { ?>
                                                    <option value="<?php echo $interventiontype_['tipoviintervencija_id'] ?>"
                                                        <?php if ($interventiontype_['tipoviintervencija_id'] == $intervention['intervencije_idtipa']) {
                                                            echo "selected";
                                                        } ?>>
                                                        <?php echo $interventiontype_['tipoviintervencija_naziv'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 d-flex flex-column mb-3">
                                            <!-- OPIS -->
                                            <label for="intervencije_opis">Opis:</label>
                                          <textarea name="intervencije_opis" id="" rows="1"><?php echo $intervention['intervencije_opis']; ?></textarea>
                                        </div>
                                        <div class="col-lg-4 d-flex flex-column mb-3">
                                            <!-- POL -->
                                            <label for="intervencije_datum">Datum:</label>
                                            <input type="date" name="intervencije_datum" value="<?php echo $intervention['intervencije_datum']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-footer mb-3">
                                        <button type="submit" class="btn btn-primary"
                                            name="edit_intervencije">Sačuvaj</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <style>
            #insert_karton .col-lg-4 {
                display: flex;
                align-items: center;
            }

            #insert_karton label {
                width: 30%;
                text-align: right;
                margin-right: 10px;
                font-size: 14px;
            }

            #insert_karton input,
            #insert_karton textarea,
            #insert_karton select {
                flex-grow: 1;
                font-size: 13px;
                border-radius: 5px;
                border: 1px solid #ccc;
                padding: 5px;
                margin: 10px 0;
            }
        </style>

        <script>
            $(document).ready(function () {
                $(".selectElement_").change(function () {
                    var selectValue = $(this).val();
                    $(this).prev().val(selectValue);
                });
            });
        </script>

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