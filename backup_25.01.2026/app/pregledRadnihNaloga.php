<?php

//VARIABLES
$itemToSelect = "radni nalog";
$itemToEdit = "radniNalog";
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$radniNalozi = new allObjects;
$radniNalozi = $radniNalozi->fetch_all_objects("radninalozi", "radninalozi_id", "ASC");

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Pregled radnih naloga</h1>
            <div>
                <a onclick="editItem()" itemToEdit="" id="editItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Uredi radni nalog"><i class="bi bi-pencil-square"
                            style="font-size:22px"></i></button></a>
                <a href="dodajRadniNalog.php" id="addItem"><button class="btn btn-dark" data-toggle="tooltip"
                        data-placement="bottom" title="Dodaj radni nalog"><i class="bi-plus-square"
                            style="font-size:22px"></i></button></a>
            </div>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Radni nalozi</li>
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
                            <th scope="col" class="text-center" style="width:150px;">Označi</th>
                            <th scope="col" class="text-center">Broj radnog naloga</th>
                            <th scope="col" class="text-center">Podnosilac zahtjeva</th>
                            <th scope="col" class="text-center">Broj zahtjeva za inspekciju</th>
                            <!-- <th scope="col" class="text-center">Vrsta inspekcije</th> -->
                            <!-- <th scope="col" class="text-center">Mjerilo</th> -->
                            <!-- <th scope="col" class="text-center">Kontrolor</th> -->
                            <!-- <th scope="col" class="text-center">Očekivani završetak inspekcije</th> -->
                            <!-- <th scope="col" class="text-center">Posebni zahtjevi</th> -->
                            <th scope="col" class="text-center">Predmet inspekcije</th>
                            <!-- <th scope="col" class="text-center">Otvorio</th> -->
                            <!-- <th scope="col" class="text-center">Primio</th> -->
                            <!-- <th scope="col" class="text-center">Zatvorio</th> -->
                            <th scope="col" class="text-center">Datum</th>
                            <th scope="col" class="text-center">PDF</th>
                            <th scope="col" class="text-center">Izvještaj</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($radniNalozi as $radniNalog) { ?>
                            <tr>
                                <td scope="row"><?php echo $radniNalog['radninalozi_id'] ?></td>
                                <td scope="row" class="text-center">
                                    <input type="checkbox" class="selectItemButton" h="radninalog" t="radninalozi"
                                        o="<?php echo $radniNalog['radninalozi_id'] ?>">
                                </td>
                                <td scope="row" class="text-center">
                                    <?php echo $radniNalog['radninalozi_broj'] ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php
                                    $podnosilacZahtjeva = new singleObject;
                                    $podnosilacZahtjeva = $podnosilacZahtjeva->fetch_single_object("klijenti", "klijenti_id", $radniNalog['radninalozi_klijentid']);
                                    echo $podnosilacZahtjeva['klijenti_naziv']
                                        ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php echo $radniNalog['radninalozi_brojzahtjeva'] ?>
                                </td>
                                <!-- <td scope="row" class="text-center">
                                    <?php
                                    //$metodainspekcije = new singleObject;
                                    //$metodainspekcije = $metodainspekcije->fetch_single_object("metodeinspekcije", "metodeinspekcije_id", $radniNalog['radninalozi_metodainspekcijeid']);
                                    //echo $metodainspekcije['metodeinspekcije_naziv']
                                    ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php
                                    //$mjerilo = new singleObject;
                                    //$mjerilo = $mjerilo->fetch_single_object("mjerila", "mjerila_id", $radniNalog['radninalozi_mjeriloid']);
                                    //echo $mjerilo['mjerila_broj']
                                    ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php
                                    //$kontrolor = new singleObject;
                                    //$kontrolor = $kontrolor->fetch_single_object("kontrolori", "kontrolori_id", $radniNalog['radninalozi_kontrolorid']);
                                    //echo $kontrolor['kontrolori_ime'] . " " . $kontrolor['kontrolori_prezime']
                                    ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php //echo date('d.m.Y.', strtotime($radniNalog['radninalozi_datumzavrsetka'])) ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php //echo $radniNalog['radninalozi_posebnizahtjevi'] ?>
                                </td> -->
                                <td scope="row" class="text-center"><?php
                                $vrstauredjaja = new singleObject;
                                $vrstauredjaja = $vrstauredjaja->fetch_single_object("vrsteuredjaja", "vrsteuredjaja_id", $radniNalog['radninalozi_vrstauredjajaid']);
                                echo $vrstauredjaja['vrsteuredjaja_naziv'] ?></td>
                                <!-- <td scope="row" class="text-center">
                                    <?php
                                    //$otvorio = new singleObject;
                                    //$otvorio = $otvorio->fetch_single_object("kontrolori", "kontrolori_id", $radniNalog['radninalozi_otvorioid']);
                                    //echo $otvorio['kontrolori_ime'] . " " . $otvorio['kontrolori_prezime']
                                    ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php
                                    //$primio = new singleObject;
                                    //$primio = $primio->fetch_single_object("kontrolori", "kontrolori_id", $radniNalog['radninalozi_primioid']);
                                    //echo $primio['kontrolori_ime'] . " " . $primio['kontrolori_prezime']
                                    ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php
                                    //$zatvorio = new singleObject;
                                    //$zatvorio = $zatvorio->fetch_single_object("kontrolori", "kontrolori_id", $radniNalog['radninalozi_zatvorioid']);
                                    //echo $zatvorio['kontrolori_ime'] . " " . $zatvorio['kontrolori_prezime']
                                    ?>
                                </td> -->
                                <td scope="row" class="text-center">
                                    <?php echo date('d.m.Y.', strtotime($radniNalog['radninalozi_datum'])) ?>
                                </td>
                                <td class="print_pdf text-center"><a
                                        href="pregledRadnogNaloga.php?radninalog=<?php echo $radniNalog['radninalozi_id'] ?>"><i
                                            class="bi bi-file-earmark-pdf-fill"></i> Otvori</a></td>
                                <td scope="col" class="text-center">
                                    <?php
                                    $idVrsteUredjaja = $radniNalog['radninalozi_vrstauredjajaid'];
                                    $tableToFind = "izvjestaji" . $idVrsteUredjaja;
                                    //var_dump($tableToFind);
                                    //kupimo radni nalog
                                    $$tableToFind = new singleObject;
                                    $$tableToFind = $$tableToFind->fetch_single_object($tableToFind, $tableToFind . "_radninalogid", $radniNalog['radninalozi_id']);
                                    if ($$tableToFind == false) {
                                        echo "Kreiraj izvještaj";
                                    } else {
                                        echo "Pregled izvještaja";
                                    }
                                    ?>
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