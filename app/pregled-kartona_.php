<?php 
session_start();
include_once('../connection.php'); 
include_once('./class/termini.php');
include_once('./class/kartoni.php');
include_once('./class/users.php');
include_once('includes/head.php');

$now = time();
if(isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']){

//GET ALL KARTONI PACIJENATA DESKTOP
$kartonipacijenata_0 = new kartoniPacijenata;
$kartonipacijenata = $kartonipacijenata_0->fetch_all_kartonipacijenata();
//GET ALL KARTONI PACIJENATA MOBILE
$kartonipacijenata_1 = new kartoniPacijenata;
$kartonipacijenata_2 = $kartonipacijenata_1->fetch_all_kartonipacijenata();


?>

  <body>
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php'); ?>

    <div class="wrapper d-flex flex-column bg-light">

      <!-- HEADER -->
      <?php include_once('includes/header.php'); ?>

      <div class="body flex-grow-1 px-3">
        <div class="container-fluid">
            <div class="row desktop-content">
                <h4 class="ms-2 mb-3">PREGLED KARTONA</h4>
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
                                <td><?php if($kartonpacijenta['kartonipacijenata_datumrodjenja'] != NULL){echo date('d.m.Y.',strtotime($kartonpacijenta['kartonipacijenata_datumrodjenja'])); } ?></td>
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
            <div class="row mobile-content">
            <?php foreach($kartonipacijenata_2 as $kartonipacijenata_2){ 
            
            $single_user_id = intval($kartonipacijenata_2['kartonipacijenata_iddoktora']); 
            $singleuser_0 = new singleUser;
            $singleuser = $singleuser_0->fetch_single_user($single_user_id);
                
            ?>
            <div class="col-lg-12">
                <div class="card border-dark mb-3">
                    <div class="card-header bg-transparent border-dark">
                        <h5 class="card-title mb-0"><?php echo $kartonipacijenata_2['kartonipacijenata_ime']." ".$kartonipacijenata_2['kartonipacijenata_prezime'] ?></h5>
                    </div>
                    <div class="card-body text-dark">
                        Datum rođenja: <?php echo date('d.m.Y.',strtotime($kartonipacijenata_2['kartonipacijenata_datumrodjenja'])) ?><br />
                        Telefon: <?php echo $kartonipacijenata_2['kartonipacijenata_telefon'] ?><br />
                        <p class="card-text">
                          Doktor: <?php echo $singleuser['user_ime']." ".$singleuser['user_prezime'] ?><br />
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-dark">
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;">
                            <button onclick="location.href='detalji-kartona.php?detaljiKartona=<?php echo $kartonipacijenata_2['kartonipacijenata_id'] ?>'" class="btn btn-outline-info" type="button">Detalji</button>
                            <button onclick="location.href='uredi-karton.php?id=<?php echo $kartonipacijenata_2['kartonipacijenata_id'] ?>'" class="btn btn-outline-info" type="button">Uredi</button>
                            <button class="btn btn-outline-info delete-object" type="button" data-toggle="modal" data-target="#deleteKartonipacijenataModal" dataID_="<?php echo $kartonipacijenata_2['kartonipacijenata_id'] ?>" dataLink="pregled-kartona.php?delete_kartonipacijenata=<?php echo $kartonipacijenata_2['kartonipacijenata_id'] ?>">Izbriši</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            </div>
        </div>
    </div>
    
    <!-- FOOTER -->
    <?php include_once('includes/footer.php'); ?>

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

    <script>
        $(".delete-object").click(function(){
            var dataID_ = $(this).attr("dataID_");
            var dataLink = $(this).attr("dataLink");
            //$("input#dataID_").val(dataID_);
            $("#submit_delete_tip_intervencije").attr('href', dataLink);
            console.log(dataLink);
        });
    </script>

<?php 
    include_once('includes/footer.php');
}else {  
    session_destroy();
    header("location:index.php");
    echo"<script>window.location.href = 'index.php';</script>";  
}  
?>