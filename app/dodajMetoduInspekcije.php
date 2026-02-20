<?php
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="mb-3">Dodaj metodu inspekcije</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item"><a href="pregledmetodainspekcije.php">Metode inspekcije</a></li>
                <li class="breadcrumb-item active">Dodaj metodu inspekcije</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <form class="col-lg-12 d-flex flex-wrap" action="dodajMetoduInspekcije.php" method="post">
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="metodeinspekcije_naziv">Naziv:</label>
                    <input type="text" name="metodeinspekcije_naziv">
                </div>
                <div class="col-lg-12 d-flex flex-column mt-3">
                    <button name="submit_metodeinspekcije" class="btn btn-primary" type="submit"
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