<?php 
    session_start();
    include_once("../connection.php");
    include_once('class/racuni.php');
    include_once('class/kartoni.php');
    include_once('class/users.php');
    include_once('includes/head.php'); 
    $_GET['administracija'] = 6; 
    //PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
    if(isset($_SESSION["logged_in"])){  

        //GET ALL RACUNI
        $allracuni = new allRacuni;
        $allracuni = $allracuni->fetch_all_racuni();

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

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0 text-gray-800">Pregled svih računa</h5>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table centeredTable">
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
                                <th scope="col">Izbriši</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($allracuni as $racun){ 
                                
                            //POKUPI PACIJENTA ČIJI JE RAČUN
                            $id_kartona = intval($racun['racuni_idpacijenta']); 
                            $karton = new singleKarton;
                            $karton = $karton->fetch_single_karton($id_kartona);

                            //POKUPI DOKTORA KOJI JE RADIO
                            $id_doktora = intval($racun['racuni_iddoktora']); 
                            $doktor = new singleUser;
                            $doktor = $doktor->fetch_single_user($id_doktora);

                            ?>
                            <tr>
                                <td scope="row"><?php echo $racun['racuni_id'] ?></td>
                                <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($racun['racuni_datum'])) ?></td>
                                <td><?php echo number_format($racun['racuni_iznos'],2,'.','') ?> KM</td>
                                <td><?php echo $racun['racuni_vrstaplacanja'] ?></td>
                                <td><?php if($racun['racuni_placeno'] == 0){echo "NE";}else{echo "DA";} ?></td>
                                <td><?php if($racun['racuni_djelimicnoplaceno'] == 0){echo "NE";}else{echo "DA";} ?></td>
                                <td><?php echo $racun['racuni_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($racun['racuni_timestamp'])) ?></td>
                                <td>
                                    <a class="clearCookieSectionActive" href="detalji-racuna.php?detaljiRacuna=<?php echo $racun['racuni_id'] ?>">
                                        <button type="button" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square"></i> Detalji</button>
                                    </a></td>
                                </td>
                                <td>
                                    <a href="uredi-racun.php?id=<?php echo $racun['racuni_id'] ?>">
                                        <button type="button" class="btn btn-warning"><i class="fa-solid fa-user-pen"></i> Uredi</button>
                                    </a>
                                </td>
                                <td>
                                    <button 
                                        type="button" 
                                        class="btn btn-danger delete-object"
                                        data-toggle="modal" 
                                        data-target="#deleteKartonipacijenataModal"
                                        dataID_="<?php echo $racun['racuni_id'] ?>"
                                        dataLink="pregled-kartona.php?delete_kartonipacijenata=<?php echo $racun['racuni_id'] ?>"
                                        ><i class="fa-solid fa-trash"></i> Izbriši</button>
                                </td>
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

<?php 
    include_once('includes/footer.php');
}else {  
    header("location:index.php");  
}  
?>