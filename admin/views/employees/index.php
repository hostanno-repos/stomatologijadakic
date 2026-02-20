<?php
/**
 * Employees List View
 *
 * @package    DakicCMS
 * @subpackage Admin
 */

if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

$error = getFlash('error');
$success = getFlash('success');
?>

<div class="employees-page">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">Upravljanje zaposlenima</h1>
        <a href="<?php echo ADMIN_URL; ?>/employees/create" class="btn btn-primary" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
            + Dodaj zaposlenog
        </a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error" style="background: #fee; color: #c33; padding: 0.875rem; border-radius: 0.375rem; margin-bottom: 1rem; border: 1px solid #fcc;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success" style="background: #efe; color: #3c3; padding: 0.875rem; border-radius: 0.375rem; margin-bottom: 1rem; border: 1px solid #cfc;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <div class="table-container" style="background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; overflow: hidden;">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="employees-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem; width: 60px;">Slika</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Ime i prezime</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Pozicija</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Opis</th>
                        <th style="padding: 0.875rem; text-align: center; font-weight: 600; color: #495057; font-size: 0.875rem;">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($employees)): ?>
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #74788d;">
                                Nema zaposlenih. <a href="<?php echo ADMIN_URL; ?>/employees/create" style="color: #556ee6;">Dodaj prvog</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($employees as $emp):
                            $thumb = !empty($emp['image']) ? (ADMIN_URL . '/' . ltrim($emp['image'], '/')) : '';
                        ?>
                            <tr style="border-bottom: 1px solid #e9ecef;">
                                <td style="padding: 0.875rem;">
                                    <?php if ($thumb): ?>
                                        <img src="<?php echo escape($thumb); ?>" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 0.25rem;">
                                    <?php else: ?>
                                        <span style="display: inline-block; width: 40px; height: 40px; background: #e9ecef; border-radius: 0.25rem; font-size: 0.7rem; text-align: center; line-height: 40px; color: #74788d;"><?php echo (isset($emp['gender']) && $emp['gender'] === 'female') ? 'Ž' : 'M'; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 0.875rem;">
                                    <strong><?php echo escape($emp['first_name'] . ' ' . $emp['last_name']); ?></strong>
                                </td>
                                <td style="padding: 0.875rem; color: #495057;"><?php echo escape($emp['position']); ?></td>
                                <td style="padding: 0.875rem; color: #495057; max-width: 300px;">
                                    <?php echo escape(strlen($emp['description'] ?? '') > 80 ? substr($emp['description'], 0, 80) . '...' : ($emp['description'] ?? '—')); ?>
                                </td>
                                <td style="padding: 0.875rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?php echo ADMIN_URL; ?>/employees/edit/<?php echo (int)$emp['id']; ?>" style="padding: 0.375rem 0.75rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.75rem;">Uredi</a>
                                        <a href="<?php echo ADMIN_URL; ?>/employees/delete/<?php echo (int)$emp['id']; ?>?token=<?php echo generateCsrfToken(); ?>" onclick="return confirm('Da li ste sigurni da želite da obrišete ovog zaposlenog?');" style="padding: 0.375rem 0.75rem; background: #f46a6a; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.75rem;">Obriši</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
