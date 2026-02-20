<?php
/**
 * Site Images – lista slotova za zamjenu slika.
 */
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

$error = getFlash('error');
$success = getFlash('success');
?>

<div class="site-images-page">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">Slike na sajtu</h1>
        <p style="color: #74788d; margin-top: 0.5rem;">Odaberite sliku koju želite zamijeniti. Ako nije postavljena custom slika, na sajtu se prikazuje zadana.</p>
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

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.25rem;">
        <?php foreach ($slots as $slot): ?>
            <?php
            $imgSrc = null;
            if (!empty($slot['path'])) {
                $imgSrc = ADMIN_URL . '/' . ltrim($slot['path'], '/');
            } else {
                $defaultFull = (defined('BASE_PATH') ? BASE_PATH : dirname(ADMIN_PATH)) . '/' . ltrim($slot['default'], '/');
                if (file_exists($defaultFull)) {
                    $imgSrc = '../' . ltrim($slot['default'], '/');
                }
            }
            ?>
            <div style="background: white; border: 1px solid #e9ecef; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                <div style="height: 140px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; padding: 0.5rem;">
                    <?php if ($imgSrc): ?>
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    <?php else: ?>
                        <span style="color: #adb5bd; font-size: 0.875rem;">Zadana putanja:<br><?php echo escape($slot['default']); ?></span>
                    <?php endif; ?>
                </div>
                <div style="padding: 0.75rem 1rem;">
                    <div style="font-weight: 600; color: #343a40; font-size: 0.875rem; margin-bottom: 0.5rem;"><?php echo escape($slot['label']); ?></div>
                    <a href="<?php echo ADMIN_URL; ?>/siteimages/edit/<?php echo urlencode($slot['key']); ?>" style="display: inline-block; padding: 0.4rem 0.75rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.8rem;">Zamijeni sliku</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
