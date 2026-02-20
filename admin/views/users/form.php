<?php
/**
 * User Form View (Create/Edit)
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
$isEdit = isset($user) && !empty($user['id']);
$actionUrl = $isEdit ? ADMIN_URL . '/users/update/' . $user['id'] : ADMIN_URL . '/users/store';
?>

<div class="user-form-page">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">
            <?php echo $isEdit ? 'Izmeni korisnika' : 'Kreiraj novog korisnika'; ?>
        </h1>
        <a href="<?php echo ADMIN_URL; ?>/users" style="color: #74788d; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">
            ← Nazad na korisnike
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
        <form method="POST" action="<?php echo $actionUrl; ?>" id="userForm">
            <input type="hidden" name="csrf_token" value="<?php echo escape($csrf_token); ?>">
            
            <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="username" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Korisničko ime <span style="color: #f46a6a;">*</span>
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="<?php echo escape($user['username'] ?? ''); ?>" 
                           required 
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; transition: border-color 0.2s;">
                </div>
                
                <div class="form-group">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Email <span style="color: #f46a6a;">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?php echo escape($user['email'] ?? ''); ?>" 
                           required 
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; transition: border-color 0.2s;">
                </div>
            </div>
            
            <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="first_name" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Ime
                    </label>
                    <input type="text" 
                           id="first_name" 
                           name="first_name" 
                           value="<?php echo escape($user['first_name'] ?? ''); ?>" 
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; transition: border-color 0.2s;">
                </div>
                
                <div class="form-group">
                    <label for="last_name" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Prezime
                    </label>
                    <input type="text" 
                           id="last_name" 
                           name="last_name" 
                           value="<?php echo escape($user['last_name'] ?? ''); ?>" 
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; transition: border-color 0.2s;">
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                    Lozinka <?php if (!$isEdit): ?><span style="color: #f46a6a;">*</span><?php else: ?><span style="color: #74788d; font-size: 0.75rem;">(ostavite prazno da zadržite trenutnu)</span><?php endif; ?>
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       <?php if (!$isEdit): ?>required<?php endif; ?>
                       minlength="<?php echo PASSWORD_MIN_LENGTH; ?>"
                       style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; transition: border-color 0.2s;">
                <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">
                    Minimum <?php echo PASSWORD_MIN_LENGTH; ?> characters
                </small>
            </div>
            
            <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="role" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Uloga <span style="color: #f46a6a;">*</span>
                    </label>
                    <select id="role" 
                            name="role" 
                            required 
                            style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; background: white; cursor: pointer;">
                        <option value="author" <?php echo (isset($user['role']) && $user['role'] == 'author') ? 'selected' : ''; ?>>Autor</option>
                        <option value="editor" <?php echo (isset($user['role']) && $user['role'] == 'editor') ? 'selected' : ''; ?>>Urednik</option>
                        <option value="admin" <?php echo (isset($user['role']) && $user['role'] == 'admin') ? 'selected' : ''; ?>>Administrator</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">
                        Status <span style="color: #f46a6a;">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            required 
                            style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem; background: white; cursor: pointer;">
                        <option value="active" <?php echo (isset($user['status']) && $user['status'] == 'active') ? 'selected' : ''; ?>>Aktivan</option>
                        <option value="inactive" <?php echo (isset($user['status']) && $user['status'] == 'inactive') ? 'selected' : ''; ?>>Neaktivan</option>
                        <option value="suspended" <?php echo (isset($user['status']) && $user['status'] == 'suspended') ? 'selected' : ''; ?>>Suspendovan</option>
                    </select>
                </div>
            </div>
            
            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1.5rem; border-top: 1px solid #e9ecef;">
                <a href="<?php echo ADMIN_URL; ?>/users" 
                   class="btn btn-cancel" 
                   style="padding: 0.625rem 1.25rem; background: #f8f9fa; color: #495057; text-decoration: none; border-radius: 0.375rem; font-weight: 500; border: 1px solid #e9ecef;">
                    Otkaži
                </a>
                <button type="submit" 
                        class="btn btn-submit" 
                        style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.2s;">
                    <?php echo $isEdit ? 'Sačuvaj izmene' : 'Kreiraj korisnika'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #556ee6 !important;
    box-shadow: 0 0 0 0.2rem rgba(85, 110, 230, 0.25);
}

.btn-submit:hover {
    background: #4857d4 !important;
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.5rem rgba(85, 110, 230, 0.3);
}

.btn-cancel:hover {
    background: #e9ecef !important;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
