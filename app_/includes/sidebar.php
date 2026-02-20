<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
        <div class="sidebar-brand-icon">
            <img src="img/admin-logo.png" alt="" width="60px">
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if($_GET['administracija'] === 1) { echo 'active'; } ?>">
        <a class="nav-link" href="admin.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Administracija</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pacijenti
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if($_GET['administracija'] === 2) { echo 'active'; } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKartoni"
            aria-expanded="true" aria-controls="collapseKartoni">
            <i class="fas fa-fw fa-cog"></i>
            <span>Kartoni pacijenata</span>
        </a>
        <div id="collapseKartoni" class="collapse" aria-labelledby="headingKartoni" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="pregled-kartona.php">Pregled kartona</a>
                <a class="collapse-item" href="dodaj-karton.php">Dodaj karton</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item <?php if($_GET['administracija'] === 3) { echo 'active'; } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRezervacije"
            aria-expanded="true" aria-controls="collapseRezervacije">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Rezervacije termina</span>
        </a>
        <div id="collapseRezervacije" class="collapse" aria-labelledby="headingRezervacije"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="dodaj-termin.php">Dodaj termin</a>
                <hr class="mt-1 mb-1">
                <a class="collapse-item" href="zahtjevi-termini.php">Zahtjevi za termin</a>
                <a class="collapse-item" href="zakazani-termini.php">Zakazani termini</a>
                <a class="collapse-item" href="zavrseni-termini.php">Završeni termini</a>
                <hr class="mt-1 mb-1">
                <a class="collapse-item" href="odbijeni-termini.php">Odbijeni zahtjevi</a>
                <a class="collapse-item" href="otkazani-termini.php">Otkazani termini</a>
                <a class="collapse-item" href="propusteni-termini.php">Propušteni termini</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Administracija
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item <?php if($_GET['administracija'] === 4) { echo 'active'; } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDoktori"
            aria-expanded="true" aria-controls="collapseDoktori">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Doktori</span>
        </a>
        <div id="collapseDoktori" class="collapse" aria-labelledby="headingDoktori"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="korisnici.php">Pregled doktora</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item <?php if($_GET['administracija'] === 5) { echo 'active'; } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIntervencije"
            aria-expanded="true" aria-controls="collapseIntervencije">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Intervencije</span>
        </a>
        <div id="collapseIntervencije" class="collapse" aria-labelledby="headingIntervencije"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="tipovi-intervencija.php">Tipovi intervencije</a>
                <a class="collapse-item" href="pregled-intervencija.php">Pregled intervencija</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item <?php if($_GET['administracija'] === 6) { echo 'active'; } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRacuni"
            aria-expanded="true" aria-controls="collapseRacuni">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Računi</span>
        </a>
        <div id="collapseRacuni" class="collapse" aria-labelledby="headingRacuni"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="pregled-racuna.php">Pregled računa</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Addons
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li> -->

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> -->


</ul>
<!-- End of Sidebar -->