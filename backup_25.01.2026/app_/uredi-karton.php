<?php 
    session_start();
    include_once("../connection.php");
    include_once('./class/editObject.php');
    include_once('class/kartoni.php');
    include_once('class/users.php');
    include_once('includes/head.php'); 
    $_GET['administracija'] = 2; 
    //PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
    if(isset($_SESSION["logged_in"])){  

        //GET INTERVENCIJE FOR SELECTED PACIJENT
        $id_kartona = $_GET['id'];
        $singlekarton = new singleKarton;
        $singlekarton = $singlekarton->fetch_single_karton($id_kartona);

        //GET ALL USERS
        $allusers = new users;
        $allusers = $allusers->fetch_all();

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
                <h5 class="mb-0 text-gray-800">Dodaj karton</h5>
            </div>
            
            <form action="uredi-karton.php?id=<?php echo $singlekarton['kartonipacijenata_id']; ?>" method="post" autocomplete="off" id="insert_karton" enctype='multipart/form-data'>
                <div class="form-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <hr/>
                            <p class="ml-3">Lični podaci</p>
                            <hr/>
                        </div>
                        <div class="col-lg-4">
                            <!-- IME -->
                            <label for="kartonipacijenata_ime">Ime:</label>
                            <input type="text" name="kartonipacijenata_ime" placeholder="Ime pacijenta" value="<?php echo $singlekarton['kartonipacijenata_ime']; ?>" required>
                        </div>
                        <div class="col-lg-4">
                            <!-- IME RODITELJA -->
                            <label for="kartonipacijenata_roditelj">Ime roditelja:</label>
                            <input type="text" name="kartonipacijenata_roditelj" placeholder="Ime roditelja" value="<?php echo $singlekarton['kartonipacijenata_roditelj']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- PREZIME -->
                            <label for="kartonipacijenata_prezime">Prezime:</label>
                            <input type="text" name="kartonipacijenata_prezime" placeholder="Prezime pacijenta" value="<?php echo $singlekarton['kartonipacijenata_prezime']; ?>" required>
                        </div>
                        <div class="col-lg-4">
                            <!-- DATUM ROĐENJA -->
                            <label for="kartonipacijenata_datumrodjenja">Datum rođenja:</label>
                            <input type="date" name="kartonipacijenata_datumrodjenja" placeholder="Datum rođenja" value="<?php echo $singlekarton['kartonipacijenata_datumrodjenja']; ?>" required>
                        </div>
                        <div class="col-lg-4">
                            <!-- MATIČNI BROJ -->
                            <label for="kartonipacijenata_maticnibroj">Matični broj:</label>
                            <input type="text" name="kartonipacijenata_maticnibroj" placeholder="Matični broj" value="<?php echo $singlekarton['kartonipacijenata_maticnibroj']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- POL -->
                            <label for="kartonipacijenata_pol">Pol:</label>
                            <!-- <input type="text" name="kartonipacijenata_pol"> -->
                            <select name="kartonipacijenata_pol" id="kartonipacijenata_pol">
                                <option value=""></option>
                                <option value="Muški" <?php if($singlekarton['kartonipacijenata_pol'] == "Muški"){ echo "selected"; } ?>>Muški</option>
                                <option value="Ženski" <?php if($singlekarton['kartonipacijenata_pol'] == "Ženski"){ echo "selected"; } ?>>Ženski</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <!-- ZANIMANJE -->
                            <label for="kartonipacijenata_zanimanje">Zanimanje:</label>
                            <input type="text" name="kartonipacijenata_zanimanje" placeholder="Zanimanje" value="<?php echo $singlekarton['kartonipacijenata_zanimanje']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- DOKTOR -->
                            <label for="kartonipacijenata_iddoktora">Doktor:</label>
                            <input type="text" name="kartonipacijenata_iddoktora" value="<?php echo $singlekarton['kartonipacijenata_iddoktora']; ?>" hidden>
                            <select class="gettingIdSelect" name="" id="kartonipacijenata_doktor" required>
                                <option value=""></option>
                                <?php foreach($allusers as $user) { ?>
                                <option value="<?php echo $user['user_id']; ?>" <?php if($singlekarton['kartonipacijenata_iddoktora'] == $user['user_id']){ echo "selected"; } ?>><?php echo $user['user_ime']." ".$user['user_prezime'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <!-- TELEFON -->
                            <label for="kartonipacijenata_telefon">Telefon:</label>
                            <input type="text" name="kartonipacijenata_telefon" placeholder="Telefon" value="<?php echo $singlekarton['kartonipacijenata_telefon']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- E-MAIL -->
                            <label for="kartonipacijenata_email">E-mail:</label>
                            <input type="text" name="kartonipacijenata_email" placeholder="E-mail" value="<?php echo $singlekarton['kartonipacijenata_email']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- ADRESA -->
                            <label for="kartonipacijenata_adresa">Adresa:</label>
                            <input type="text" name="kartonipacijenata_adresa" placeholder="Adresa" value="<?php echo $singlekarton['kartonipacijenata_adresa']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- POŠTANSKI BROJ -->
                            <label for="kartonipacijenata_postanski">Poštanski broj:</label>
                            <input type="text" name="kartonipacijenata_postanski" placeholder="Poštanski broj" value="<?php echo $singlekarton['kartonipacijenata_postanski']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- GRAD -->
                            <label for="kartonipacijenata_grad">Grad:</label>
                            <input type="text" name="kartonipacijenata_grad" placeholder="Grad" value="<?php echo $singlekarton['kartonipacijenata_grad']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- DRŽAVA -->
                            <label for="kartonipacijenata_drzava">Država:</label>
                            <input type="text" name="kartonipacijenata_drzava" placeholder="Država" value="<?php echo $singlekarton['kartonipacijenata_drzava']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- NAPOMENA -->
                            <label for="kartonipacijenata_napomena">Napomena:</label>
                            <textarea name="kartonipacijenata_napomena" placeholder="Napomena"><?php echo $singlekarton['kartonipacijenata_napomena']; ?></textarea>
                        </div>
                        <div class="col-lg-12">
                            <hr/>
                            <p class="ml-3">Podaci o osiguranju</p>
                            <hr/>
                        </div>
                        <div class="col-lg-4">
                            <!-- BROJ ZDRAVSTVENE -->
                            <label for="kartonipacijenata_brojzdravstvene">Broj zdravstvene:</label>
                            <input type="text" name="kartonipacijenata_brojzdravstvene" placeholder="Broj zdravstvene" value="<?php echo $singlekarton['kartonipacijenata_brojzdravstvene']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- IME NOSIOCA -->
                            <label for="kartonipacijenata_imenosioca">Ime nosioca:</label>
                            <input type="text" name="kartonipacijenata_imenosioca" placeholder="Ime nosioca" value="<?php echo $singlekarton['kartonipacijenata_imenosioca']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- MATIČNI BROJ NOSIOCA -->
                            <label for="kartonipacijenata_maticni_brojnosioca">Matični broj nosioca:</label>
                            <input type="text" name="kartonipacijenata_maticnibrojnosioca" placeholder="Matični broj nosioca" value="<?php echo $singlekarton['kartonipacijenata_maticnibrojnosioca']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- ŠIFRA OBVEZNIKA -->
                            <label for="kartonipacijenata_sifraobveznika">Šifra obveznika:</label>
                            <input type="text" name="kartonipacijenata_sifraobveznika" placeholder="Šifra obveznika" value="<?php echo $singlekarton['kartonipacijenata_sifraobveznika']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- PREZIME NOSIOCA -->
                            <label for="kartonipacijenata_prezimenosioca">Država:</label>
                            <input type="text" name="kartonipacijenata_prezimenosioca" placeholder="Prezime nosioca" value="<?php echo $singlekarton['kartonipacijenata_prezimenosioca']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- SRODSTVO SA NOSIOCEM -->
                            <label for="kartonipacijenata_srodstvosanosiocem">Srodstvo sa nosiocem:</label>
                            <input type="text" name="kartonipacijenata_srodstvosanosiocem" placeholder="Srodstvo sa nosiocem" value="<?php echo $singlekarton['kartonipacijenata_srodstvosanosiocem']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- ŠIFRA DJELATNOSTI -->
                            <label for="kartonipacijenata_sifradjelatnosti">Šifra djelatnosti:</label>
                            <input type="text" name="kartonipacijenata_sifradjelatnosti" placeholder="Šifra djelatnosti" value="<?php echo $singlekarton['kartonipacijenata_sifradjelatnosti']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- IME JEDNOG RODITELJA -->
                            <label for="kartonipacijenata_imejednogroditelja">Ime jednog roditelja:</label>
                            <input type="text" name="kartonipacijenata_imejednogroditelja" placeholder="Ime jednog roditelja" value="<?php echo $singlekarton['kartonipacijenata_imejednogroditelja']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <!-- NAZIV OBVEZNIKA (FIRMA) -->
                            <label for="kartonipacijenata_nazivobveznikafirma">Naziv obveznika (firma):</label>
                            <input type="text" name="kartonipacijenata_nazivobveznikafirma" placeholder="Naziv obveznika (firma)" value="<?php echo $singlekarton['kartonipacijenata_nazivobveznikafirma']; ?>">
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary" name="edit_kartonipacijenata">Sačuvaj</button>
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