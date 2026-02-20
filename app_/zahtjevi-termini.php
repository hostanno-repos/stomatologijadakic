<?php 
    session_start();
    include_once("../connection.php");
    include_once('class/termini.php');
    include_once('class/kartoni.php');
    include_once('class/users.php');
    include_once('includes/head.php'); 
    $_GET['administracija'] = 3; 
    //PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
    if(isset($_SESSION["logged_in"])){  

        $zahtjevi = new zahtjeviTermini;
        $zahtjevi = $zahtjevi->fetch_all_zahtjevi();

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
                <h5 class="mb-0 text-gray-800">Pregled zahtjeva za termin</h5>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table centeredTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Ime i prezime pacijenta</th>
                                <th scope="col">Broj telefona pacijenta</th>
                                <th scope="col">Ime doktora</th>
                                <th scope="col">Datum termina</th>
                                <th scope="col">Vrijeme termina</th>
                                <th scope="col">Napomena</th>
                                <th scope="col">Status</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Datum unosa</th>
                                <th scope="col">Odobreno</th>
                                <th scope="col">Odbijeno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            foreach($zahtjevi as $zahtjevi){ 

                                $id_kartona = intval($zahtjevi['termini_idpacijenta']);
                                $karton = new singleKarton;
                                $karton = $karton->fetch_single_karton($id_kartona);
                                
                                $id_kdoktora = intval($zahtjevi['termini_iddoktora']);
                                $doktor = new singleUser;
                                $doktor = $doktor->fetch_single_user($id_kdoktora);

                            ?>
                            <tr>
                                <td scope="row"><?php echo $zahtjevi['termini_id'] ?></td>
                                <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($zahtjevi['termini_datum'])) ?></td>
                                <td><?php echo $zahtjevi['termini_vrijeme'] ?></td>
                                <td><?php echo $zahtjevi['termini_napomena'] ?></td>
                                <td><?php echo $zahtjevi['termini_status'] ?></td>
                                <td><?php echo $zahtjevi['termini_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($zahtjevi['termini_timestamp'])) ?></td>
                                <td><a href="odobriTermin.php?idtermina=<?php echo($zahtjevi['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="odbijTermin.php?idtermina=<?php echo($zahtjevi['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
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