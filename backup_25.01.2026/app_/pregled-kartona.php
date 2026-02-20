<?php 
    //START SESSION
    session_start();
    //CONNECT TO DATABASE
    include_once("../connection.php");
    //GET CLASSES
    include_once('class/kartoni.php');
    include_once('class/users.php');
    //GET HEAD
    include_once('includes/head.php');
    //DEFINE SIDEBAR ACTIVE ITEM
    $_GET['administracija'] = 2; 

    //*****PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL*****//

    if(isset($_SESSION["logged_in"])){  
        
        //GET ALL KARTONI PACIJENATA
        $kartonipacijenata_0 = new kartoniPacijenata;
        $kartonipacijenata = $kartonipacijenata_0->fetch_all_kartonipacijenata();

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
                <h5 class="mb-0 text-gray-800">Pregled kartona</h5>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table centeredTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Ime</th>
                                <th scope="col">Ime roditelja</th>
                                <th scope="col">Prezime</th>
                                <th scope="col">Datum rođenja</th>
                                <th scope="col">Matični broj</th>
                                <th scope="col">Pol</th>
                                <th scope="col">Doktor</th>
                                <th scope="col">Telefon</th>
                                <th scope="col">Datum kreiranja</th>
                                <th scope="col">Detalji</th>
                                <th scope="col">Uredi</th>
                                <th scope="col">Obriši</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 

                            foreach($kartonipacijenata as $kartonpacijenta){ 
                            
                            //POKUPI DOKTORA
                            $single_user_id = intval($kartonpacijenta['kartonipacijenata_iddoktora']); 
                            $singleuser_0 = new singleUser;
                            $singleuser = $singleuser_0->fetch_single_user($single_user_id);
                                
                            ?>
                            <tr>
                                <td scope="row"><?php echo $kartonpacijenta['kartonipacijenata_id'] ?></td>
                                <td><?php echo $kartonpacijenta['kartonipacijenata_ime'] ?></td>
                                <td><?php echo $kartonpacijenta['kartonipacijenata_roditelj'] ?></td>
                                <td><?php echo $kartonpacijenta['kartonipacijenata_prezime'] ?></td>
                                <td><?php echo date('d.m.Y.',strtotime($kartonpacijenta['kartonipacijenata_datumrodjenja'])) ?></td>
                                <td><?php echo $kartonpacijenta['kartonipacijenata_maticnibroj'] ?></td>
                                <td><?php echo $kartonpacijenta['kartonipacijenata_pol'] ?></td>
                                <td><?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?></td>
                                <td><?php echo $kartonpacijenta['kartonipacijenata_telefon'] ?></td>
                                <td><?php echo date('d.m.Y. H:m:s',strtotime($kartonpacijenta['kartonipacijenata_timestamp'])) ?></td>
                                <td>
                                    <a class="clearCookieSectionActive" href="detalji-kartona.php?detaljiKartona=<?php echo $kartonpacijenta['kartonipacijenata_id'] ?>">
                                        <button type="button" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square"></i> Detalji</button>
                                    </a></td>
                                <td>
                                    <a href="uredi-karton.php?id=<?php echo $kartonpacijenta['kartonipacijenata_id'] ?>">
                                        <button type="button" class="btn btn-warning"><i class="fa-solid fa-user-pen"></i> Uredi</button>
                                    </a>
                                </td>
                                <td>
                                    <button 
                                        type="button" 
                                        class="btn btn-danger delete-object"
                                        data-toggle="modal" 
                                        data-target="#deleteKartonipacijenataModal"
                                        dataID_="<?php echo $kartonpacijenta['kartonipacijenata_id'] ?>"
                                        dataLink="pregled-kartona.php?delete_kartonipacijenata=<?php echo $kartonpacijenta['kartonipacijenata_id'] ?>"
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

    <!-- Modal delete -->
    <div class="modal fade" id="deleteKartonipacijenataModal" tabindex="-1" role="dialog" aria-labelledby="deleteKartonipacijenataModalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteKartonipacijenataModalModalLabel">Izbriši tip intervencije</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Da li ste sigurni da želite izbrisati odabrani karton pacijenta?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                    <a id="submit_delete_tip_intervencije" href="">
                        <button type="submit" class="btn btn-primary" name="submit_delete_kartoniradnika">Izbriši</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php 
    include_once('includes/footer.php');
}else {  
    header("location:index.php");  
}  
?>