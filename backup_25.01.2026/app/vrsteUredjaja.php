<?php

//VARIABLES
$itemToSelect = "uredjaj";
$itemToEdit = "uredjaj";
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$vrsteuredjaja = new allObjects;
$vrsteuredjaja = $vrsteuredjaja->fetch_all_objects("vrsteuredjaja", "vrsteuredjaja_id", "ASC");

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Vrste uređaja</h1>
            <div>
                <a onclick="editItem()" itemToEdit="" id="editItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Uredi uređaj"><i class="bi bi-pencil-square"
                            style="font-size:22px"></i></button></a>
                <a href="dodajVrstuUredjaja.php" id="addItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Dodaj uređaj"><i class="bi-plus-square"
                            style="font-size:22px"></i></button></a>
            </div>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Vrste uređaja</li>
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
                            <th scope="col" class="text-center">Naziv uređaja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vrsteuredjaja as $vrstauredjaja) { ?>
                            <tr>
                                <td scope="row"><?php echo $vrstauredjaja['vrsteuredjaja_id'] ?></td>
                                <td scope="row" class="text-center"><input type="checkbox" class="selectItemButton"
                                        h="vrstuuređaja" t="vrsteuredjaja"
                                        o="<?php echo $vrstauredjaja['vrsteuredjaja_id'] ?>">
                                </td>
                                <td scope="row" class="text-center"><?php echo $vrstauredjaja['vrsteuredjaja_naziv'] ?></td>
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