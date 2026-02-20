<?php
/**
 * Site Images – forma za zamjenu jedne slike.
 */
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

$error = getFlash('error');
$success = getFlash('success');

$currentImg = null;
if (!empty($current_path)) {
    $currentImg = ADMIN_URL . '/' . ltrim($current_path, '/');
} else {
    $base = defined('BASE_PATH') ? BASE_PATH : dirname(ADMIN_PATH);
    if (file_exists($base . '/' . ltrim($default_path, '/'))) {
        $currentImg = '../' . ltrim($default_path, '/');
    }
}
?>

<div class="site-images-edit-page">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">Zamijeni sliku: <?php echo escape($slot_label); ?></h1>
        <a href="<?php echo ADMIN_URL; ?>/siteimages" style="color: #74788d; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">← Nazad na listu</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error" style="background: #fee; color: #c33; padding: 0.875rem; border-radius: 0.375rem; margin-bottom: 1rem;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success" style="background: #efe; color: #3c3; padding: 0.875rem; border-radius: 0.375rem; margin-bottom: 1rem;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <div style="background: white; padding: 2rem; border-radius: 0.5rem; border: 1px solid #e9ecef; max-width: 500px;">
        <?php if ($currentImg): ?>
            <p style="margin-bottom: 0.75rem; font-weight: 500; color: #495057;">Trenutna slika:</p>
            <div style="margin-bottom: 1.5rem;">
                <img src="<?php echo htmlspecialchars($currentImg); ?>" alt="" style="max-width: 100%; max-height: 280px; object-fit: contain; border: 1px solid #e9ecef; border-radius: 0.375rem;">
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo ADMIN_URL; ?>/siteimages/update/<?php echo urlencode($slot_key); ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo escape($csrf_token); ?>">

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #495057;">Nova slika</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp,image/svg+xml" style="width: 100%; padding: 0.5rem; border: 1px solid #e9ecef; border-radius: 0.375rem;">
                <small style="display: block; margin-top: 0.25rem; color: #74788d;">JPEG, PNG, GIF, WebP, SVG — max 5MB</small>
            </div>

            <?php if (!empty($current_path)): ?>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="remove_image" value="1">
                    <span style="color: #f46a6a; font-size: 0.875rem;">Ukloni custom sliku (prikaži zadanu)</span>
                </label>
            </div>
            <?php endif; ?>

            <div style="display: flex; gap: 0.75rem;">
                <a href="<?php echo ADMIN_URL; ?>/siteimages" style="padding: 0.625rem 1.25rem; background: #74788d; color: white; text-decoration: none; border-radius: 0.375rem;">Otkaži</a>
                <button type="submit" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">Sačuvaj</button>
            </div>
        </form>
    </div>
</div>
