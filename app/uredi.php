<?php
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//get parameters
$hadline = $_GET['h'];
//fix headline
switch ($hadline) {
    case "radninalog":
        $hadline = "radni nalog";
        break;
    case "vrstuuređaja":
        $hadline = "vrstu uređaja";
        break;
    case "metoduinspekcije":
        $hadline = "metodu inspekcije";
        break;
    case "mjernuvelicinu":
        $hadline = "mjernu veličinu";
        break;
    case "referentnuvrijednost":
        $hadline = "referentnu vrijednost";
        break;
}
$table = $_GET['t'];
$object = $_GET['o'];
//get single object
$singleObject = new singleObject;
$singleObject = $singleObject->fetch_single_object($table, $table . "_id", $_GET['o']);
$select = $pdo->query('SELECT * FROM ' . $table);
$total_column = $select->columnCount();

?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between mb-2">
            <h1>Uredi <?php echo $hadline ?></h1>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Uredi <?php echo $hadline ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <form class="col-lg-12 d-flex flex-wrap" action="<?php echo end($page) ?>" method="post">
                    <?php

                    for ($counter = 0; $counter < $total_column; $counter++) {
                        $meta = $select->getColumnMeta($counter);
                        //var_dump($meta['name']);
                        //var_dump($meta['native_type']);
                        $labelName = ucfirst(explode("_", $meta['name'])[1]);
                        $tableName = explode("_", $meta['name'])[0];
                        switch ($meta['native_type']) {
                            case "LONG":
                                $tip = "number";
                                break;
                            case "VAR_STRING":
                                $tip = "text";
                                break;
                            case "DATE":
                                $tip = "date";
                                break;
                            default:
                                $tip = "text";
                                break;
                        }
                        switch ($meta['name']) {
                            case "radninalozi_brojacrnid":
                                $labelName = "Brojač";
                                $input = "select";
                                $tableSelect = "brojacirn";
                                $columnToEqual = "radninalozi_brojacrnid";
                                $columnToShow = "brojacirn_godina";
                                $tip = "number";
                                $disabled = 1;
                                break;
                            case "radninalozi_broj":
                                $labelName = "Broj radnog naloga";
                                $input = "input";
                                $tip = "text";
                                $disabled = 1;
                                break;
                            case "radninalozi_klijentid":
                                $labelName = "Podnosilac zahtjeva";
                                $input = "select";
                                $tableSelect = "klijenti";
                                $columnToEqual = "radninalozi_klijentid";
                                $columnToShow = "klijenti_naziv";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_brojzahtjeva":
                                $labelName = "Broj zahtjeva za inspekciju";
                                $input = "input";
                                $tip = "text";
                                $disabled = 0;
                                break;
                            case "radninalozi_metodainspekcijeid":
                                $labelName = "Vrsta inspekcije";
                                $input = "select";
                                $tableSelect = "metodeinspekcije";
                                $columnToEqual = "radninalozi_metodainspekcijeid";
                                $columnToShow = "metodeinspekcije_naziv";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_mjeriloid":
                                $labelName = "Mjerilo";
                                $input = "select";
                                $tableSelect = "mjerila";
                                $columnToEqual = "radninalozi_mjeriloid";
                                $columnToShow = "mjerila_broj";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_kontrolorid":
                                $labelName = "Kontrolor";
                                $input = "select";
                                $tableSelect = "kontrolori";
                                $columnToEqual = "radninalozi_kontrolorid";
                                $columnToShow_1 = "kontrolori_ime";
                                $columnToShow_2 = "kontrolori_prezime";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_datumzavrsetka":
                                $labelName = "Očekivani završetak inspekcije";
                                $input = "input";
                                $disabled = 0;
                                break;
                            case "radninalozi_posebnizahtjevi":
                                $labelName = "Posebni zahtjevi";
                                $input = "textarea";
                                $disabled = 0;
                                break;
                            case "radninalozi_vrstauredjajaid":
                                $labelName = "Predmet inspekcije";
                                $input = "select";
                                $tableSelect = "vrsteuredjaja";
                                $columnToEqual = "radninalozi_vrstauredjajaid";
                                $columnToShow = "vrsteuredjaja_naziv";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_otvorioid":
                                $labelName = "Radni nalog otvorio";
                                $input = "select";
                                $tableSelect = "kontrolori";
                                $columnToEqual = "radninalozi_otvorioid";
                                $columnToShow_1 = "kontrolori_ime";
                                $columnToShow_2 = "kontrolori_prezime";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_primioid":
                                $labelName = "Radni nalog primio";
                                $input = "select";
                                $tableSelect = "kontrolori";
                                $columnToEqual = "radninalozi_primioid";
                                $columnToShow_1 = "kontrolori_ime";
                                $columnToShow_2 = "kontrolori_prezime";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_zatvorioid":
                                $labelName = "Radni nalog zatvorio";
                                $input = "select";
                                $tableSelect = "kontrolori";
                                $columnToEqual = "radninalozi_zatvorioid";
                                $columnToShow_1 = "kontrolori_ime";
                                $columnToShow_2 = "kontrolori_prezime";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "radninalozi_datum":
                                $labelName = "Datum";
                                $input = "input";
                                $tip = "date";
                                $disabled = 0;
                                break;
                            case "mjerila_vrstauredjajaid":
                                $labelName = "Vrsta uređaja";
                                $input = "select";
                                $tableSelect = "vrsteuredjaja";
                                $columnToEqual = "mjerila_vrstauredjajaid";
                                $columnToShow = "vrsteuredjaja_naziv";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "mjerila_proizvodjac":
                                $labelName = "Proizvođač";
                                break;
                            case "mjerila_serijskibroj":
                                $labelName = "Serijski broj";
                                break;
                            case "mjerila_godinaproizvodnje":
                                $labelName = "Godina proizvodnje";
                                break;
                            case "mjerila_sluzbenaoznaka":
                                $labelName = "Službena oznaka";
                                break;
                            case "mjernevelicine_vrstauredjajaid":
                                $labelName = "Vrsta uređaja";
                                $input = "select";
                                $tableSelect = "vrsteuredjaja";
                                $columnToEqual = "mjernevelicine_vrstauredjajaid";
                                $columnToShow = "vrsteuredjaja_naziv";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "referentnevrijednosti_mjernavelicinaid":
                                $labelName = "Mjerna veličina";
                                $input = "select";
                                $tableSelect = "mjernevelicine";
                                $columnToEqual = "referentnevrijednosti_mjernavelicinaid";
                                $columnToShow = "mjernevelicine_naziv";
                                $tip = "number";
                                $disabled = 0;
                                break;
                            case "referentnevrijednosti_referentnavrijednost":
                                $labelName = "Referentna vrijednost";
                                $input = "input";
                                $tip = "number";
                                break;
                            default:
                                $input = "input";
                                $tip = "text";
                                $disabled = 0;
                                break;
                        } ?>

                        <?php if ($tableName != "radninalozi_") { ?>

                            <?php if ($labelName != "Id" && $labelName != "Timestamp") { ?>
                                <div class="col-lg-3 d-flex flex-column mb-2">
                                    <label for="<?php echo $meta['name'] ?>"><?php echo $labelName ?>:</label>
                                <?php } ?>

                                <?php if ($input == "input") { ?>
                                    <input type="<?php echo $tip ?>" name="<?php echo $meta['name'] ?>"
                                        value="<?php echo $singleObject[$meta['name']] ?>" <?php if ($labelName == "Id" || $labelName == "Timestamp") {
                                               echo "hidden";
                                           }else if($disabled == 1){echo "disabled";} ?> step="any">
                                <?php } else if ($input == "textarea") { ?>
                                        <textarea name="<?php echo $meta['name'] ?>"
                                            id="" rows="1"><?php echo $singleObject[$meta['name']] ?></textarea>

                                <?php } else if ($input == "select") { ?>
                                            <input type="<?php echo $tip ?>" name="<?php echo $meta['name'] ?>"
                                                value="<?php echo $singleObject[$meta['name']] ?>" hidden>
                                            <select name="" id="" class="selectElement_" <?php if($disabled == 1){echo "disabled";} ?>>
                                                <option value=""></option>
                                            <?php
                                            $selectedItems = new allObjects;
                                            $selectedItems = $selectedItems->fetch_all_objects($tableSelect, $tableSelect . "_id", "ASC");
                                            foreach ($selectedItems as $selectedItem) {
                                                ?>
                                                    <option value="<?php echo $selectedItem[$tableSelect . "_id"] ?>" <?php if($selectedItem[$tableSelect . "_id"] == $singleObject[$columnToEqual]){echo "selected";}?>>
                                            <?php 
                                            if(isset($columnToShow_1) && isset($columnToShow_2)){
                                                echo $selectedItem[$columnToShow_1]." ".$selectedItem[$columnToShow_2];
                                            }else{
                                               echo $selectedItem[$columnToShow];
                                            }
                                             ?></option>
                                        <?php } ?>
                                            </select>
                                <?php } ?>

                                <?php if ($labelName != "Id" && $labelName != "Timestamp") { ?>
                                </div>
                            <?php } ?>

                        <?php } ?>

                    <?php } ?>
                    <div class="col-lg-12 d-flex flex-column mt-3">
                        <button name="edit_<?php echo $table ?>" class="btn btn-primary" type="submit"
                            style="width:150px">Sačuvaj</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</main>

<script>
    $(document).ready(function () {
        $(".selectElement_").change(function () {
            var selectValue = $(this).val();
            $(this).prev().val(selectValue);
            console.log("1");
        });
    });
</script>

<?php
//INCLUDES
include_once ('includes/footer.php');

?>