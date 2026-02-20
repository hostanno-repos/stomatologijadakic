<?php
/**
 * Gallery Form View (Create/Edit)
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

$error = getFlash('error');
$success = getFlash('success');
$isEdit = isset($gallery) && !empty($gallery['id']);
$actionUrl = $isEdit ? ADMIN_URL . '/galleries/update/' . $gallery['id'] : ADMIN_URL . '/galleries/store';
?>

<div class="gallery-form-page">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">
            <?php echo $isEdit ? 'Izmeni galeriju' : 'Kreiraj novu galeriju'; ?>
        </h1>
        <a href="<?php echo ADMIN_URL; ?>/galleries" style="color: #74788d; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">
            ← Nazad na galerije
        </a>
    </div>
    
    <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <form method="POST" action="<?php echo $actionUrl; ?>" id="galleryForm">
            <input type="hidden" name="csrf_token" value="<?php echo escape($csrf_token); ?>">
            
            <div class="form-group">
                <label for="title">
                    Title <span style="color: #f46a6a;">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="<?php echo escape($gallery['title'] ?? ''); ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="description">Opis</label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; font-family: inherit; resize: vertical;"><?php echo escape($gallery['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="status">
                        Status <span style="color: #f46a6a;">*</span>
                    </label>
                    <select id="status" name="status" required>
                        <option value="active" <?php echo (isset($gallery['status']) && $gallery['status'] == 'active') ? 'selected' : ''; ?>>Aktivan</option>
                        <option value="inactive" <?php echo (isset($gallery['status']) && $gallery['status'] == 'inactive') ? 'selected' : ''; ?>>Neaktivan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="sort_order">Redosled sortiranja</label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           value="<?php echo escape($gallery['sort_order'] ?? 0); ?>" 
                           min="0"
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                    <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">
                        Manji brojevi se prikazuju prvi
                    </small>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="<?php echo ADMIN_URL; ?>/galleries" class="btn btn-cancel">
                    Otkaži
                </a>
                <button type="submit" class="btn btn-submit">
                    <?php echo $isEdit ? 'Sačuvaj izmene' : 'Kreiraj galeriju'; ?>
                </button>
            </div>
        </form>
    </div>
</div>
