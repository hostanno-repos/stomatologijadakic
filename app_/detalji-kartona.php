<?php 
    session_start();
    include_once("../connection.php");
    include_once('class/kartoni.php');
    include_once('class/intervencije.php');
    include_once('class/racuni.php');
    include_once('class/termini.php');
    include_once('class/users.php');
    include_once('includes/head.php'); 
    $_GET['administracija'] = 2; 
    //PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
    if(isset($_SESSION["logged_in"])){  

        //GET SINGLE KARTON
        $single_karton_id = $_GET['detaljiKartona'];
        $kartoni_ = new singleKarton;
        $karton_ = $kartoni_->fetch_single_karton($single_karton_id);

        //GET INTERVENCIJE FOR SELECTED PACIJENT
        $moje_intervencije = new myInterventions;
        $moje_intervencije = $moje_intervencije->fetch_all($single_karton_id);

        //GET RAČUNI FOR SELECTED PACIJENT
        $moji_racuni = new mojiRacuni;
        $moji_racuni = $moji_racuni->fetch_all_moji_racuni($single_karton_id);

        //GET TERMINI FOR SELECTED PACIJENT
        $moji_termini = new mojiTermini;
        $moji_termini = $moji_termini->fetch_all_moji_termini($single_karton_id);

        //GET ALL TIPOVI INTERVENCIJA FOR SELECT BOX
        $tipovi_intervencija = new tipoviIntervencija;
        $tipovi_intervencija = $tipovi_intervencija->fetch_all_tipovi_intervencija();

?>

<!-- Page Wrapper -->
<div id="wrapper">

<?php include_once('includes/sidebar.php') ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php include_once('includes/header.php') ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12 text-right" style="font-size: 14px; color:var(--blue);">Pacijent: <?php echo $karton_['kartonipacijenata_ime'] ?> <?php echo $karton_['kartonipacijenata_prezime'] ?></div>
                <div class="col-lg-12 text-right" style="font-size: 14px; color:var(--blue);">Karton kreirao: Milan Dakić</div>
                <div class="col-lg-12 mb-3 text-right" style="font-size: 14px; color:var(--blue);">Vrijeme kreiranja: <?php echo date('d.m.Y. H:m:s',strtotime($karton_['kartonipacijenata_timestamp'])) ?></div>
                <div class="col-lg-3">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center mb-4 sectionOpener sectionActive_" id="openerKarton">
                        <i class="fa-solid fa-file mr-2"></i>
                        <h5 class="ml-0 mb-0 text-gray-800">Karton pacijenta</h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-sm-flex align-items-center mb-4 sectionOpener" id="openerIntervencije">
                        <i class="fa-solid fa-tooth mr-2"></i> 
                        <h5 class="ml-0 mb-0 text-gray-800">Intervencije</h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-sm-flex align-items-center mb-4 sectionOpener" id="openerRacuni">
                        <i class="fa-solid fa-receipt mr-2"></i> 
                        <h5 class="ml-0 mb-0 text-gray-800">Računi</h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-sm-flex align-items-center mb-4 sectionOpener" id="openerTermini">
                        <i class="fa-solid fa-calendar-check mr-2"></i> 
                        <h5 class="ml-0 mb-0 text-gray-800">Termini</h5>
                    </div>
                </div>
            </div>
            
            <!-- KARTON -->
            <div class="row elementKarton elementActive_" id="elementKarton">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="50%">Lični podaci:</th>
                                <th scope="col" width="50%">Podaci o osiguranju:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $karton_['kartonipacijenata_ime'] ?> (<?php echo $karton_['kartonipacijenata_roditelj'] ?>) <?php echo $karton_['kartonipacijenata_prezime'] ?></td>
                                <td>Broj zdravstvene: <?php echo $karton_['kartonipacijenata_brojzdravstvene'] ?></td>
                            </tr>
                            <tr>
                                <td>Datum rođenja: <?php echo date('d.m.Y.',strtotime($karton_['kartonipacijenata_datumrodjenja'])) ?></td>
                                <td>Šifra obveznika: <?php echo $karton_['kartonipacijenata_sifraobveznika'] ?></td>
                            </tr>
                            <tr>
                                <td>Matični broj: <?php echo $karton_['kartonipacijenata_maticnibroj'] ?></td>
                                <td>Šifra djelatnosti: <?php echo $karton_['kartonipacijenata_sifradjelatnosti'] ?></td>
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
                                <td>Ime jednog roditelja: <?php echo $karton_['kartonipacijenata_imejednogroditelja'] ?></td>
                            </tr>
                            <tr>
                                <td>Telefon: <?php echo $karton_['kartonipacijenata_telefon'] ?></td>
                                <td>Matični broj nosioca: <?php echo $karton_['kartonipacijenata_maticnibrojnosioca'] ?></td>
                            </tr>
                            <tr>
                                <td>E-mail: <?php echo $karton_['kartonipacijenata_email'] ?></td>
                                <td>Srodstvo sa nosiocem: <?php echo $karton_['kartonipacijenata_srodstvosanosiocem'] ?></td>
                            </tr>
                            <tr>
                                <td>Adresa: <?php echo $karton_['kartonipacijenata_adresa'] ?>, <?php echo $karton_['kartonipacijenata_postanski'] ?> <?php echo $karton_['kartonipacijenata_grad'] ?>, <?php echo $karton_['kartonipacijenata_drzava'] ?></td>
                                <td>Naziv obveznika (firma): <?php echo $karton_['kartonipacijenata_nazivobveznikafirma'] ?></td>
                            </tr>
                            <tr>
                                <td>Napomena: <?php echo $karton_['kartonipacijenata_napomena'] ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- INTERVENCIJE -->
            <div class="row elementIntervencije" id="elementIntervencije">
                <div class="col-lg-12">
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#insertIntervencijaModal">Dodaj intervenciju za pacijenta</button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Ime i prezime pacijenta</th>
                                <th scope="col">Ime doktora</th>
                                <th scope="col">Zub</th>
                                <th scope="col">Tip</th>
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
                            <?php foreach($moje_intervencije as $moja_intervencija) {

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
                                <td scope="row"><?php echo $moja_intervencija['intervencije_id'] ?></td>
                                <td><?php echo $karton_['kartonipacijenata_ime']." ".$karton_['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?></td>
                                <td><?php echo $moja_intervencija['intervencije_zub'] ?></td>
                                <td><?php echo $sigle_tip_intervencije['tipoviintervencija_naziv'] ?></td>
                                <td><?php echo $moja_intervencija['intervencije_opis'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($moja_intervencija['intervencije_datum'])) ?></td>
                                <td><?php echo $moja_intervencija['intervencije_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($moja_intervencija['intervencije_timestamp'])) ?></td>
                                <td><i class="fa-solid fa-arrow-up-right-from-square"></i></td>
                                <td><i class="fa-solid fa-user-pen"></i></td>
                                <td><i class="fa-solid fa-trash"></i></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <!-- RAČUNI -->
            <div class="row elementRacuni" id="elementRacuni">
                <div class="col-lg-12">
                    <button type="button" class="btn btn-success mb-2">Dodaj račun za pacijenta</button>
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
                                <th scope="col">Plaćeno</th>
                                <th scope="col">Djelimično plaćeno</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Datum unosa</th>
                                <th scope="col">Detalji</th>
                                <th scope="col">Uredi</th>
                                <th scope="col">Obriši</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($moji_racuni as $moj_racun) { 
                            
                            //GET DOKTOR WHO CREATED THE RAČUN
                            $moj_racun_id = intval($moj_racun['racuni_iddoktora']); 
                            $singleuser_0 = new singleUser;
                            $singleuser = $singleuser_0->fetch_single_user($moj_racun_id);
                                
                            ?>
                            <tr style="<?php if($moj_racun['racuni_placeno'] == 0 && $moj_racun['racuni_djelimicnoplaceno'] == 0){ echo("background: #ffbbbb;color:red;"); }else if($moj_racun['racuni_placeno'] == 0 && $moj_racun['racuni_djelimicnoplaceno'] == 1){echo("background: #ffe4b1;
                                color: #c98200;"); }else{echo("background: #afffaf;color: #008300;");} ?>">
                                <td scope="row"><?php echo $moj_racun['racuni_id'] ?></td>
                                <td><?php echo $karton_['kartonipacijenata_ime']." ".$karton_['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($moj_racun['racuni_datum'])) ?></td>
                                <td><?php echo number_format($moj_racun['racuni_iznos'],2,'.','') ?> KM</td>
                                <td><?php echo $moj_racun['racuni_vrstaplacanja'] ?></td>
                                <td><?php if($moj_racun['racuni_placeno'] == 0){echo "NE";}else{echo "DA";} ?></td>
                                <td><?php if($moj_racun['racuni_djelimicnoplaceno'] == 0){echo "NE";}else{echo "DA";} ?></td>
                                <td><?php echo $moj_racun['racuni_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($moj_racun['racuni_timestamp'])) ?></td>
                                <td><i class="fa-solid fa-arrow-up-right-from-square"></i></td>
                                <td><i class="fa-solid fa-user-pen"></i></td>
                                <td><i class="fa-solid fa-trash"></i></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <!-- TERMINI -->
            <div class="row elementTermini" id="elementTermini">
                <div class="col-lg-12">
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
                                <th scope="col">Pregled</th>
                                <th scope="col">Obriši</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($moji_termini as $moj_termin) { 
                            
                            //GET DOKTOR WHO CREATED THE RAČUN
                            $moj_racun_id_doktora = intval($moj_termin['termini_iddoktora']); 
                            $singleuser_0 = new singleUser;
                            $singleuser = $singleuser_0->fetch_single_user($moj_racun_id_doktora);
                                
                            ?>
                            <tr>
                                <td><?php echo $moj_termin['termini_id'] ?></td>
                                <td><?php echo $karton_['kartonipacijenata_ime']." ".$karton_['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($moj_termin['termini_datum'])) ?></td>
                                <td><?php echo $moj_termin['termini_vrijeme'] ?></td>
                                <td><?php echo $moj_termin['termini_napomena'] ?></td>
                                <td><?php echo $moj_termin['termini_status'] ?></td>
                                <td><?php echo $moj_termin['termini_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($moj_termin['termini_timestamp'])) ?></td>
                                <td><i class="fa-solid fa-arrow-up-right-from-square"></i></td>
                                <td><i class="fa-solid fa-trash"></i></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <style>
        #elementKarton th,
        #elementKarton td{
            text-align: left;
        }
        .zubiSelekcija img{
            filter: drop-shadow(0px 0px 1px black);
            cursor: pointer;
        }
        .zubiSelekcija img:hover{
            filter: invert(0.5);
        }
    </style>

    <!-- MODALS START -->

    <!-- MODAL INSTERT NEW INTERVENCIJA -->
    <div class="modal fade" id="insertIntervencijaModal" tabindex="-1" role="dialog" aria-labelledby="insertIntervencijaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertIntervencijaModalLabel">Dodaj tip intervencije</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="detalji-kartona.php?detaljiKartona=<?php echo $karton_['kartonipacijenata_id'] ?>" method="post" enctype='multipart/form-data'>
                <div class="modal-body pb-0 pt-0">
                    <div class="d-flex mb-3 d-flex flex-column">
                        <!-- ID PACIJENTA HIDDEN -->
                        <input name="intervencije_idpacijenta" type="number" value="<?php echo $karton_['kartonipacijenata_id'] ?>" hidden>
                        <!-- ID DOKTORA HIDDEN -->
                        <input name="intervencije_iddoktora" type="number" value="<?php echo $_SESSION['user_id'] ?>" hidden>
                        <!-- ZUB -->
                        <label class="mb-2 mr-2" for="intervencije_zub">Označite zub ili vilicu: </label>
                        <div class="d-flex justify-content-between checkboxesZubi">
                            <div class="d-flex"><input type="checkbox" value="Jedan zub"><p class="ml-1 mb-0">Jedan zub</p></div>
                            <div class="d-flex"><input type="checkbox" value="Gornja vilica"><p class="ml-1 mb-0">Gornja vilica</p></div>
                            <div class="d-flex"><input type="checkbox" value="Donja vilica"><p class="ml-1 mb-0">Donja vilica</p></div>
                            <div class="d-flex"><input type="checkbox" value="Obje vilice"><p class="ml-1 mb-0">Obje vilice</p> </div>
                        </div>
                        <div class=" zubiSelekcija mb-3 mt-3">
                            <div class="row raspored-zuba-selectable" style="max-width:768px;position:relative;">
                                <div class="zubiOverlay">
                                    <p>Molimo označite polje "Jedan zub" da biste selektovali određeni zub.</p>
                                </div>
                                <div class="col-xl-6 d-flex justify-content-around" style="border-right: 1px dashed #3d4eaf">
                                    <img zubToSelect="18" src="./img/zubi/18.png" style="width:calc(100%/8)">
                                    <img zubToSelect="17" src="./img/zubi/17.png" style="width:calc(100%/8)">
                                    <img zubToSelect="16" src="./img/zubi/16.png" style="width:calc(100%/8)">
                                    <img zubToSelect="15" src="./img/zubi/15.png" style="width:calc(100%/8)">
                                    <img zubToSelect="14" src="./img/zubi/14.png" style="width:calc(100%/8)">
                                    <img zubToSelect="13" src="./img/zubi/13.png" style="width:calc(100%/8)">
                                    <img zubToSelect="12" src="./img/zubi/12.png" style="width:calc(100%/8)">
                                    <img zubToSelect="11" src="./img/zubi/11.png" style="width:calc(100%/8)">
                                </div>
                                <div class="col-xl-6 d-flex justify-content-around">
                                    <img zubToSelect="21" src="./img/zubi/21.png" style="width:calc(100%/8)">
                                    <img zubToSelect="22" src="./img/zubi/22.png" style="width:calc(100%/8)">
                                    <img zubToSelect="23" src="./img/zubi/23.png" style="width:calc(100%/8)">
                                    <img zubToSelect="24" src="./img/zubi/24.png" style="width:calc(100%/8)">
                                    <img zubToSelect="25" src="./img/zubi/25.png" style="width:calc(100%/8)">
                                    <img zubToSelect="26" src="./img/zubi/26.png" style="width:calc(100%/8)">
                                    <img zubToSelect="27" src="./img/zubi/27.png" style="width:calc(100%/8)">
                                    <img zubToSelect="28" src="./img/zubi/28.png" style="width:calc(100%/8)">
                                </div>
                                <div class="col-xl-6 d-flex justify-content-around" style="border-right: 1px dashed #3d4eaf; border-bottom: 1px dashed #3d4eaf;">
                                    <p style="">18</p>
                                    <p style="">17</p>
                                    <p style="">16</p>
                                    <p style="">15</p>
                                    <p style="">14</p>
                                    <p style="">13</p>
                                    <p style="">12</p>
                                    <p style="">11</p>
                                </div>
                                <div class="col-xl-6 d-flex justify-content-around" style="border-bottom: 1px dashed #3d4eaf;">
                                    <p style="">21</p>
                                    <p style="">22</p>
                                    <p style="">23</p>
                                    <p style="">24</p>
                                    <p style="">25</p>
                                    <p style="">26</p>
                                    <p style="">27</p>
                                    <p style="">28</p>
                                </div>
                                
                                <div class="col-xl-6 d-flex justify-content-around" style="border-right: 1px dashed #3d4eaf">
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">48</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">47</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">46</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">45</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">44</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">43</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">42</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">41</p>
                                </div>
                                <div class="col-xl-6 d-flex justify-content-around">
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">31</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">32</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">33</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">34</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">35</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">36</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">37</p>
                                    <p style="margin-bottom:0!important; margin-top: 1rem;">38</p>
                                </div>
                                <div class="col-xl-6 d-flex justify-content-around" style="border-right: 1px dashed #3d4eaf">
                                    <img zubToSelect="48" src="./img/zubi/48.png" style="width:calc(100%/8)">
                                    <img zubToSelect="47" src="./img/zubi/47.png" style="width:calc(100%/8)">
                                    <img zubToSelect="46" src="./img/zubi/46.png" style="width:calc(100%/8)">
                                    <img zubToSelect="45" src="./img/zubi/45.png" style="width:calc(100%/8)">
                                    <img zubToSelect="44" src="./img/zubi/44.png" style="width:calc(100%/8)">
                                    <img zubToSelect="43" src="./img/zubi/43.png" style="width:calc(100%/8)">
                                    <img zubToSelect="42" src="./img/zubi/42.png" style="width:calc(100%/8)">
                                    <img zubToSelect="41" src="./img/zubi/41.png" style="width:calc(100%/8)">
                                </div>
                                <div class="col-xl-6 d-flex justify-content-around">
                                    <img zubToSelect="31" src="./img/zubi/31.png" style="width:calc(100%/8)">
                                    <img zubToSelect="32" src="./img/zubi/32.png" style="width:calc(100%/8)">
                                    <img zubToSelect="33" src="./img/zubi/33.png" style="width:calc(100%/8)">
                                    <img zubToSelect="34" src="./img/zubi/34.png" style="width:calc(100%/8)">
                                    <img zubToSelect="35" src="./img/zubi/35.png" style="width:calc(100%/8)">
                                    <img zubToSelect="36" src="./img/zubi/36.png" style="width:calc(100%/8)">
                                    <img zubToSelect="37" src="./img/zubi/37.png" style="width:calc(100%/8)">
                                    <img zubToSelect="38" src="./img/zubi/38.png" style="width:calc(100%/8)">
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
                        <input name="intervencije_idtipa" type="number" value="" hidden>
                        <select class="gettingIdSelect" name="">
                            <option value=""></option>
                            <?php foreach($tipovi_intervencija as $tip_intervencije) { ?>
                                <option value="<?php echo($tip_intervencije['tipoviintervencija_id']) ?>"><?php echo($tip_intervencije['tipoviintervencija_naziv']) ?></option>
                            <?php } ?>
                        </select>
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
                        <input class="invisible-input pl-0" name="intervencije_autor" type="text" readonly value="<?php echo $_SESSION['user_ime']." ".$_SESSION['user_prezime'] ?>">
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


    <!-- MODALS END -->
<?php 
    include_once('includes/footer.php');
}else {  
    header("location:index.php");  
}  
?>