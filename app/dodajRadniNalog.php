<?php
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$brojaci = new allObjects;
$brojaci = $brojaci->fetch_all_objects("brojacirn", "brojacirn_id", "ASC");
$klijenti = new allObjects;
$klijenti = $klijenti->fetch_all_objects("klijenti", "klijenti_id", "ASC");
$kontrolori = new allObjects;
$kontrolori = $kontrolori->fetch_all_objects("kontrolori", "kontrolori_prezime", "ASC");
$mjerila = new allObjects;
$mjerila = $mjerila->fetch_all_objects("mjerila", "mjerila_id", "ASC");
$metodeinspekcije = new allObjects;
$metodeinspekcije = $metodeinspekcije->fetch_all_objects("metodeinspekcije", "metodeinspekcije_id", "ASC");
$vrsteuredjaja = new allObjects;
$vrsteuredjaja = $vrsteuredjaja->fetch_all_objects("vrsteuredjaja", "vrsteuredjaja_id", "ASC");
//GET THIS YEAR BROJAČ
$ovagodinaBrojac = new singleObject;
$ovagodinaBrojac = $ovagodinaBrojac->fetch_single_object("brojacirn", "brojacirn_godina", date("Y"));


?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="mb-3">Dodaj radni nalog</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Dodaj radni nalog</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12 d-flex flex-column mb-2">
                <p class="pl-3" id="brojRadnogNaloga"><b>Broj radnog naloga:
                        <span><?php echo $ovagodinaBrojac['brojacirn_prefiks'] ."-". ($ovagodinaBrojac['brojacirn_brojac'] + 1) . "/" . $ovagodinaBrojac['brojacirn_godina'] ?></b></span>
                </p>
            </div>
            <form class="col-lg-12 d-flex flex-wrap" action="dodajRadniNalog.php" method="post">
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <!-- BROJAČ -->
                    <label for="radninalozi_brojacrnid">Brojač:</label>
                    <input type="number" name="radninalozi_brojacrnid" value="" hidden>
                    <select name="" id="" class="selectElement">
                        <option value=""></option>
                        <?php foreach ($brojaci as $brojac) { ?>
                            <option prefix="<?php echo $brojac['brojacirn_prefiks'] ?>"
                                brojac="<?php echo $brojac['brojacirn_brojac'] ?>"
                                godina="<?php echo $brojac['brojacirn_godina'] ?>" value="<?php echo $brojac['brojacirn_id'] ?>"
                                <?php if (date("Y") == $brojac['brojacirn_godina']) {
                                    echo "selected";
                                } ?>>
                                <?php echo $brojac['brojacirn_godina'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- BROJ RADNOG NALOGA -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_broj">Broj radnog naloga:</label>
                    <input type="text" name="radninalozi_broj"
                        value="<?php echo $ovagodinaBrojac['brojacirn_prefiks'] ."-". ($ovagodinaBrojac['brojacirn_brojac'] + 1) . "/" . $ovagodinaBrojac['brojacirn_godina'] ?>"
                        hidden>
                    <input type="text" name="radninalozi_broj_disabled"
                        value="<?php echo $ovagodinaBrojac['brojacirn_prefiks'] ."-". ($ovagodinaBrojac['brojacirn_brojac'] + 1) . "/" . $ovagodinaBrojac['brojacirn_godina'] ?>"
                        disabled>
                </div>
                <!-- KLIJENT -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_klijentid">Podnosilac zahtjeva:</label>
                    <input type="number" name="radninalozi_klijentid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($klijenti as $klijent) { ?>
                            <option value="<?php echo $klijent['klijenti_id'] ?>">
                                <?php echo $klijent['klijenti_naziv'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- BROJ ZAHTJEVA ZA INSPEKCIJU -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_brojzahtjeva">Broj zahtjeva za inspekciju:</label>
                    <input type="text" name="radninalozi_brojzahtjeva">
                </div>
                <!-- PREDMET INSPEKCIJE -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_vrstauredjajaid">Predmet inspekcije:</label>
                    <input type="number" name="radninalozi_vrstauredjajaid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($vrsteuredjaja as $vrstauredjaja) { ?>
                            <option value="<?php echo $uredjaj['vrsteuredjaja_id'] ?>">
                                <?php echo $uredjaj['vrsteuredjaja_naziv'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- VRSTA INSPEKCIJE -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_metodainspekcijeid">Vrsta inspekcije:</label>
                    <input type="number" name="radninalozi_metodainspekcijeid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($metodeinspekcije as $metodainspekcije) { ?>
                            <option value="<?php echo $metodainspekcije['metodeinspekcije_id'] ?>">
                                <?php echo $metodainspekcije['metodeinspekcije_naziv'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- BROJ MJERILA ZA INSPEKCIJU -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_mjeriloid">Broj mjerila za inspekciju:</label>
                    <input type="number" name="radninalozi_mjeriloid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($mjerila as $mjerilo) { ?>
                            <option value="<?php echo $mjerilo['mjerila_id'] ?>">
                                <?php echo $mjerilo['mjerila_broj'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- KONTROLOR -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_kontrolorid">Kontrolor:</label>
                    <input type="number" name="radninalozi_kontrolorid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($kontrolori as $kontrolor) { ?>
                            <option value="<?php echo $kontrolor['kontrolori_id'] ?>">
                                <?php echo $kontrolor['kontrolori_prezime']." ".$kontrolor['kontrolori_ime'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- OČEKIVANI ZAVRŠETAK INSPEKCIJE -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_datumzavrsetka">Očekivani završetak inspekcije:</label>
                    <input type="date" name="radninalozi_datumzavrsetka">
                </div>
                <!-- POSEBNI ZAHTJEVI -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_posebnizahtjevi">Posebni zahtjevi:</label>
                    <textarea type="text" name="radninalozi_posebnizahtjevi" rows="1"></textarea>
                </div>
                <!-- RADNI NALOG OTVORIO -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_otvorioid">Radni nalog otvorio:</label>
                    <input type="number" name="radninalozi_otvorioid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($kontrolori as $kontrolor) { ?>
                            <option value="<?php echo $kontrolor['kontrolori_id'] ?>">
                                <?php echo $kontrolor['kontrolori_prezime']." ".$kontrolor['kontrolori_ime'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- RADNI NALOG PRIMIO -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_primioid">Radni nalog primio:</label>
                    <input type="number" name="radninalozi_primioid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($kontrolori as $kontrolor) { ?>
                            <option value="<?php echo $kontrolor['kontrolori_id'] ?>">
                                <?php echo $kontrolor['kontrolori_prezime']." ".$kontrolor['kontrolori_ime'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- RADNI NALOG ZATVORIO -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_zatvorioid">Radni nalog zatvorio:</label>
                    <input type="number" name="radninalozi_zatvorioid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($kontrolori as $kontrolor) { ?>
                            <option value="<?php echo $kontrolor['kontrolori_id'] ?>">
                                <?php echo $kontrolor['kontrolori_prezime']." ".$kontrolor['kontrolori_ime'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- OČEKIVANI ZAVRŠETAK INSPEKCIJE -->
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="radninalozi_datum">Datum:</label>
                    <input type="date" name="radninalozi_datum">
                </div>
                <!-- SUBMIT -->
                <div class="col-lg-12 d-flex flex-column mt-3">
                    <button name="submit_radninalozi" class="btn btn-primary" type="submit"
                        style="width:150px">Sačuvaj</button>
                </div>
            </form>
        </div>
    </section>

</main>

<style>
    p {
        color: #000;
    }
</style>

<script>

    $(document).ready(function () {
        var prefixBrojaca = "<?php echo $ovagodinaBrojac['brojacirn_prefiks'] ?>";
        var brojacBrojaca = "<?php echo $ovagodinaBrojac['brojacirn_brojac'] ?>";
        var godinaBrojaca = "<?php echo $ovagodinaBrojac['brojacirn_godina'] ?>";
        $(".selectElement").change(function () {
            var selectValue = $(this).val();
            $(this).prev().val(selectValue);
            prefixBrojaca = $('option:selected', this).attr('prefix');
            brojacBrojaca = $('option:selected', this).attr('brojac');
            brojacBrojaca++;
            godinaBrojaca = $('option:selected', this).attr('godina');
            var brojRadnogNaloga = prefixBrojaca+"-"+brojacBrojaca+"/"+godinaBrojaca;
            $('input[name="radninalozi_broj"]').val(brojRadnogNaloga);
            $('input[name="radninalozi_broj_disabled"]').val(brojRadnogNaloga);
            $("#brojRadnogNaloga span").text(brojRadnogNaloga);
        });
        $(".selectElement_").change(function () {
            var selectValue = $(this).val();
            $(this).prev().val(selectValue);
        });
    });

</script>

<?php
//INCLUDES
include_once ('includes/footer.php');

?>