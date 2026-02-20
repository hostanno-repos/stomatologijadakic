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

        $zakazani = new zakazaniTermini;
        $zakazani = $zakazani->fetch_all_zakazani();

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
                <h5 class="mb-0 text-gray-800">Pregled zakazanih termina</h5>
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
                                <th scope="col">Potvrdi dolazak</th>
                                <th scope="col">Propušten termin</th>
                                <th scope="col">Otkaži</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            foreach($zakazani as $zakazani){ 

                                $id_kartona = intval($zakazani['termini_idpacijenta']);
                                $karton = new singleKarton;
                                $karton = $karton->fetch_single_karton($id_kartona);
                                
                                $id_kdoktora = intval($zakazani['termini_iddoktora']);
                                $doktor = new singleUser;
                                $doktor = $doktor->fetch_single_user($id_kdoktora);

                            ?>
                            <tr>
                                <td scope="row"><?php echo $zakazani['termini_id'] ?></td>
                                <td><?php echo $karton['kartonipacijenata_ime']." ".$karton['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo $karton['kartonipacijenata_telefon'] ?></td>
                                <td><?php echo $doktor['user_ime']." ".$doktor['user_prezime'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($zakazani['termini_datum'])) ?></td>
                                <td><?php echo $zakazani['termini_vrijeme'] ?></td>
                                <td><?php echo $zakazani['termini_napomena'] ?></td>
                                <td><?php echo $zakazani['termini_status'] ?></td>
                                <td><?php echo $zakazani['termini_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($zakazani['termini_timestamp'])) ?></td>
                                <td><a href="potvrdiDolazak.php?idtermina=<?php echo($zakazani['termini_id']); ?>"><i class="fa-solid fa-check"></i></a></td>
                                <td><a href="propustenTermin.php?idtermina=<?php echo($zakazani['termini_id']); ?>"><i class="fa-solid  fa-minus"></i></a></td>
                                <td><a href="otkaziTermin.php?idtermina=<?php echo($zakazani['termini_id']); ?>"><i class="fa-solid fa-xmark"></i></a></td>
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