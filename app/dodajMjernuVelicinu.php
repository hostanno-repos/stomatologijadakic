<?php
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
$vrsteuredjaja = new allObjects;
$vrsteuredjaja = $vrsteuredjaja->fetch_all_objects("vrsteuredjaja", "vrsteuredjaja_id", "ASC");
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="mb-3">Dodaj mjernu veličinu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item"><a href="pregledmetodainspekcije.php">Mjerne veličine</a></li>
                <li class="breadcrumb-item active">Dodaj mjernu veličinu</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <form class="col-lg-12 d-flex flex-wrap" action="dodajMjernuVelicinu.php" method="post">
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="mjernevelicine_vrstauredjajaid">Vrsta mjerila:</label>
                    <input type="number" name="mjernevelicine_vrstauredjajaid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($vrsteuredjaja as $vrstauredjaja) { ?>
                            <option value="<?php echo $vrstauredjaja['vrsteuredjaja_id'] ?>">
                                <?php echo $vrstauredjaja['vrsteuredjaja_naziv'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="mjernevelicine_naziv">Naziv:</label>
                    <input type="text" name="mjernevelicine_naziv">
                </div>
                <div class="col-lg-12 d-flex flex-column mt-3">
                    <button name="submit_mjernevelicine" class="btn btn-primary" type="submit"
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

<script>

    $(document).ready(function () {
        $(".selectElement_").change(function () {
            var selectValue = $(this).val();
            $(this).prev().val(selectValue);
        });
    });

</script>

<?php
//INCLUDES
include_once ('includes/footer.php');

?>