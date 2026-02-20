<?php 

    session_start();
    include_once("../connection.php");
    include_once('./class/insertObject.php');
    include_once('class/kartoni.php');
    include_once('class/users.php');
    include_once('includes/head.php'); 
    $_GET['administracija'] = 3; 
    //PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
    if(isset($_SESSION["logged_in"])){  

        $users = new users;
        $users = $users->fetch_all();

        $kartoni = new kartoniPacijenata;
        $kartoni = $kartoni->fetch_all_kartonipacijenata();


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
                <h5 class="mb-0 text-gray-800">Dodaj termin</h5>
            </div>
            
            <form action="dodaj-termin.php" method="post" autocomplete="off" id="insert_termin" enctype='multipart/form-data'>
                <div class="form-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- PACIJENT -->
                            <label for="termini_idpacijenta">Izaberite pacijenta:</label>
                            <input type="number" name="termini_idpacijenta" hidden>
                            <select class="gettingIdSelect" required>
                                <option value=""></option>
                                <?php foreach($kartoni as $kartoni){ ?>
                                    <option value="<?php echo $kartoni['kartonipacijenata_id'] ?>"><?php echo $kartoni['kartonipacijenata_ime']." (".$kartoni['kartonipacijenata_roditelj'].") ".$kartoni['kartonipacijenata_prezime']." - ".date('d.m.Y.',strtotime($kartoni['kartonipacijenata_datumrodjenja'])) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <!-- DOKTOR -->
                            <label for="termini_iddoktora">Izaberite doktora:</label>
                            <input type="number" name="termini_iddoktora" hidden>
                            <select class="gettingIdSelect" required>
                                <option value=""></option>
                                <?php foreach($users as $users){ ?>
                                    <option value="<?php echo $users['user_id'] ?>"><?php echo $users['user_ime']." ".$users['user_prezime'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <!-- DATUM -->
                            <label for="termini_datum">Datum:</label>
                            <input type="date" name="termini_datum" required>
                        </div>
                        <div class="col-lg-3">
                            <!-- VRIJEME -->
                            <label for="termini_vrijeme">Vrijeme:</label>
                            <input type="time" name="termini_vrijeme" hidden>
                            <select class="gettingIdSelect" required>
                                <option value=""></option>
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                                <option value="18:00">18:00</option>
                                <option value="18:30">18:30</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <!-- NAPOMENA -->
                            <label for="termini_napomena">Unesite napomenu:</label>
                            <textarea name="termini_napomena" id="" cols="30" rows="10" placeholder="Napomena.."></textarea>
                        </div>
                        <div>
                            <input type="text" name="termini_status" value="Zakazan" hidden>
                        </div>
                        <div>
                            <input type="text" name="termini_autor" value="<?php echo $_SESSION['user_ime'].' '.$_SESSION['user_prezime']; ?>"  hidden>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary" name="submit_termini">Sačuvaj</button>
                    </div>
                </div>
            </form>

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