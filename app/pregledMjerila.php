<?php

//VARIABLES
$itemToSelect = "mjerilo";
$itemToEdit = "mjerilo";
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$mjerila = new allObjects;
$mjerila = $mjerila->fetch_all_objects("mjerila", "mjerila_id", "ASC");

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Pregled mjerila</h1>
            <div>
                <a onclick="editItem()" itemToEdit="" id="editItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Uredi brojač"><i class="bi bi-pencil-square"
                            style="font-size:22px"></i></button></a>
                <a href="dodajMjerilo.php" id="addItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Dodaj mjerilo"><i class="bi-plus-square"
                            style="font-size:22px"></i></button></a>
            </div>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Pregled mjerila</li>
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
                            <th scope="col" class="text-center">Vrsta mjerila</th>
                            <th scope="col" class="text-center">Zadovoljava</th>
                            <th scope="col" class="text-center">Proizvođač</th>
                            <th scope="col" class="text-center">Tip</th>
                            <th scope="col" class="text-center">Serijski broj mjerila</th>
                            <th scope="col" class="text-center">Godina proizvodnje</th>
                            <th scope="col" class="text-center">Službena oznaka</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mjerila as $mjerilo) { ?>
                            <tr>
                                <td scope="row"><?php echo $mjerilo['mjerila_id'] ?></td>
                                <td scope="row" class="text-center"><input type="checkbox" class="selectItemButton"
                                        h="mjerilo" t="mjerila" o="<?php echo $mjerilo['mjerila_id'] ?>">
                                </td>
                                <td scope="row" class="text-center"><?php
                                $uredjaj = new singleObject;
                                $uredjaj = $uredjaj->fetch_single_object("vrsteuredjaja", "vrsteuredjaja_id", $mjerilo['mjerila_vrstauredjajaid']);
                                echo $uredjaj['vrsteuredjaja_naziv'] ?></td>
                                <td scope="row" class="text-center"><?php echo $mjerilo['mjerila_zadovoljava'] ?></td>
                                <td scope="row" class="text-center"><?php echo $mjerilo['mjerila_proizvodjac'] ?></td>
                                <td scope="row" class="text-center"><?php echo $mjerilo['mjerila_tip'] ?></td>
                                <td scope="row" class="text-center"><?php echo $mjerilo['mjerila_serijskibroj'] ?></td>
                                <td scope="row" class="text-center"><?php echo $mjerilo['mjerila_godinaproizvodnje'] ?></td>
                                <td scope="row" class="text-center"><?php echo $mjerilo['mjerila_sluzbenaoznaka'] ?></td>
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