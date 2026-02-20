<?php 
    session_start();
    include_once("../connection.php");
    include_once('class/kartoni.php');
    include_once('class/intervencije.php');
    include_once('class/users.php');
    include_once('includes/head.php'); 
    $_GET['administracija'] = 5; 
    //PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
    if(isset($_SESSION["logged_in"])){  

        //GET INTERVENCIJE FOR SELECTED PACIJENT
        $sve_intervencije = new allInterventions;
        $sve_intervencije = $sve_intervencije->fetch_all_intervencije();

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
                <h5 class="mb-0 text-gray-800">Pregled svih intervencija</h5>
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
                                <th scope="col">Zub</th>
                                <th scope="col">Tip</th>
                                <th scope="col">Opis</th>
                                <th scope="col">Datum</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Datum unosa</th>
                                <th scope="col">Uredi</th>
                                <th scope="col">Obriši</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sve_intervencije as $intervencija){ 
                                
                            //GET PACIJENT
                            $pacijent_id = intval($intervencija['intervencije_idpacijenta']); 
                            $singlekarton= new singleKarton;
                            $singlekarton = $singlekarton->fetch_single_karton($pacijent_id);

                            //GET DOKTOR WHO DID THE INTERVENTION
                            $intervencija_id = intval($intervencija['intervencije_iddoktora']); 
                            $singleuser = new singleUser;
                            $singleuser = $singleuser->fetch_single_user($intervencija_id);

                            ?>
                            <tr>
                                <td scope="row"><?php echo $intervencija['intervencije_id'] ?></td>
                                <!-- <td><?php //echo $racun_['racuni_id_intervencije'] ?></td> -->
                                <!-- <td><?php //echo $racun_['racuni_id_pacijenta'] ?></td> -->
                                <td><?php echo $singlekarton['kartonipacijenata_ime']." ".$singlekarton['kartonipacijenata_prezime'] ?></td>
                                <!-- <td><?php //echo $racun_['racuni_id_doktora'] ?></td> -->
                                <td><?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?></td>
                                <td><?php echo $intervencija['intervencije_zub'] ?></td>
                                <td><?php echo $intervencija['intervencije_idtipa'] ?></td>
                                <td><?php echo $intervencija['intervencije_opis'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($intervencija['intervencije_datum'])) ?></td>
                                <td><?php echo $intervencija['intervencije_autor'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($intervencija['intervencije_timestamp'])) ?></td>
                                <td><i class="fa-solid fa-user-pen"></i></td>
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

<?php 
    include_once('includes/footer.php');
}else {  
    header("location:index.php");  
}  
?>