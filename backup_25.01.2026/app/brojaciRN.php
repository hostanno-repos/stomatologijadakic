<?php

//VARIABLES
$itemToSelect = "brojač";
$itemToEdit = "brojac";
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$brojaci = new allObjects;
$brojaci = $brojaci->fetch_all_objects("brojacirn", "brojacirn_id", "ASC");

if (isset($_GET['setbrojac']) && isset($_GET['brojacGodina'])) {
    $newValueBrojac = $_GET['setbrojac'];
    $brojacGodina = $_GET['brojacGodina'];
    $sql = $pdo->prepare("UPDATE brojacirn SET brojacirn_brojac=$newValueBrojac WHERE brojacirn_godina=$brojacGodina");
    $sql->execute();
    header('Location:brojacirn.php');
}

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Brojači radnih naloga</h1>
            <div>
                <a onclick="editItem()" itemToEdit="" id="editItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Uredi brojač"><i class="bi bi-pencil-square"
                            style="font-size:22px"></i></button></a>
                <a href="dodajBrojac.php" id="addItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Dodaj brojač"><i class="bi-plus-square"
                            style="font-size:22px"></i></button></a>
            </div>
        </div>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Brojači radnih naloga</li>
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
                            <th scope="col" class="text-center">Prefiks brojača</th>
                            <th scope="col" class="text-center">Vrijednost brojača</th>
                            <th scope="col" class="text-center">Godina brojača</th>
                            <th scope="col" class="text-center">Umanji brojač</th>
                            <th scope="col" class="text-center">Povećaj brojač</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($brojaci as $brojac) { ?>
                            <tr>
                                <td scope="row"><?php echo $brojac['brojacirn_id'] ?></td>
                                <td scope="row" class="text-center"><input type="checkbox" class="selectItemButton"
                                        h="brojač" t="brojacirn" o="<?php echo $brojac['brojacirn_id'] ?>">
                                </td>
                                <td scope="row" class="text-center"><?php echo $brojac['brojacirn_prefiks'] ?></td>
                                <td scope="row" class="text-center"><?php echo $brojac['brojacirn_brojac'] ?></td>
                                <td scope="row" class="text-center"><?php echo $brojac['brojacirn_godina'] ?></td>
                                <td scope="row" class="text-center"><a
                                        href="brojacirn.php?setbrojac=<?php echo $brojac['brojacirn_brojac'] - 1 ?>&brojacGodina=<?php echo $brojac['brojacirn_godina'] ?>"><i
                                            class="bi bi-dash-square-fill" style="font-size:22px"></i></a></td>
                                <td scope="row" class="text-center"><a
                                        href="brojacirn.php?setbrojac=<?php echo $brojac['brojacirn_brojac'] + 1 ?>&brojacGodina=<?php echo $brojac['brojacirn_godina'] ?>"><i
                                            class="bi bi-plus-square-fill" style="font-size:22px"></i></a></td>
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