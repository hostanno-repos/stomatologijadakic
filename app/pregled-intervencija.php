<?php 
session_start();
include_once("../connection.php");
include_once('class/kartoni.php');
include_once('class/intervencije.php');
include_once('class/users.php');
include_once('includes/head.php'); 
$_GET['administracija'] = 5; 

$now = time();
if(isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']){

    $allowed_per_page = [10, 15, 20, 25, 50, 100];
    $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
    if (!in_array($per_page, $allowed_per_page, true)) {
        $per_page = 10;
    }

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    if ($page < 1) {
        $page = 1;
    }

    $intervencije_model = new allInterventions;
    $total_intervencije = $intervencije_model->count_all_intervencije();
    $total_pages = max(1, (int) ceil($total_intervencije / $per_page));

    if ($page > $total_pages) {
        $page = $total_pages;
    }

    $offset = ($page - 1) * $per_page;
    $sve_intervencije = $intervencije_model->fetch_all_intervencije($per_page, $offset);

?>

  <body>
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php'); ?>

    <div class="wrapper d-flex flex-column bg-light">

        <!-- HEADER -->
        <?php include_once('includes/header.php'); ?>

        <div class="body flex-grow-1 px-3">
            <div class="container-fluid">
                <h3 class="mb-3">Pregled intervencija</h3>
                <div class="row mb-2">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <form method="get" action="pregled-intervencija.php" class="d-flex align-items-center flex-nowrap per-page-form">
                            <label for="per_page" class="mb-0 mr-2 per-page-label">Prikaži po stranici:</label>
                            <select name="per_page" id="per_page" class="custom-select custom-select-sm mr-2 per-page-select" onchange="this.form.submit()">
                                <?php foreach ($allowed_per_page as $option) { ?>
                                    <option value="<?php echo $option; ?>" <?php echo ($per_page === $option) ? 'selected' : ''; ?>>
                                        <?php echo $option; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="page" value="1">
                            <noscript>
                                <button type="submit" class="btn btn-primary btn-sm">Primijeni</button>
                            </noscript>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table centeredTable">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ime i prezime pacijenta</th>
                                <th scope="col">Ime doktora</th>
                                <th scope="col">Zub</th>
                                <th scope="col">Tip</th>
                                <th scope="col">Opis</th>
                                <th scope="col">Datum</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Datum unosa</th>
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
                                    <td><i class="fa-solid fa-trash"></i></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <?php if ($total_pages > 1) { ?>
                            <?php
                                $pagination_window = 2;
                                $pages_to_show = [1, $total_pages];

                                for ($i = $page - $pagination_window; $i <= $page + $pagination_window; $i++) {
                                    if ($i >= 1 && $i <= $total_pages) {
                                        $pages_to_show[] = $i;
                                    }
                                }

                                $pages_to_show = array_values(array_unique($pages_to_show));
                                sort($pages_to_show);
                            ?>
                            <nav aria-label="Paginacija intervencija">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="pregled-intervencija.php?page=<?php echo max(1, $page - 1); ?>&per_page=<?php echo $per_page; ?>">Prethodna</a>
                                    </li>

                                    <?php
                                        $last_rendered_page = 0;
                                        foreach ($pages_to_show as $page_number) {
                                            if ($last_rendered_page > 0 && $page_number - $last_rendered_page > 1) {
                                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                            }
                                            ?>
                                            <li class="page-item <?php echo ($page_number === $page) ? 'active' : ''; ?>">
                                                <a class="page-link" href="pregled-intervencija.php?page=<?php echo $page_number; ?>&per_page=<?php echo $per_page; ?>">
                                                    <?php echo $page_number; ?>
                                                </a>
                                            </li>
                                            <?php
                                            $last_rendered_page = $page_number;
                                        }
                                    ?>

                                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="pregled-intervencija.php?page=<?php echo min($total_pages, $page + 1); ?>&per_page=<?php echo $per_page; ?>">Sljedeća</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
    
    <style>
        .per-page-form {
            white-space: nowrap;
        }

        .per-page-label {
            white-space: nowrap;
        }

        .per-page-select {
            min-width: 90px;
            width: auto;
        }

        .pagination .page-link {
            color: #3c4b64;
        }

        .pagination .page-item.active .page-link {
            background-color: #3c4b64;
            border-color: #3c4b64;
            color: #fff;
        }

        .pagination .page-link:hover,
        .pagination .page-link:focus {
            color: #3c4b64;
            box-shadow: none;
        }
    </style>

    <!-- FOOTER -->
    <?php include_once('includes/footer.php'); ?>

<?php 
    include_once('includes/footer.php');
}else {  
    session_destroy();
    header("location:index.php");
    echo"<script>window.location.href = 'index.php';</script>";  
}  
?>