<?php

//VARIABLES
$itemToSelect = "klijenta";
$itemToEdit = "klijent";
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$klijenti = new allObjects;
$klijenti = $klijenti->fetch_all_objects("klijenti", "klijenti_id", "ASC");

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Pregled klijenata</h1>
            <div>
                <a onclick="editItem()" itemToEdit="" id="editItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Uredi klijenta"><i class="bi bi-pencil-square"
                            style="font-size:22px"></i></button></a>
                <a href="dodajKlijenta.php" id="addItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Dodaj klijenta"><i class="bi-plus-square"
                            style="font-size:22px"></i></button></a>
            </div>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Pregled klijenata</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="text-center">Označi</th>
                            <th scope="col" class="text-center">Naziv</th>
                            <th scope="col" class="text-center">Adresa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($klijenti as $klijenti) { ?>
                            <tr>
                                <td scope="row"><?php echo $klijenti['klijenti_id'] ?></td>
                                <th scope="col" class="text-center"><input type="checkbox" class="selectItemButton"
                                        h="klijenta" t="klijenti" o="<?php echo $klijenti['klijenti_id'] ?>">
                                </th>
                                <td scope="row" class="text-center"><?php echo $klijenti['klijenti_naziv'] ?></td>
                                <td scope="row" class="text-center"><?php echo $klijenti['klijenti_adresa'] ?></td>
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