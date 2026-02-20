<?php

//VARIABLES
$itemToSelect = "kontrolora";
$itemToEdit = "kontrolor";
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$kontrolori = new allObjects;
$kontrolori = $kontrolori->fetch_all_objects("kontrolori", "kontrolori_id", "ASC");

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Kontrolori</h1>
            <div>
                <a onclick="editItem()" itemToEdit="" id="editItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Uredi brojač"><i class="bi bi-pencil-square"
                            style="font-size:22px"></i></button></a>
                <a href="dodajKontrolora.php" id="addItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Dodaj kontrolora"><i class="bi-plus-square"
                            style="font-size:22px"></i></button></a>
            </div>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Kontrolori</li>
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
                            <th scope="col" class="text-center">Ime</th>
                            <th scope="col" class="text-center">Prezime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kontrolori as $kontrolor) { ?>
                            <tr>
                                <td scope="row"><?php echo $kontrolor['kontrolori_id'] ?></td>
                                <td scope="row" class="text-center"><input type="checkbox" class="selectItemButton"
                                        h="kontrolora" t="kontrolori" o="<?php echo $kontrolor['kontrolori_id'] ?>">
                                </td>
                                <td scope="row" class="text-center"><?php echo $kontrolor['kontrolori_ime'] ?></td>
                                <td scope="row" class="text-center"><?php echo $kontrolor['kontrolori_prezime'] ?></td>
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