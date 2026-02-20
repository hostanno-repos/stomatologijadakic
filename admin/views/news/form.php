<?php
/**
 * News Form View (Create/Edit)
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
$isEdit = isset($news) && !empty($news['id']);
$actionUrl = $isEdit ? ADMIN_URL . '/news/update/' . $news['id'] : ADMIN_URL . '/news/store';

// Parse published date and time
$publishedDate = '';
$publishedTime = '00:00';
if ($isEdit && !empty($news['published_date'])) {
    $publishedDateTime = new DateTime($news['published_date']);
    $publishedDate = $publishedDateTime->format('Y-m-d');
    $publishedTime = $publishedDateTime->format('H:i');
}
?>

<div class="news-form-page">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">
            <?php echo $isEdit ? 'Izmeni novost' : 'Kreiraj novu novost'; ?>
        </h1>
        <a href="<?php echo ADMIN_URL; ?>/news" style="color: #74788d; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">
            ← Nazad na novosti
        </a>
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
        <form method="POST" action="<?php echo $actionUrl; ?>" id="newsForm" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo escape($csrf_token); ?>">
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="title" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                    Naslov <span style="color: #f46a6a;">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="<?php echo escape($news['title'] ?? ''); ?>" 
                       required
                       style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; transition: border-color 0.2s;">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="excerpt" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                    Kratak opis (excerpt)
                </label>
                <textarea id="excerpt" 
                          name="excerpt" 
                          rows="3"
                          style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; font-family: inherit; resize: vertical;"><?php echo escape($news['excerpt'] ?? ''); ?></textarea>
                <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">
                    Kratak opis koji će biti prikazan u listi novosti
                </small>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="content" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                    Sadržaj <span style="color: #f46a6a;">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="15"
                          required
                          style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; font-family: inherit; resize: vertical;"><?php echo htmlspecialchars($news['content'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="featured_image" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                    Naslovna slika
                </label>
                <?php if ($isEdit && !empty($news['featured_image'])): ?>
                    <div style="margin-bottom: 0.75rem;">
                        <img src="<?php echo ADMIN_URL . '/' . ltrim($news['featured_image'], '/'); ?>" 
                             alt="Featured image" 
                             style="max-width: 300px; max-height: 200px; border-radius: 0.375rem; border: 1px solid #e9ecef;">
                        <div style="margin-top: 0.5rem;">
                            <label style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="remove_featured_image" value="1" style="cursor: pointer;">
                                <span style="color: #f46a6a; font-size: 0.875rem;">Obriši naslovnu sliku</span>
                            </label>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="file" 
                       id="featured_image" 
                       name="featured_image" 
                       accept="image/jpeg,image/png,image/gif,image/webp"
                       style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">
                    JPEG, PNG, GIF, WebP - Maksimum 5MB
                </small>
            </div>
            
            <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="status" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Status <span style="color: #f46a6a;">*</span>
                    </label>
                    <select id="status" name="status" required style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                        <option value="draft" <?php echo (isset($news['status']) && $news['status'] == 'draft') ? 'selected' : ''; ?>>Nacrt</option>
                        <option value="published" <?php echo (isset($news['status']) && $news['status'] == 'published') ? 'selected' : ''; ?>>Objavljeno</option>
                        <option value="archived" <?php echo (isset($news['status']) && $news['status'] == 'archived') ? 'selected' : ''; ?>>Arhivirano</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="published_date" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Datum objave
                    </label>
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 0.5rem;">
                        <input type="date" 
                               id="published_date" 
                               name="published_date" 
                               value="<?php echo $publishedDate; ?>"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                        <input type="time" 
                               id="published_time" 
                               name="published_time" 
                               value="<?php echo $publishedTime; ?>"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>
                    <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">
                        Ručno definisanje datuma objave (može biti u prošlosti ili budućnosti)
                    </small>
                </div>
            </div>
            
            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e9ecef;">
                <a href="<?php echo ADMIN_URL; ?>/news" class="btn btn-cancel" style="padding: 0.625rem 1.25rem; background: #74788d; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; transition: all 0.2s;">
                    Otkaži
                </a>
                <button type="submit" class="btn btn-submit" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.2s;">
                    <?php echo $isEdit ? 'Sačuvaj izmene' : 'Kreiraj novost'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Simple rich text editor enhancement (can be replaced with CKEditor or TinyMCE)
document.addEventListener('DOMContentLoaded', function() {
    const contentTextarea = document.getElementById('content');
    if (contentTextarea) {
        // Add basic formatting buttons
        const editorContainer = document.createElement('div');
        editorContainer.style.marginBottom = '0.5rem';
        
        const boldBtn = document.createElement('button');
        boldBtn.type = 'button';
        boldBtn.innerHTML = '<strong>B</strong>';
        boldBtn.style.cssText = 'padding: 0.25rem 0.5rem; margin-right: 0.25rem; border: 1px solid #e9ecef; background: white; border-radius: 0.25rem; cursor: pointer;';
        boldBtn.onclick = function() {
            document.execCommand('bold', false, null);
            contentTextarea.focus();
        };
        
        const italicBtn = document.createElement('button');
        italicBtn.type = 'button';
        italicBtn.innerHTML = '<em>I</em>';
        italicBtn.style.cssText = 'padding: 0.25rem 0.5rem; margin-right: 0.25rem; border: 1px solid #e9ecef; background: white; border-radius: 0.25rem; cursor: pointer;';
        italicBtn.onclick = function() {
            document.execCommand('italic', false, null);
            contentTextarea.focus();
        };
        
        editorContainer.appendChild(boldBtn);
        editorContainer.appendChild(italicBtn);
        contentTextarea.parentNode.insertBefore(editorContainer, contentTextarea);
    }
});
</script>
