<?php
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="mb-3">Dodaj klijenta</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item"><a href="pregledKlijenata.php">Pregled klijenata</a></li>
                <li class="breadcrumb-item active">Dodaj klijenata</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <form class="col-lg-12 d-flex flex-wrap" action="dodajklijenta.php" method="post">
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="klijenti_naziv">Naziv:</label>
                    <input type="text" name="klijenti_naziv">
                </div>
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="klijenti_adresa">Ulica i broj:</label>
                    <input type="text" name="klijenti_adresa">
                </div>
                <div class="col-lg-12 d-flex flex-column mt-3">
                    <button name="submit_klijenti" class="btn btn-primary" type="submit"
                        style="width:150px">Sačuvaj</button>
                </div>
            </form>
        </div>
    </section>

</main>

<style>
    .btn.btn-primary {
        background-color: #00335e;
    }
</style>

<?php
//INCLUDES
include_once ('includes/footer.php');

?>