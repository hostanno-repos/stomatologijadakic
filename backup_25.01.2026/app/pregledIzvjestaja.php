<?php
//INCLUDES
include_once ('includes/head.php');
include_once ('includes/header.php');
include_once ('includes/sidebar.php');
//GET ITEMS

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="mb-2">Izvještaji</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Početna</a></li>
                <li class="breadcrumb-item active">Izvještaji</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="text-center">Broj fakture</th>
                            <th scope="col" class="text-center">Klijent</th>
                            <th scope="col" class="text-center">Datum fakture</th>
                            <th scope="col" class="text-center">Rok za plaćanje</th>
                            <th scope="col" class="text-center">Rok isporuke</th>
                            <th scope="col" class="text-center">Briši</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fakture as $fakture) {

                            $klijent = new singleKlijent;
                            $klijent = $klijent->fetch_single_object($fakture['fakture_klijentid']);

                            ?>
                            <tr style="cursor:pointer" class="clickable-row"
                                data-href="pregledfakture.php?id=<?php echo $fakture['fakture_id'] ?>">
                                <td scope="row"><?php echo $fakture['fakture_id'] ?></td>
                                <td scope="row" class="text-center">
                                    <?php echo $fakture['fakture_brojac'] . "/" . $fakture['fakture_godinabrojaca'] ?>
                                </td>
                                <td scope="row" class="text-center"><?php echo $klijent['klijenti_naziv'] ?></td>
                                <td scope="row" class="text-center">
                                    <?php echo date('d.m.Y.', strtotime($fakture['fakture_datum'])) ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php echo date('d.m.Y.', strtotime($fakture['fakture_rok'])) ?>
                                </td>
                                <td scope="row" class="text-center">
                                    <?php echo date('d.m.Y.', strtotime($fakture['fakture_isporuka'])) ?>
                                </td>
                                <td scope="row" class="text-center"><a
                                        href="fakture.php?deleteFaktura=<?php echo $fakture['fakture_id'] ?>"><i
                                            class="bi bi-trash-fill"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</main>

<style>
    tr:hover {
        background-color: #eee;
    }
</style>

<script>
    jQuery(document).ready(function ($) {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
    });
</script>

<?php
//INCLUDES
include_once ('includes/footer.php');

?>