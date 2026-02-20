<?php
/**
 * Employee Form View (Create/Edit)
 *
 * @package    DakicCMS
 * @subpackage Admin
 */

if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

$error = getFlash('error');
$success = getFlash('success');
$isEdit = isset($employee) && !empty($employee['id']);
$actionUrl = $isEdit ? ADMIN_URL . '/employees/update/' . $employee['id'] : ADMIN_URL . '/employees/store';
?>

<div class="employees-form-page">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">
            <?php echo $isEdit ? 'Uredi zaposlenog' : 'Dodaj zaposlenog'; ?>
        </h1>
        <a href="<?php echo ADMIN_URL; ?>/employees" style="color: #74788d; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">← Nazad na zaposlene</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error" style="background: #fee; color: #c33; padding: 0.875rem; border-radius: 0.375rem; margin-bottom: 1.5rem; border: 1px solid #fcc;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success" style="background: #efe; color: #3c3; padding: 0.875rem; border-radius: 0.375rem; margin-bottom: 1.5rem; border: 1px solid #cfc;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <div class="form-container" style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
        <form method="POST" action="<?php echo $actionUrl; ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo escape($csrf_token); ?>">

            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="first_name" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">Ime <span style="color: #f46a6a;">*</span></label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo escape($employee['first_name'] ?? ''); ?>" required style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem;">
                </div>
                <div class="form-group">
                    <label for="last_name" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">Prezime <span style="color: #f46a6a;">*</span></label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo escape($employee['last_name'] ?? ''); ?>" required style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="position" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">Pozicija <span style="color: #f46a6a;">*</span></label>
                <input type="text" id="position" name="position" value="<?php echo escape($employee['position'] ?? ''); ?>" required style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem;">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="gender" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">Pol</label>
                <select id="gender" name="gender" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem;">
                    <option value="male" <?php echo (isset($employee['gender']) && $employee['gender'] === 'female') ? '' : 'selected'; ?>>Muški</option>
                    <option value="female" <?php echo (isset($employee['gender']) && $employee['gender'] === 'female') ? 'selected' : ''; ?>>Ženski</option>
                </select>
                <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">Koristi se za avatar ako nema učitane slike (muški = Milan Dakić, ženski = Tanja Tešević).</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="image" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">Slika zaposlenog</label>
                <?php if ($isEdit && !empty($employee['image'])): ?>
                    <div style="margin-bottom: 0.75rem;">
                        <img src="<?php echo ADMIN_URL . '/' . ltrim($employee['image'], '/'); ?>" alt="Slika" style="max-width: 200px; max-height: 200px; border-radius: 0.375rem; border: 1px solid #e9ecef;">
                        <div style="margin-top: 0.5rem;">
                            <label style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="remove_image" value="1" style="cursor: pointer;">
                                <span style="color: #f46a6a; font-size: 0.875rem;">Obriši trenutnu sliku</span>
                            </label>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem;">
                <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">JPEG, PNG, GIF, WebP — max 5MB. Ako ostavite prazno, prikazaće se avatar po polu.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="description" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">Opis</label>
                <textarea id="description" name="description" rows="5" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-family: inherit; resize: vertical;"><?php echo escape($employee['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e9ecef;">
                <a href="<?php echo ADMIN_URL; ?>/employees" style="padding: 0.625rem 1.25rem; background: #74788d; color: white; text-decoration: none; border-radius: 0.375rem;">Otkaži</a>
                <button type="submit" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                    <?php echo $isEdit ? 'Sačuvaj izmene' : 'Dodaj zaposlenog'; ?>
                </button>
            </div>
        </form>
    </div>
</div>
