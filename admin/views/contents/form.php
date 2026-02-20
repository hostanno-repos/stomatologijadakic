<?php
/**
 * Contents Form View (Edit)
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
?>

<div class="contents-form-page">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">
            Izmeni sadržaj: <?php echo escape($page); ?>
        </h1>
        <a href="<?php echo ADMIN_URL; ?>/contents?page=<?php echo urlencode($page); ?>" 
           style="color: #74788d; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">
            ← Nazad na sadržaje
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
        <form method="POST" action="<?php echo ADMIN_URL; ?>/contents/update" id="contentsForm">
            <input type="hidden" name="csrf_token" value="<?php echo escape($csrf_token); ?>">
            <input type="hidden" name="page" value="<?php echo escape($page); ?>">
            
            <?php if (!empty($contents)): ?>
                <?php foreach ($contents as $content): ?>
                    <div class="form-group" style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <label style="display: block; color: #495057; font-weight: 600; font-size: 0.875rem;">
                                <?php echo escape($content['key_name']); ?>
                            </label>
                            <a href="<?php echo ADMIN_URL; ?>/contents/delete/<?php echo $content['id']; ?>?token=<?php echo generateCsrfToken(); ?>" 
                               onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj sadržaj?');"
                               style="padding: 0.25rem 0.5rem; background: #f46a6a; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.75rem;">
                                Obriši
                            </a>
                        </div>
                        
                        <?php if ($content['description']): ?>
                            <div style="font-size: 0.75rem; color: #74788d; margin-bottom: 0.5rem; font-style: italic;">
                                <?php echo escape($content['description']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <input type="text" 
                               name="desc_<?php echo escape($content['key_name']); ?>" 
                               value="<?php echo escape($content['description'] ?? ''); ?>" 
                               placeholder="Opis (opciono)"
                               style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; margin-bottom: 0.5rem;">
                        
                        <textarea name="content_<?php echo escape($content['key_name']); ?>" 
                                  rows="4"
                                  style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; font-family: inherit; resize: vertical;"><?php echo htmlspecialchars($content['value']); ?></textarea>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="padding: 2rem; text-align: center; color: #74788d;">
                    <p>Nema postojećih sadržaja za ovu stranicu. Dodajte novi sadržaj ispod.</p>
                </div>
            <?php endif; ?>
            
            <!-- Add new content field -->
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e9ecef;">
                <h3 style="margin: 0 0 1rem 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">Dodaj novi sadržaj</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                            Ključ (key) <span style="color: #f46a6a;">*</span>
                        </label>
                        <input type="text" 
                               id="new_key_name" 
                               placeholder="npr. address, phone, title"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                            Opis (opciono)
                        </label>
                        <input type="text" 
                               id="new_description" 
                               placeholder="Kratak opis šta je ovo"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Sadržaj <span style="color: #f46a6a;">*</span>
                    </label>
                    <textarea id="new_value" 
                              rows="4"
                              placeholder="Unesite sadržaj..."
                              style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; font-family: inherit; resize: vertical;"></textarea>
                </div>
                <button type="button" 
                        id="addFieldBtn"
                        style="margin-top: 1rem; padding: 0.625rem 1.25rem; background: #34c38f; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                    + Dodaj polje
                </button>
            </div>
            
            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e9ecef;">
                <a href="<?php echo ADMIN_URL; ?>/contents" class="btn btn-cancel" style="padding: 0.625rem 1.25rem; background: #74788d; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; transition: all 0.2s;">
                    Otkaži
                </a>
                <button type="submit" class="btn btn-submit" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.2s;">
                    Sačuvaj izmene
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addFieldBtn = document.getElementById('addFieldBtn');
    const newKeyName = document.getElementById('new_key_name');
    const newDescription = document.getElementById('new_description');
    const newValue = document.getElementById('new_value');
    const form = document.getElementById('contentsForm');
    
    addFieldBtn.addEventListener('click', function() {
        const keyName = newKeyName.value.trim();
        const description = newDescription.value.trim();
        const value = newValue.value.trim();
        
        if (!keyName || !value) {
            alert('Ključ i sadržaj su obavezni!');
            return;
        }
        
        // Check if key already exists
        const existingInput = document.querySelector(`input[name="desc_${keyName}"]`);
        if (existingInput) {
            alert('Ključ već postoji!');
            return;
        }
        
        // Create new field group
        const fieldGroup = document.createElement('div');
        fieldGroup.className = 'form-group';
        fieldGroup.style.cssText = 'margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e9ecef;';
        
        fieldGroup.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <label style="display: block; color: #495057; font-weight: 600; font-size: 0.875rem;">
                    ${keyName}
                </label>
            </div>
            ${description ? `<div style="font-size: 0.75rem; color: #74788d; margin-bottom: 0.5rem; font-style: italic;">${description}</div>` : ''}
            <input type="text" 
                   name="desc_${keyName}" 
                   value="${description}" 
                   placeholder="Opis (opciono)"
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; margin-bottom: 0.5rem;">
            <textarea name="content_${keyName}" 
                      rows="4"
                      style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; font-family: inherit; resize: vertical;">${value}</textarea>
        `;
        
        // Insert before the "Add new content" section
        const addNewSection = document.querySelector('[style*="border-top: 2px solid"]');
        form.insertBefore(fieldGroup, addNewSection);
        
        // Clear inputs
        newKeyName.value = '';
        newDescription.value = '';
        newValue.value = '';
    });
});
</script>
