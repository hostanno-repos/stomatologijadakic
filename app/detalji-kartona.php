<?php
session_start();
include_once ("../connection.php");
include_once ('class/insertObject.php');
include_once ('class/kartoni.php');
include_once ('class/intervencije.php');
include_once ('class/racuni.php');
include_once ('class/uplate.php');
include_once ('class/termini.php');
include_once ('class/users.php');
include_once ('includes/head.php');
$_GET['administracija'] = 2;

$now = time();
if (isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']) {
    

    //GET SINGLE KARTON
    $single_karton_id = $_GET['detaljiKartona'];
    $kartoni_ = new singleKarton;
    $karton_ = $kartoni_->fetch_single_karton($single_karton_id);

    //GET INTERVENCIJE FOR SELECTED PACIJENT (DESKTOP)
    $moje_intervencije = new myInterventions;
    $moje_intervencije = $moje_intervencije->fetch_all($single_karton_id);

    //GET INTERVENCIJE FOR SELECTED PACIJENT (MOBILE)
    $moje_intervencije_ = new myInterventions;
    $moje_intervencije_ = $moje_intervencije_->fetch_all($single_karton_id);

    //GET RAČUNI FOR SELECTED PACIJENT (DESKTOP)
    $moji_racuni = new mojiRacuni;
    $moji_racuni = $moji_racuni->fetch_all_moji_racuni($single_karton_id);

    //GET RAČUNI FOR SELECTED PACIJENT (MOBILE)
    $moji_racuni_ = new mojiRacuni;
    $moji_racuni_ = $moji_racuni_->fetch_all_moji_racuni($single_karton_id);

    //GET TERMINI FOR SELECTED PACIJENT (DESKTOP)
    $moji_termini = new mojiTermini;
    $moji_termini = $moji_termini->fetch_all_moji_termini($single_karton_id);

    //GET TERMINI FOR SELECTED PACIJENT (MOBILE)
    $moji_termini_ = new mojiTermini;
    $moji_termini_ = $moji_termini_->fetch_all_moji_termini($single_karton_id);

    //GET ALL TIPOVI INTERVENCIJA FOR SELECT BOX
    $tipovi_intervencija = new tipoviIntervencija;
    $tipovi_intervencija = $tipovi_intervencija->fetch_all_tipovi_intervencija();

    ?>

    <body>
        <!-- SIDEBAR -->
        <?php include_once ('includes/sidebar.php'); ?>

        <div class="wrapper d-flex flex-column bg-light">

            <!-- HEADER -->
            <?php include_once ('includes/header.php'); ?>

            <div class="body flex-grow-1 px-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 text-right" style="font-size: 14px; color:#3c4b64;">Pacijent:
                            <?php echo $karton_['kartonipacijenata_ime'] ?>
                            <?php echo $karton_['kartonipacijenata_prezime'] ?>
                        </div>
                        <div class="col-lg-12 text-right" style="font-size: 14px; color:#3c4b64;">Karton kreirao: Milan
                            Dakić</div>
                        <div class="col-lg-12 mb-3 text-right" style="font-size: 14px; color:#3c4b64;">Vrijeme kreiranja:
                            <?php echo date('d.m.Y. H:m:s', strtotime($karton_['kartonipacijenata_timestamp'])) ?>
                        </div>
                        <div class="col-lg-3">
                            <!-- Page Heading -->
                            <div class="d-flex align-items-center mb-4 sectionOpener sectionActive_" id="openerKarton">
                                <i class="fa-solid fa-file mr-2"></i>
                                <h5 class="ml-0 mb-0 text-gray-800">Karton pacijenta</h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex align-items-center mb-4 sectionOpener" id="openerIntervencije">
                                <i class="fa-solid fa-tooth mr-2"></i>
                                <h5 class="ml-0 mb-0 text-gray-800">Intervencije</h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex align-items-center mb-4 sectionOpener" id="openerRacuni">
                                <i class="fa-solid fa-receipt mr-2"></i>
                                <h5 class="ml-0 mb-0 text-gray-800">Računi</h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex align-items-center mb-4 sectionOpener" id="openerTermini">
                                <i class="fa-solid fa-calendar-check mr-2"></i>
                                <h5 class="ml-0 mb-0 text-gray-800">Termini</h5>
                            </div>
                        </div>
                    </div>

                    <!-- KARTON -->
                    <div class="row elementKarton elementActive_" id="elementKarton">
                        <div class="col-lg-12 desktop-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50%">Lični podaci:</th>
                                        <th scope="col" width="50%">Podaci o osiguranju:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $karton_['kartonipacijenata_ime'] ?>
                                            <?php if ($karton_['kartonipacijenata_roditelj'] != NULL) {
                                                echo "(" . $karton_['kartonipacijenata_roditelj'] . ")";
                                            } ?>
                                            <?php echo $karton_['kartonipacijenata_prezime'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Datum rođenja:
                                            <?php echo date('d.m.Y.', strtotime($karton_['kartonipacijenata_datumrodjenja'])) ?>
                                        </td>
                                        <td>Šifra obveznika: <?php echo $karton_['kartonipacijenata_sifraobveznika'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Matični broj: <?php echo $karton_['kartonipacijenata_maticnibroj'] ?></td>
                                        <td>Šifra djelatnosti: <?php echo $karton_['kartonipacijenata_sifradjelatnosti'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pol: <?php echo $karton_['kartonipacijenata_pol'] ?></td>
                                        <td>Ime nosioca: <?php echo $karton_['kartonipacijenata_imenosioca'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Zanimanje: <?php echo $karton_['kartonipacijenata_zanimanje'] ?></td>
                                        <td>Prezime nosioca: <?php echo $karton_['kartonipacijenata_prezimenosioca'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Doktor: <?php echo $karton_['kartonipacijenata_iddoktora'] ?></td>
                                        <td>Ime jednog roditelja:
                                            <?php echo $karton_['kartonipacijenata_imejednogroditelja'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Telefon: <?php echo $karton_['kartonipacijenata_telefon'] ?></td>
                                        <td>Matični broj nosioca:
                                            <?php echo $karton_['kartonipacijenata_maticnibrojnosioca'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>E-mail: <?php echo $karton_['kartonipacijenata_email'] ?></td>
                                        <td>Srodstvo sa nosiocem:
                                            <?php echo $karton_['kartonipacijenata_srodstvosanosiocem'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Adresa: <?php echo $karton_['kartonipacijenata_adresa'] ?>,
                                            <?php echo $karton_['kartonipacijenata_postanski'] ?>
                                            <?php echo $karton_['kartonipacijenata_grad'] ?>,
                                            <?php echo $karton_['kartonipacijenata_drzava'] ?>
                                        </td>
                                        <td>Naziv obveznika (firma):
                                            <?php echo $karton_['kartonipacijenata_nazivobveznikafirma'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Napomena: <?php echo $karton_['kartonipacijenata_napomena'] ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mobile-content">
                            <div>
                                <h3>Lični podaci:</h3>
                            </div>
                            <div><?php echo $karton_['kartonipacijenata_ime'] ?>
                                (<?php echo $karton_['kartonipacijenata_roditelj'] ?>)
                                <?php echo $karton_['kartonipacijenata_prezime'] ?>
                            </div>
                            <div>Datum rođenja:
                                <?php echo date('d.m.Y.', strtotime($karton_['kartonipacijenata_datumrodjenja'])) ?>
                            </div>
                            <div>Matični broj: <?php echo $karton_['kartonipacijenata_maticnibroj'] ?></div>
                            <div>Pol: <?php echo $karton_['kartonipacijenata_pol'] ?></div>
                            <div>Zanimanje: <?php echo $karton_['kartonipacijenata_zanimanje'] ?></div>
                            <div>Doktor: <?php echo $karton_['kartonipacijenata_iddoktora'] ?></div>
                            <div>Telefon: <?php echo $karton_['kartonipacijenata_telefon'] ?></div>
                            <div>E-mail: <?php echo $karton_['kartonipacijenata_email'] ?></div>
                            <div>Adresa: <?php echo $karton_['kartonipacijenata_adresa'] ?>,
                                <?php echo $karton_['kartonipacijenata_postanski'] ?>
                                <?php echo $karton_['kartonipacijenata_grad'] ?>,
                                <?php echo $karton_['kartonipacijenata_drzava'] ?>
                            </div>
                            <div>Napomena: <?php echo $karton_['kartonipacijenata_napomena'] ?></div>
                            <br />
                            <div>
                                <h3>Podaci o osiguranju:</h3>
                            </div>
                            <div>Broj zdravstvene: <?php echo $karton_['kartonipacijenata_brojzdravstvene'] ?></div>
                            <div>Šifra obveznika: <?php echo $karton_['kartonipacijenata_sifraobveznika'] ?></div>
                            <div>Šifra djelatnosti: <?php echo $karton_['kartonipacijenata_sifradjelatnosti'] ?></div>
                            <div>Ime nosioca: <?php echo $karton_['kartonipacijenata_imenosioca'] ?></div>
                            <div>Prezime nosioca: <?php echo $karton_['kartonipacijenata_prezimenosioca'] ?></div>
                            <div>Ime jednog roditelja: <?php echo $karton_['kartonipacijenata_imejednogroditelja'] ?></div>
                            <div>Matični broj nosioca: <?php echo $karton_['kartonipacijenata_maticnibrojnosioca'] ?></div>
                            <div>Srodstvo sa nosiocem: <?php echo $karton_['kartonipacijenata_srodstvosanosiocem'] ?></div>
                            <div>Naziv obveznika (firma): <?php echo $karton_['kartonipacijenata_nazivobveznikafirma'] ?>
                            </div>
                            <br />
                        </div>
                    </div>

                    <!-- INTERVENCIJE -->
                    <div class="row elementIntervencije" id="elementIntervencije">
                        <div class="col-lg-12 desktop-content">
                            <button type="button" class="btn btn-success mb-2" data-toggle="modal"
                                data-target="#insertIntervencijaModal">Dodaj intervenciju za pacijenta</button>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Ime i prezime pacijenta</th>
                                        <th scope="col">Ime doktora</th>
                                        <th scope="col">Zub</th>
                                        <th scope="col">Tip</th>
                                        <!-- <th scope="col">Slika</th> -->
                                        <th scope="col">Opis</th>
                                        <th scope="col">Datum</th>
                                        <th scope="col">Autor</th>
                                        <th scope="col">Datum unosa</th>
                                        <th scope="col">Detalji</th>
                                        <th scope="col">Uredi</th>
                                        <th scope="col">Obriši</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($moje_intervencije as $moja_intervencija) {

                                        //GET DOKTOR WHO DID THE INTERVENTION
                                        $moja_intervencija_id = intval($moja_intervencija['intervencije_iddoktora']);
                                        $singleuser = new singleUser;
                                        $singleuser = $singleuser->fetch_single_user($moja_intervencija_id);

                                        //GET TIP INTERVENCIJE
                                        $tip_intervencije_id = intval($moja_intervencija['intervencije_idtipa']);
                                        $sigle_tip_intervencije = new tipIntervencije;
                                        $sigle_tip_intervencije = $sigle_tip_intervencije->fetch_single_tip_intervencije($tip_intervencije_id);

                                        ?>
                                        <tr>
                                            <td style="vertical-align: middle;" scope="row">
                                                <?php echo $moja_intervencija['intervencije_id'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo $karton_['kartonipacijenata_ime'] . " " . $karton_['kartonipacijenata_prezime'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo $singleuser['user_ime'] . " " . $singleuser['user_prezime'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo $moja_intervencija['intervencije_zub'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo $sigle_tip_intervencije['tipoviintervencija_naziv'] ?>
                                            </td>
                                            <!-- <td style="vertical-align: middle;"><?php //if($moja_intervencija['intervencije_slika'] != "") { ?><img src="<?php //echo $moja_intervencija['intervencije_slika'] ?>" alt="" width="200px"><?php //} else { echo "Nema slike"; } ?></td> -->
                                            <td style="vertical-align: middle;">
                                                <?php echo $moja_intervencija['intervencije_opis'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo date('d.m.Y.', strtotime($moja_intervencija['intervencije_datum'])) ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo $moja_intervencija['intervencije_autor'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php echo date('d.m.Y. H:m:s', strtotime($moja_intervencija['intervencije_timestamp'])) ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <a
                                                    href="detalji-intervencije.php?intervencija=<?php echo $moja_intervencija['intervencije_id'] ?>"><i
                                                        class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                            </td>
                                            <td style="vertical-align: middle;"><a
                                                    href="uredi-intervenciju.php?intervencija=<?php echo $moja_intervencija['intervencije_id'] ?>"><i
                                                        class="fa-solid fa-pen"></i></a></td>
                                            <td style="vertical-align: middle;"><i class="fa-solid fa-trash"></i></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mobile-content">
                            <button type="button" class="btn btn-success mb-2" data-toggle="modal"
                                data-target="#insertIntervencijaModal">Dodaj intervenciju za pacijenta</button>
                            <?php foreach ($moje_intervencije_ as $moja_intervencija) {

                                //GET DOKTOR WHO DID THE INTERVENTION
                                $moja_intervencija_id = intval($moja_intervencija['intervencije_iddoktora']);
                                $singleuser = new singleUser;
                                $singleuser = $singleuser->fetch_single_user($moja_intervencija_id);

                                //GET TIP INTERVENCIJE
                                $tip_intervencije_id = intval($moja_intervencija['intervencije_idtipa']);
                                $sigle_tip_intervencije = new tipIntervencije;
                                $sigle_tip_intervencije = $sigle_tip_intervencije->fetch_single_tip_intervencije($tip_intervencije_id);

                                ?>
                                <div class="card border-dark mb-3">
                                    <div class="card-header bg-transparent border-dark">
                                        <h5 class="card-title mb-0">
                                            <?php echo $sigle_tip_intervencije['tipoviintervencija_naziv'] ?>
                                        </h5>
                                    </div>
                                    <div class="card-body text-dark">
                                        Pacijent:
                                        <?php echo $karton_['kartonipacijenata_ime'] . " " . $karton_['kartonipacijenata_prezime'] ?><br />
                                        Doktor: <?php echo $singleuser['user_ime'] . " " . $singleuser['user_prezime'] ?> <br />
                                        Zub(i): <?php echo $moja_intervencija['intervencije_zub'] ?> <br /><br />
                                        <?php if ($moja_intervencija['intervencije_slika'] != "") { ?><img
                                                src="<?php echo $moja_intervencija['intervencije_slika'] ?>" alt="" width="100%"><?php } else {
                                            echo "Nema slike";
                                        } ?><br />
                                        Tip: <?php echo $sigle_tip_intervencije['tipoviintervencija_naziv'] ?>
                                    </div>
                                    <div class="card-footer bg-transparent border-dark">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example"
                                            style="width:100%;">
                                            <button onclick="location.href='detalji-intervencije.php?intervencija=<?php echo $moja_intervencija['intervencije_id'] ?>'" class="btn btn-outline-info"
                                                type="button">Detalji</button>
                                            <button onclick="location.href='uredi-intervenciju.php?intervencija=<?php echo $moja_intervencija['intervencije_id'] ?>'" class="btn btn-outline-info"
                                                type="button">Uredi</button>
                                            <button class="btn btn-outline-info" type="button">Izbriši</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <!-- RAČUNI -->
                    <div class="row elementRacuni" id="elementRacuni">
                        <div class="col-lg-12 desktop-content">
                            <button type="button" class="btn btn-success mb-2" data-toggle="modal"
                                data-target="#insertRacunModal">Dodaj račun za pacijenta</button>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <!-- <th scope="col">ID intervencije</th> -->
                                        <!-- <th scope="col">ID pacijenta</th> -->
                                        <th scope="col">Ime i prezime pacijenta</th>
                                        <!-- <th scope="col">ID doktora</th> -->
                                        <th scope="col">Ime doktora</th>
                                        <th scope="col">Datum računa</th>
                                        <th scope="col">Iznos računa</th>
                                        <th scope="col">Vrsta plaćanja</th>
                                        <th scope="col">Uplaćeno</th>
                                        <th scope="col">Preostali dug</th>
                                        <th scope="col">Autor</th>
                                        <th scope="col">Datum unosa</th>
                                        <th scope="col">Detalji</th>
                                        <!-- <th scope="col">Uredi</th> -->
                                        <?php if ($_SESSION['user'] == "milan.dakic") { ?>
                                            <th scope="col">Obriši</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($moji_racuni as $moj_racun) {

                                        //GET DOKTOR WHO CREATED THE RAČUN
                                        $moj_racun_id = intval($moj_racun['racuni_iddoktora']);
                                        $singleuser_0 = new singleUser;
                                        $singleuser = $singleuser_0->fetch_single_user($moj_racun_id);

                                        //GET ALL UPLATE FOR THIS RAČUN
                                        $this_racun_id = $moj_racun['racuni_id'];
                                        $sve_uplate = new mojeUplate;
                                        $sve_uplate = $sve_uplate->fetch_all_moje_uplate($this_racun_id);

                                        $uplaceniIznos = 0;
                                        foreach ($sve_uplate as $sve_uplate_) {
                                            $uplaceniIznos = $uplaceniIznos + $sve_uplate_['uplate_iznos'];
                                        }
                                        $preostaliIznos = $moj_racun['racuni_iznos'] - $uplaceniIznos;

                                        ?>
                                        <tr style="<?php if ($uplaceniIznos == 0) {
                                            echo ("background: #ffbbbb;color:red;");
                                        } else if ($uplaceniIznos > 0 && $preostaliIznos > 0) {
                                            echo ("background: #ffe4b1;color: #c98200;");
                                        } else {
                                            echo ("background: #afffaf;color: #008300;");
                                        } ?>">
                                            <td style="vertical-align:middle" scope="row"><?php echo $moj_racun['racuni_id'] ?>
                                            </td>
                                            <td style="vertical-align:middle">
                                                <?php echo $karton_['kartonipacijenata_ime'] . " " . $karton_['kartonipacijenata_prezime'] ?>
                                            </td>
                                            <td style="vertical-align:middle">
                                                <?php echo $singleuser['user_ime'] . " " . $singleuser['user_prezime'] ?>
                                            </td>
                                            <td style="vertical-align:middle">
                                                <?php echo date('d.m.Y.', strtotime($moj_racun['racuni_datum'])) ?>
                                            </td>
                                            <td style="vertical-align:middle">
                                                <?php echo number_format($moj_racun['racuni_iznos'], 2, '.', '') ?> KM
                                            </td>
                                            <td style="vertical-align:middle"><?php echo $moj_racun['racuni_vrstaplacanja'] ?>
                                            </td>
                                            <td style="vertical-align:middle"><?php echo $uplaceniIznos . " KM" ?></td>
                                            <td style="vertical-align:middle"><?php echo $preostaliIznos . " KM" ?></td>
                                            <td style="vertical-align:middle"><?php echo $moj_racun['racuni_autor'] ?></td>
                                            <td style="vertical-align:middle">
                                                <?php echo date('d.m.Y. H:m:s', strtotime($moj_racun['racuni_timestamp'])) ?>
                                            </td>
                                            <td style="vertical-align:middle"><a
                                                    href="detalji-racuna.php?detaljiRacuna=<?php echo $moj_racun['racuni_id'] ?>">
                                                    <button type="button" class="btn btn-info"><i
                                                            class="fa-solid fa-arrow-up-right-from-square"></i> Detalji</button>
                                                </a></td>
                                            <!-- <td style="vertical-align:middle"><i class="fa-solid fa-user-pen"></i></td> -->
                                            <?php if ($_SESSION['user'] == "milan.dakic") { ?>
                                                <td style="vertical-align:middle">
                                                    <button type="button" class="btn btn-danger delete-object" data-toggle="modal"
                                                        data-target="#deleteRacuniModal"
                                                        dataID_="<?php echo $moj_racun['racuni_id'] ?>"
                                                        dataLink="pregled-racuna.php?deleteRacun=<?php echo $moj_racun['racuni_id'] ?>"><i
                                                            class="fa-solid fa-trash"></i> Izbriši</button>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mobile-content">
                            <?php foreach ($moji_racuni_ as $moj_racun) {

                                //GET DOKTOR WHO CREATED THE RAČUN
                                $moj_racun_id = intval($moj_racun['racuni_iddoktora']);
                                $singleuser_0 = new singleUser;
                                $singleuser = $singleuser_0->fetch_single_user($moj_racun_id);

                                //GET ALL UPLATE FOR THIS RAČUN
                                $this_racun_id = $moj_racun['racuni_id'];
                                $sve_uplate = new mojeUplate;
                                $sve_uplate = $sve_uplate->fetch_all_moje_uplate($this_racun_id);

                                $uplaceniIznos = 0;
                                foreach ($sve_uplate as $sve_uplate_) {
                                    $uplaceniIznos = $uplaceniIznos + $sve_uplate_['uplate_iznos'];
                                }
                                $preostaliIznos = $moj_racun['racuni_iznos'] - $uplaceniIznos;

                                ?>
                                <div class="card border-dark mb-3">
                                    <div class="card-header bg-transparent border-dark">
                                        <h5 class="card-title mb-0">
                                            <?php echo number_format($moj_racun['racuni_iznos'], 2, '.', '') ?> KM
                                        </h5>
                                    </div>
                                    <div class="card-body text-dark">
                                        Datum: <?php echo date('d.m.Y.', strtotime($moj_racun['racuni_datum'])) ?><br />
                                        Doktor: <?php echo $singleuser['user_ime'] . " " . $singleuser['user_prezime'] ?> <br />
                                        Vrsta plaćanja: <?php echo $moj_racun['racuni_vrstaplacanja'] ?> <br />
                                        Uplaćeno: <?php echo $uplaceniIznos . " KM" ?><br />
                                        Preostali dug: <?php echo $preostaliIznos . " KM" ?>
                                    </div>
                                    <div class="card-footer bg-transparent border-dark">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example"
                                            style="width:100%;">
                                            <button
                                                onclick="location.href='detalji-racuna.php?detaljiRacuna=<?php echo $moj_racun['racuni_id'] ?>'"
                                                class="btn btn-outline-info" type="button">Detalji</button>
                                            <button onclick="location.href=''" class="btn btn-outline-info"
                                                type="button">Uredi</button>
                                            <button class="btn btn-outline-info" type="button">Izbriši</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <!-- TERMINI -->
                    <div class="row elementTermini" id="elementTermini">
                        <div class="col-lg-12 desktop-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Ime i prezime pacijenta</th>
                                        <th scope="col">Ime doktora</th>
                                        <th scope="col">Datum termina</th>
                                        <th scope="col">Vrijeme termina</th>
                                        <th scope="col">Napomena</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Autor</th>
                                        <th scope="col">Datum unosa</th>
                                        <!-- <th scope="col">Pregled</th>
                                        <th scope="col">Obriši</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($moji_termini as $moj_termin) {

                                        //GET DOKTOR WHO CREATED THE RAČUN
                                        $moj_racun_id_doktora = intval($moj_termin['termini_iddoktora']);
                                        $singleuser_0 = new singleUser;
                                        $singleuser = $singleuser_0->fetch_single_user($moj_racun_id_doktora);

                                        ?>
                                        <tr>
                                            <td><?php echo $moj_termin['termini_id'] ?></td>
                                            <td><?php echo $karton_['kartonipacijenata_ime'] . " " . $karton_['kartonipacijenata_prezime'] ?>
                                            </td>
                                            <td><?php echo $singleuser['user_ime'] . " " . $singleuser['user_prezime'] ?></td>
                                            <td><?php echo date('d.m.Y.', strtotime($moj_termin['termini_datum'])) ?></td>
                                            <td><?php echo $moj_termin['termini_vrijeme'] ?></td>
                                            <td><?php echo $moj_termin['termini_napomena'] ?></td>
                                            <td><?php echo $moj_termin['termini_status'] ?></td>
                                            <td><?php echo $moj_termin['termini_autor'] ?></td>
                                            <td><?php echo date('d.m.Y. H:m:s', strtotime($moj_termin['termini_timestamp'])) ?>
                                            </td>
                                            <!-- <td><i class="fa-solid fa-arrow-up-right-from-square"></i></td>
                                        <td><i class="fa-solid fa-trash"></i></td> -->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mobile-content">
                            <?php foreach ($moji_termini_ as $moj_termin) {

                                //GET DOKTOR WHO CREATED THE RAČUN
                                $moj_racun_id_doktora = intval($moj_termin['termini_iddoktora']);
                                $singleuser_0 = new singleUser;
                                $singleuser = $singleuser_0->fetch_single_user($moj_racun_id_doktora);

                                ?>
                                <div class="card border-dark mb-3">
                                    <div class="card-header bg-transparent border-dark">
                                        <h5 class="card-title mb-0">
                                            <?php echo date('d.m.Y.', strtotime($moj_termin['termini_datum'])) ?> u
                                            <?php echo $moj_termin['termini_vrijeme'] ?>
                                        </h5>
                                    </div>
                                    <div class="card-body text-dark">
                                        <h5 class="card-title">
                                            <?php echo $karton_['kartonipacijenata_ime'] . " " . $karton_['kartonipacijenata_prezime'] ?>
                                        </h5>
                                        Datum rođenja:
                                        <?php echo date('d.m.Y.', strtotime($karton_['kartonipacijenata_datumrodjenja'])) ?><br />
                                        Telefon: <?php echo $karton_['kartonipacijenata_telefon'] ?><br />
                                        <p class="card-text">
                                            Doktor:
                                            <?php echo $singleuser['user_ime'] . " " . $singleuser['user_prezime'] ?><br />
                                            Napomena: <?php echo $moj_termin['termini_napomena'] ?><br />
                                            Kreirao: <?php echo $moj_termin['termini_autor'] ?><br />
                                            Datum unosa:
                                            <?php echo date('d.m.Y. H:m:s', strtotime($moj_termin['termini_timestamp'])) ?>
                                        </p>
                                    </div>
                                    <!-- <div class="card-footer bg-transparent border-dark">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                                    <button onclick="location.href='potvrdi-dolazak.php?potvrdiDolazak=<?php //echo($moj_termin['termini_id']); ?>'" class="btn btn-outline-info" type="button">Potvrdi</button>
                                    <button onclick="location.href='propusti-termin.php?propustiTermin=<?php //echo($moj_termin['termini_id']); ?>'" class="btn btn-outline-info" type="button">Propušten</button>
                                    <button onclick="location.href='otkazi-termin.php?otkaziTermin=<?php //echo($moj_termin['termini_id']); ?>'" class="btn btn-outline-info" type="button">Otkaži</button>
                                    </div>
                                </div> -->
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL INSTERT NEW INTERVENCIJA -->
        <div class="modal fade" id="insertIntervencijaModal" tabindex="-1" role="dialog"
            aria-labelledby="insertIntervencijaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 768px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertIntervencijaModalLabel">Dodaj tip intervencije</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="detalji-kartona.php?detaljiKartona=<?php echo $karton_['kartonipacijenata_id'] ?>"
                        method="post" enctype='multipart/form-data'>
                        <div class="modal-body pb-0 pt-0">
                            <div class="d-flex mb-3 d-flex flex-column">
                                <!-- ID PACIJENTA HIDDEN -->
                                <input name="intervencije_idpacijenta" type="number"
                                    value="<?php echo $karton_['kartonipacijenata_id'] ?>" hidden>
                                <!-- ID DOKTORA HIDDEN -->
                                <input name="intervencije_iddoktora" type="number"
                                    value="<?php echo $_SESSION['user_id'] ?>" hidden>
                                <!-- ZUB -->
                                <label class="mb-2 mr-2" for="intervencije_zub">Označite zub ili vilicu: </label>
                                <div class="d-flex justify-content-between checkboxesZubi">
                                    <input id="selektovaniZubi" type="text" hidden>
                                    <div class="d-flex flex-column align-items-center"><input
                                            style="-webkit-appearance: checkbox;width:20px;height:20px;"
                                            class="upisInputBefore" type="checkbox" value="Jedan zub">
                                        <p class="ml-1 mb-0 text-center">Jedan zub</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center"><input
                                            style="-webkit-appearance: checkbox;width:20px;height:20px;"
                                            class="upisInputBefore" type="checkbox" value="Više zuba">
                                        <p class="ml-1 mb-0 text-center">Više zuba</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center"><input
                                            style="-webkit-appearance: checkbox;width:20px;height:20px;"
                                            class="upisInputBefore" type="checkbox" value="Gornja vilica">
                                        <p class="ml-1 mb-0 text-center">Gornja vilica</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center"><input
                                            style="-webkit-appearance: checkbox;width:20px;height:20px;"
                                            class="upisInputBefore" type="checkbox" value="Donja vilica">
                                        <p class="ml-1 mb-0 text-center">Donja vilica</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center"><input
                                            style="-webkit-appearance: checkbox;width:20px;height:20px;"
                                            class="upisInputBefore" type="checkbox" value="Obje vilice">
                                        <p class="ml-1 mb-0 text-center">Obje vilice</p>
                                    </div>
                                </div>
                                <div class=" zubiSelekcija mb-3 mt-3">
                                    <div class="row raspored-zuba-selectable" style="max-width:768px;position:relative;">
                                        <div class="zubiOverlay">
                                            <p>Molimo označite polje "Jedan zub" ili "Više zuba" da biste selektovali zube.
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-around"
                                            style="border-right: 1px dashed #3d4eaf; border-bottom: 1px dashed #3d4eaf;width:50%;">
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="18" src="./img/zubi/18.png" style="width:100%">
                                                <p class="modalNumber" style="">18</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="17" src="./img/zubi/17.png" style="width:100%">
                                                <p class="modalNumber" style="">17</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="16" src="./img/zubi/16.png" style="width:100%">
                                                <p class="modalNumber" style="">16</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="15" src="./img/zubi/15.png" style="width:100%">
                                                <p class="modalNumber" style="">15</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="14" src="./img/zubi/14.png" style="width:100%">
                                                <p class="modalNumber" style="">14</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="13" src="./img/zubi/13.png" style="width:100%">
                                                <p class="modalNumber" style="">13</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="12" src="./img/zubi/12.png" style="width:100%">
                                                <p class="modalNumber" style="">12</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="11" src="./img/zubi/11.png" style="width:100%">
                                                <p class="modalNumber" style="">11</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around"
                                            style="border-bottom: 1px dashed #3d4eaf;width:50%;">
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="21" src="./img/zubi/21.png" style="width:100%">
                                                <p class="modalNumber" style="">21</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="22" src="./img/zubi/22.png" style="width:100%">
                                                <p class="modalNumber" style="">22</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="23" src="./img/zubi/23.png" style="width:100%">
                                                <p class="modalNumber" style="">23</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="24" src="./img/zubi/24.png" style="width:100%">
                                                <p class="modalNumber" style="">24</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="25" src="./img/zubi/25.png" style="width:100%">
                                                <p class="modalNumber" style="">25</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="26" src="./img/zubi/26.png" style="width:100%">
                                                <p class="modalNumber" style="">26</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="27" src="./img/zubi/27.png" style="width:100%">
                                                <p class="modalNumber" style="">27</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="28" src="./img/zubi/28.png" style="width:100%">
                                                <p class="modalNumber" style="">28</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around"
                                            style="border-right: 1px dashed #3d4eaf;width:50%;">
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="48" src="./img/zubi/48.png" style="width:100%">
                                                <p class="modalNumber" style="">48</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="47" src="./img/zubi/47.png" style="width:100%">
                                                <p class="modalNumber" style="">47</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="46" src="./img/zubi/46.png" style="width:100%">
                                                <p class="modalNumber" style="">46</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="45" src="./img/zubi/45.png" style="width:100%">
                                                <p class="modalNumber" style="">45</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="44" src="./img/zubi/44.png" style="width:100%">
                                                <p class="modalNumber" style="">44</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="43" src="./img/zubi/43.png" style="width:100%">
                                                <p class="modalNumber" style="">43</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="42" src="./img/zubi/42.png" style="width:100%">
                                                <p class="modalNumber" style="">42</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="41" src="./img/zubi/41.png" style="width:100%">
                                                <p class="modalNumber" style="">41</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around" style="width:50%;">
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="31" src="./img/zubi/31.png" style="width:100%">
                                                <p class="modalNumber" style="">31</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="32" src="./img/zubi/32.png" style="width:100%">
                                                <p class="modalNumber" style="">32</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="33" src="./img/zubi/33.png" style="width:100%">
                                                <p class="modalNumber" style="">33</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="34" src="./img/zubi/34.png" style="width:100%">
                                                <p class="modalNumber" style="">34</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="35" src="./img/zubi/35.png" style="width:100%">
                                                <p class="modalNumber" style="">35</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="36" src="./img/zubi/36.png" style="width:100%">
                                                <p class="modalNumber" style="">36</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="37" src="./img/zubi/37.png" style="width:100%">
                                                <p class="modalNumber" style="">37</p>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <img zubToSelect="38" src="./img/zubi/38.png" style="width:100%">
                                                <p class="modalNumber" style="">38</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ZUB -->
                                <div class="d-flex mt-3 mb-3">
                                    <span class="mr-1">Označeni zub: </span><span id="intervencije_zub"></span>
                                    <input name="intervencije_zub" type="text" value="" hidden>
                                </div>
                                <!-- TIP INTERVENCIJE -->
                                <label class="mb-0 mr-2" for="intervencije_naziv">Tip intervencije: </label>
                                <input name="intervencije_idtipa" type="text" value="" hidden>
                                <!-- <p id="intervencije_idtipa"></p> -->
                                <!-- <select class="gettingIdSelect" name="">
                                    <option value=""></option>
                                    <?php //foreach ($tipovi_intervencija as $tip_intervencije) { ?>
                                        <option value="<?php //echo ($tip_intervencije['tipoviintervencija_id']) ?>">
                                            <?php //echo ($tip_intervencije['tipoviintervencija_naziv']) ?>
                                        </option>
                                    <?php //} ?>
                                </select> -->
                                <div class="d-flex flex-wrap">
                                    <?php foreach ($tipovi_intervencija as $tip_intervencije) { ?>
                                        <div class="col-lg-4 px-0 py-1">
                                            <input type="checkbox" class="checkbox-tipintervencije"
                                                value="<?php echo ($tip_intervencije['tipoviintervencija_id']) ?>"
                                                style="padding: unset; -webkit-appearance: auto; min-height: auto;">
                                            <label
                                                for="vehicle1"><?php echo ($tip_intervencije['tipoviintervencija_naziv']) ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- OPIS INTERVENCIJE -->
                                <label for="intervencije_opis">Opis:</label>
                                <textarea name="intervencije_opis" id="" cols="30" rows="5"></textarea>
                                <!-- SLIKE INTERVENCIJE -->
                                <label for="intervencije_slika">Slika:</label>
                                <input type="file" name="files[]" id="addImageIntervencija">
                                <!-- DATUM INTERVENCIJE -->
                                <label for="intervencije_datum">Datum:</label>
                                <input type="date" name="intervencije_datum">
                                <!-- AUTOR INTERVENCIJE -->
                                <label class="mb-0" for="intervencije_autor">Autor:</label>
                                <input class="invisible-input pl-0" name="intervencije_autor" type="text" readonly
                                    value="<?php echo $_SESSION['user_ime'] . " " . $_SESSION['user_prezime'] ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                            <button type="submit" class="btn btn-primary" name="submit_intervencije">Sačuvaj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL INSTERT NEW RAČUN -->
        <div class="modal fade" id="insertRacunModal" tabindex="-1" role="dialog" aria-labelledby="insertRacunModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertRacunModalLabel">Dodaj račun pacijenta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="detalji-kartona.php?detaljiKartona=<?php echo $karton_['kartonipacijenata_id'] ?>"
                        method="post" enctype='multipart/form-data'>
                        <div class="modal-body pb-0 pt-0">
                            <div class="d-flex mb-3 d-flex flex-column">
                                <!-- IZABERITE INTERVENCIJU -->
                                <label class="mb-0 mr-2" for="intervencije_naziv">Izaberite intervenciju: </label>
                                <select name="racuni_idintervencije" id="">
                                    <option value=""></option>
                                    <?php foreach ($moje_intervencije as $moje_intervencije) { ?>
                                        <option value="<?php echo $moje_intervencije['intervencije_id'] ?>">
                                            <?php echo date('d.m.Y.', strtotime($moje_intervencije['intervencije_datum'])) ?>
                                            (ID: <?php echo $moje_intervencije['intervencije_id'] ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                                <!-- ID PACIJENTA HIDDEN -->
                                <input name="racuni_idpacijenta" type="number"
                                    value="<?php echo $karton_['kartonipacijenata_id'] ?>" hidden>
                                <!-- ID DOKTORA HIDDEN -->
                                <input name="racuni_iddoktora" type="number" value="<?php echo $_SESSION['user_id'] ?>"
                                    hidden>
                                <!-- DATUM RAČUNA -->
                                <label for="racuni_datum">Datum:</label>
                                <input type="date" name="racuni_datum">
                                <!-- IZNOS RAČUNA -->
                                <label for="racuni_iznos">Iznos računa:</label>
                                <input type="number" name="racuni_iznos">
                                <!-- VRSTA PLAĆANJA -->
                                <label for="racuni_vrstaplacanja">Vrsta plaćanja:</label>
                                <select name="racuni_vrstaplacanja" id="">
                                    <option value=""></option>
                                    <option value="Na rate">Na rate</option>
                                    <option value="Jednokratno">Jednokratno</option>
                                    <option value="Žiralno">Žiralno</option>
                                </select>
                                <input type="number" name="racuni_placeno" value="0" hidden>
                                <input type="number" name="racuni_djelimicnoplaceno" value="0" hidden>
                                <!-- AUTOR INTERVENCIJE -->
                                <label class="mb-0" for="racuni_autor">Autor:</label>
                                <input class="invisible-input pl-0" name="racuni_autor" type="text" readonly
                                    value="<?php echo $_SESSION['user_ime'] . " " . $_SESSION['user_prezime'] ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                            <button type="submit" class="btn btn-primary" name="submit_racuni">Sačuvaj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal delete RAČUN -->
        <div class="modal fade" id="deleteRacuniModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteRacuniModalModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteRacuniModalModalLabel">Izbriši račun</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Da li ste sigurni da želite izbrisati odabrani račun?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                        <a id="submit_delete_tip_intervencije" href="">
                            <button type="submit" class="btn btn-primary" name="submit_delete_racun">Izbriši</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .sectionOpener {
                cursor: pointer;
                background: #fff;
                border: 1px solid #3c4b64;
            }

            .sectionOpener i {
                background-color: #3c4b64;
                color: #fff !important;
                font-size: 20px;
                padding: 10px 15px;
                margin: 0;
            }

            .sectionOpener h5 {
                color: #3c4b64 !important;
            }

            .sectionOpener.sectionActive {
                background: #3c4b64;
            }

            .sectionOpener.sectionActive i {
                color: #3c4b64 !important;
                background-color: #fff;
            }

            .sectionOpener.sectionActive h5 {
                color: #fff !important;
            }

            .sectionOpener.sectionActive:hover i {
                color: #3c4b64 !important;
                background-color: #fff;
            }

            .sectionOpener:hover {
                background: #3c4b64;
            }

            .sectionOpener:hover i {
                color: #fff !important;
            }

            .sectionOpener:hover h5 {
                color: #fff !important;
            }

            /* .sectionOpener:hover h5{
                                color: #3c4b64!important;
                                } */

            .elementKarton,
            .elementIntervencije,
            .elementRacuni,
            .elementTermini {
                overflow: auto;
                max-height: 0;
                /* transition: max-height 0.1s ease-out; */
            }

            .elementActive {
                max-height: 100%;
            }

            /* .sectionOpener.sectionActive h5{
                                color: #3c4b64!important;
                                }

                                .sectionOpener.sectionActive:hover h5{
                                color: #5a5c69 !important;
                                } */

            input,
            select,
            textarea {
                border: 1px solid #ccc;
                border-radius: 5px;
                outline: none;
                padding: 0.2rem 0.3rem;
            }

            input::placeholder {
                color: #b9b9b9;
            }

            .invisible-input {
                border: none;
                outline: none;
            }

            table {
                font-size: 14px;
            }

            form {
                margin-bottom: 0;
            }

            th,
            td {
                text-align: center;
            }

            .zubiOverlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.75);
                z-index: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 24px;
                text-align: center;
                padding: 2rem;
            }

            .zubiSelekcija img {
                filter: drop-shadow(black 0px 0px 1px);
            }

            #insert_termin label {
                width: 30%;
                text-align: left;
                margin-right: 10px;
                font-size: 14px;
            }

            #insert_termin input,
            #insert_termin textarea,
            #insert_termin select {
                flex-grow: 1;
                font-size: 13px;
                border-radius: 5px;
                border: 1px solid #ccc;
                padding: 5px;
                margin: 10px 0;
            }

            #insert_termin .col-lg-3,
            #insert_termin .col-lg-4 {
                display: flex;
                align-items: stretch;
                flex-direction: column;
            }

            .modalNumber {
                font-size: 14px;
            }
        </style>

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