<?php

//VARIABLES
$itemToSelect = "uredjaj";
$itemToEdit = "uredjaj";
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$referentnevrijednosti = new allObjects;
$referentnevrijednosti = $referentnevrijednosti->fetch_all_objects("referentnevrijednosti", "referentnevrijednosti_id", "ASC");

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Referentne vrijednosti</h1>
            <div>
                <a onclick="editItem()" itemToEdit="" id="editItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Uredi uređaj"><i class="bi bi-pencil-square"
                            style="font-size:22px"></i></button></a>
                <a href="dodajReferentnuVrijednost.php" id="addItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Dodaj uređaj"><i class="bi-plus-square"
                            style="font-size:22px"></i></button></a>
            </div>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Referentne vrijednosti</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col" style="width:100px;">#</th>
                            <th scope="col" class="text-center" style="width:150px;">Označi</th>
                            <th scope="col" class="text-center">Vrsta uređaja</th>
                            <th scope="col" class="text-center">Mjerna veličina</th>
                            <th scope="col" class="text-center">Referentna vrijednost</th>
                            <th scope="col" class="text-center">Dozvoljeno odstupanje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($referentnevrijednosti as $referentnavrijednost) {
                            $mjernavelicina = new singleObject;
                            $mjernavelicina = $mjernavelicina->fetch_single_object("mjernevelicine", "mjernevelicine_id", $referentnavrijednost['referentnevrijednosti_mjernavelicinaid']);
                            ?>
                            <tr>
                                <td scope="row"><?php echo $referentnavrijednost['referentnevrijednosti_id'] ?></td>
                                <td scope="row" class="text-center"><input type="checkbox" class="selectItemButton"
                                        h="referentnuvrijednost" t="referentnevrijednosti"
                                        o="<?php echo $referentnavrijednost['referentnevrijednosti_id'] ?>">
                                </td>
                                <td scope="row" class="text-center"><?php
                                $vrstauredjaja = new singleObject;
                                $vrstauredjaja = $vrstauredjaja->fetch_single_object("vrsteuredjaja", "vrsteuredjaja_id", $mjernavelicina['mjernevelicine_vrstauredjajaid']);
                                echo $vrstauredjaja['vrsteuredjaja_naziv'] ?></td>
                                <td scope="row" class="text-center">
                                    <?php echo $mjernavelicina['mjernevelicine_naziv'] ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php echo $referentnavrijednost['referentnevrijednosti_referentnavrijednost'] ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php echo $referentnavrijednost['referentnevrijednosti_odstupanje'] . "%" ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</main>

<?php
//INCLUDES
include_once ('includes/footer.php');

?>