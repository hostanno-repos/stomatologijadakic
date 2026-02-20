<?php
session_start();
include_once("../connection.php");
include_once('class/intervencije.php');
include_once('class/statistika.php');
include_once('includes/head.php');
$_GET['administracija'] = 7;

$now = time();
if (!isset($_SESSION["logged_in"]) || $now >= $_SESSION['expire']) {
    header('Location: login.php');
    exit;
}

$tab = isset($_GET['tab']) && $_GET['tab'] === 'godine' ? 'godine' : 'mjeseci';

// Učitaj sve podatke
$interv_mjesec = Statistika::intervencije_po_mjesecima();
$interv_godina = Statistika::intervencije_po_godinama();
$naplaceno_mjesec = [];
$naplaceno_godina = [];
try {
    $naplaceno_mjesec = Statistika::naplaceno_po_tipu_mjesec();
    $naplaceno_godina = Statistika::naplaceno_po_tipu_godina();
} catch (Exception $e) {
}
$ukupno_mjesec = Statistika::ukupno_naplaceno_po_mjesecima();
$ukupno_godina = Statistika::ukupno_naplaceno_po_godinama();

$svi_tipovi = (new tipoviIntervencija)->fetch_all_tipovi_intervencija();

// Grupiraj po tipu intervencije: za svaki tip imamo period -> [broj, iznos]
// Mjeseci: ključ tip_id => [ 'naziv' => ..., 'periodi' => [ '2024-01' => [broj, iznos], ... ], 'ukupno_broj' => , 'ukupno_iznos' => ]
$po_tipu_mjesec = [];
foreach ($svi_tipovi as $t) {
    $id = $t['tipoviintervencija_id'];
    $po_tipu_mjesec[$id] = ['naziv' => $t['tipoviintervencija_naziv'], 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
}
foreach ($interv_mjesec as $r) {
    $id = $r['id_tipa'] !== null ? $r['id_tipa'] : 0;
    $k = $r['godina'] . '-' . str_pad($r['mjesec'], 2, '0', STR_PAD_LEFT);
    if (!isset($po_tipu_mjesec[$id])) {
        $po_tipu_mjesec[$id] = ['naziv' => $r['naziv_tipa'] ?: 'Nepoznat tip', 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
    }
    if (!isset($po_tipu_mjesec[$id]['periodi'][$k])) {
        $po_tipu_mjesec[$id]['periodi'][$k] = ['godina' => $r['godina'], 'mjesec' => $r['mjesec'], 'broj' => 0, 'iznos' => 0];
    }
    $po_tipu_mjesec[$id]['periodi'][$k]['broj'] += (int)$r['broj'];
    $po_tipu_mjesec[$id]['ukupno_broj'] += (int)$r['broj'];
}
foreach ($naplaceno_mjesec as $r) {
    $id = $r['id_tipa'] !== null ? $r['id_tipa'] : 0;
    $k = $r['godina'] . '-' . str_pad($r['mjesec'], 2, '0', STR_PAD_LEFT);
    if (!isset($po_tipu_mjesec[$id])) {
        $po_tipu_mjesec[$id] = ['naziv' => $r['naziv_tipa'] ?: 'Nepoznat tip', 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
    }
    if (!isset($po_tipu_mjesec[$id]['periodi'][$k])) {
        $po_tipu_mjesec[$id]['periodi'][$k] = ['godina' => $r['godina'], 'mjesec' => $r['mjesec'], 'broj' => 0, 'iznos' => 0];
    }
    $po_tipu_mjesec[$id]['periodi'][$k]['iznos'] += (float)$r['iznos'];
    $po_tipu_mjesec[$id]['ukupno_iznos'] += (float)$r['iznos'];
}
foreach ($po_tipu_mjesec as $id => &$data) {
    ksort($data['periodi']);
}

// Ukupno naplaćeno po mjesecima (za karticu)
$ukupno_po_mjesec_map = [];
foreach ($ukupno_mjesec as $r) {
    $k = $r['godina'] . '-' . str_pad($r['mjesec'], 2, '0', STR_PAD_LEFT);
    $ukupno_po_mjesec_map[$k] = ['godina' => $r['godina'], 'mjesec' => $r['mjesec'], 'ukupno' => (float)$r['ukupno']];
}
ksort($ukupno_po_mjesec_map);

// Po godinama – grupiraj po tipu
$po_tipu_godina = [];
foreach ($svi_tipovi as $t) {
    $id = $t['tipoviintervencija_id'];
    $po_tipu_godina[$id] = ['naziv' => $t['tipoviintervencija_naziv'], 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
}
foreach ($interv_godina as $r) {
    $id = $r['id_tipa'] !== null ? $r['id_tipa'] : 0;
    $g = $r['godina'];
    if (!isset($po_tipu_godina[$id])) {
        $po_tipu_godina[$id] = ['naziv' => $r['naziv_tipa'] ?: 'Nepoznat tip', 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
    }
    if (!isset($po_tipu_godina[$id]['periodi'][$g])) {
        $po_tipu_godina[$id]['periodi'][$g] = ['godina' => $g, 'broj' => 0, 'iznos' => 0];
    }
    $po_tipu_godina[$id]['periodi'][$g]['broj'] += (int)$r['broj'];
    $po_tipu_godina[$id]['ukupno_broj'] += (int)$r['broj'];
}
foreach ($naplaceno_godina as $r) {
    $id = $r['id_tipa'] !== null ? $r['id_tipa'] : 0;
    $g = $r['godina'];
    if (!isset($po_tipu_godina[$id])) {
        $po_tipu_godina[$id] = ['naziv' => $r['naziv_tipa'] ?: 'Nepoznat tip', 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
    }
    if (!isset($po_tipu_godina[$id]['periodi'][$g])) {
        $po_tipu_godina[$id]['periodi'][$g] = ['godina' => $g, 'broj' => 0, 'iznos' => 0];
    }
    $po_tipu_godina[$id]['periodi'][$g]['iznos'] += (float)$r['iznos'];
    $po_tipu_godina[$id]['ukupno_iznos'] += (float)$r['iznos'];
}
foreach ($po_tipu_godina as $id => &$data) {
    ksort($data['periodi']);
}

$ukupno_po_godina_map = [];
foreach ($ukupno_godina as $r) {
    $ukupno_po_godina_map[$r['godina']] = (float)$r['ukupno'];
}
ksort($ukupno_po_godina_map);
?>
<body>
    <?php include_once('includes/sidebar.php'); ?>
    <div class="wrapper d-flex flex-column bg-light">
        <?php include_once('includes/header.php'); ?>
        <div class="body flex-grow-1 px-3">
            <div class="container-fluid">
                <h3 class="mb-4">Statistika (od <?php echo Statistika::YEAR_FROM; ?> do danas)</h3>
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $tab === 'mjeseci' ? 'active' : ''; ?>" href="statistika.php?tab=mjeseci">Po mjesecima</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $tab === 'godine' ? 'active' : ''; ?>" href="statistika.php?tab=godine">Po godinama</a>
                    </li>
                </ul>

                <?php if ($tab === 'mjeseci') { ?>

                <?php foreach ($svi_tipovi as $t) {
                    $id = $t['tipoviintervencija_id'];
                    $data = isset($po_tipu_mjesec[$id]) ? $po_tipu_mjesec[$id] : ['naziv' => $t['tipoviintervencija_naziv'], 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
                    if (empty($data['periodi']) && $data['ukupno_broj'] == 0 && $data['ukupno_iznos'] == 0) continue;
                ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary"><?php echo htmlspecialchars($data['naziv']); ?></h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive mb-0">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Mjesec / Godina</th>
                                        <th class="text-center">Broj intervencija</th>
                                        <th class="text-right">Naplaćeno (KM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['periodi'] as $key => $p) {
                                        $label = Statistika::naziv_mjeseca($p['mjesec']) . ' ' . $p['godina'];
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($label); ?></td>
                                        <td class="text-center"><?php echo (int)$p['broj']; ?></td>
                                        <td class="text-right"><?php echo number_format($p['iznos'], 2, ',', '.'); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 py-3 bg-light border-top">
                            <strong>Ukupno za ovaj tip:</strong> <?php echo (int)$data['ukupno_broj']; ?> intervencija, <?php echo number_format($data['ukupno_iznos'], 2, ',', '.'); ?> KM
                        </div>
                    </div>
                </div>
                <?php } ?>

                <div class="card mb-4 shadow-sm border-primary">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">Ukupno naplaćeno (svi računi)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive mb-0">
                            <table class="table table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Mjesec / Godina</th>
                                        <th class="text-right">Iznos (KM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ukupno_po_mjesec_map as $key => $p) {
                                        $label = Statistika::naziv_mjeseca($p['mjesec']) . ' ' . $p['godina'];
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($label); ?></td>
                                        <td class="text-right font-weight-bold"><?php echo number_format($p['ukupno'], 2, ',', '.'); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if (empty($ukupno_po_mjesec_map) && empty(array_filter($po_tipu_mjesec, function ($d) { return !empty($d['periodi']) || $d['ukupno_broj'] || $d['ukupno_iznos']; }))) { ?>
                <p class="text-muted">Nema podataka za prikaz.</p>
                <?php } ?>

                <?php } else { ?>

                <?php foreach ($svi_tipovi as $t) {
                    $id = $t['tipoviintervencija_id'];
                    $data = isset($po_tipu_godina[$id]) ? $po_tipu_godina[$id] : ['naziv' => $t['tipoviintervencija_naziv'], 'periodi' => [], 'ukupno_broj' => 0, 'ukupno_iznos' => 0];
                    if (empty($data['periodi']) && $data['ukupno_broj'] == 0 && $data['ukupno_iznos'] == 0) continue;
                ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary"><?php echo htmlspecialchars($data['naziv']); ?></h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive mb-0">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Godina</th>
                                        <th class="text-center">Broj intervencija</th>
                                        <th class="text-right">Naplaćeno (KM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['periodi'] as $godina => $p) { ?>
                                    <tr>
                                        <td><?php echo (int)$godina; ?></td>
                                        <td class="text-center"><?php echo (int)$p['broj']; ?></td>
                                        <td class="text-right"><?php echo number_format($p['iznos'], 2, ',', '.'); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 py-3 bg-light border-top">
                            <strong>Ukupno za ovaj tip:</strong> <?php echo (int)$data['ukupno_broj']; ?> intervencija, <?php echo number_format($data['ukupno_iznos'], 2, ',', '.'); ?> KM
                        </div>
                    </div>
                </div>
                <?php } ?>

                <div class="card mb-4 shadow-sm border-primary">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">Ukupno naplaćeno (svi računi)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive mb-0">
                            <table class="table table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Godina</th>
                                        <th class="text-right">Iznos (KM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ukupno_po_godina_map as $godina => $ukupno) { ?>
                                    <tr>
                                        <td><?php echo (int)$godina; ?></td>
                                        <td class="text-right font-weight-bold"><?php echo number_format($ukupno, 2, ',', '.'); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if (empty($ukupno_po_godina_map) && empty(array_filter($po_tipu_godina, function ($d) { return !empty($d['periodi']) || $d['ukupno_broj'] || $d['ukupno_iznos']; }))) { ?>
                <p class="text-muted">Nema podataka za prikaz.</p>
                <?php } ?>

                <?php } ?>

                <p class="mt-4 small text-muted">
                    Broj = broj intervencija tog tipa. Naplaćeno po tipu = računi povezani s tom intervencijom. Ukupno naplaćeno = svi računi u tom razdoblju.
                </p>
            </div>
        </div>
    </div>
    <?php include_once('includes/footer.php'); ?>
</body>
</html>
