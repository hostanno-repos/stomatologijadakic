<?php
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS
$vrsteuredjaja = new allObjects;
$vrsteuredjaja = $vrsteuredjaja->fetch_all_objects("vrsteuredjaja", "vrsteuredjaja_id", "ASC");
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="mb-3">Dodaj mjerilo</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item"><a href="mjerila.php">Pregled mjerila</a></li>
                <li class="breadcrumb-item active">Dodaj mjerilo</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <form class="col-lg-12 d-flex flex-wrap" action="dodajMjerilo.php" method="post">
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="mjerila_broj">Broj:</label>
                    <input type="text" name="mjerila_broj">
                </div>
                <div class="col-lg-3 d-flex flex-column mb-2">
                    <label for="mjerila_vrstauredjajaid">Vrsta mjerila:</label>
                    <input type="number" name="mjerila_vrstauredjajaid" value="" hidden>
                    <select name="" id="" class="selectElement_">
                        <option value=""></option>
                        <?php foreach ($vrsteuredjaja as $vrstauredjaja) { ?>
                            <option value="<?php echo $vrstauredjaja['vrsteuredjaja_id'] ?>">
                                <?php echo $vrstauredjaja['vrsteuredjaja_naziv'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-12 d-flex flex-column mt-3">
                    <button name="submit_mjerila" class="btn btn-primary" type="submit"
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