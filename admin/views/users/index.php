<?php
/**
 * Users List View
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

<div class="users-page">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">Upravljanje korisnicima</h1>
        <a href="<?php echo ADMIN_URL; ?>/users/create" class="btn btn-primary" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; transition: all 0.2s;">
            + Dodaj novog korisnika
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
    
    <!-- Search and Filters -->
    <div class="users-filters" style="background: white; padding: 1.25rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; margin-bottom: 1.5rem;">
        <form method="GET" action="<?php echo ADMIN_URL; ?>/users" style="display: flex; gap: 1rem; align-items: center;">
            <input type="text" 
                   name="search" 
                   value="<?php echo escape($search ?? ''); ?>" 
                   placeholder="Pretraži korisnike..." 
                   style="flex: 1; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
            <button type="submit" class="btn btn-search" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 500;">
                Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?php echo ADMIN_URL; ?>/users" class="btn btn-clear" style="padding: 0.625rem 1.25rem; background: #74788d; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                    Obriši
                </a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Users Table -->
    <div class="users-table-container" style="background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; overflow: hidden;">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="users-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">ID</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Username</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Email</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Name</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Role</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Status</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Last Login</th>
                        <th style="padding: 0.875rem; text-align: center; font-weight: 600; color: #495057; font-size: 0.875rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="8" style="padding: 2rem; text-align: center; color: #74788d;">
                                Nema pronađenih korisnika. <a href="<?php echo ADMIN_URL; ?>/users/create" style="color: #556ee6;">Kreiraj jednog sada</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr style="border-bottom: 1px solid #e9ecef; transition: background-color 0.2s;">
                                <td style="padding: 0.875rem; color: #495057; font-size: 0.875rem;"><?php echo escape($user['id']); ?></td>
                                <td style="padding: 0.875rem; color: #495057; font-size: 0.875rem; font-weight: 500;"><?php echo escape($user['username']); ?></td>
                                <td style="padding: 0.875rem; color: #495057; font-size: 0.875rem;"><?php echo escape($user['email']); ?></td>
                                <td style="padding: 0.875rem; color: #495057; font-size: 0.875rem;">
                                    <?php echo escape(trim($user['first_name'] . ' ' . $user['last_name']) ?: '-'); ?>
                                </td>
                                <td style="padding: 0.875rem;">
                                    <span class="badge badge-role" style="padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; 
                                        <?php 
                                        $roleColors = [
                                            'admin' => 'background: #556ee6; color: white;',
                                            'editor' => 'background: #50a5f1; color: white;',
                                            'author' => 'background: #74788d; color: white;'
                                        ];
                                        echo $roleColors[$user['role']] ?? 'background: #74788d; color: white;';
                                        ?>">
                                        <?php 
                                        $roleTranslations = [
                                            'admin' => 'Administrator',
                                            'editor' => 'Urednik',
                                            'author' => 'Autor'
                                        ];
                                        echo escape($roleTranslations[$user['role']] ?? $user['role']); 
                                        ?>
                                    </span>
                                </td>
                                <td style="padding: 0.875rem;">
                                    <span class="badge badge-status" style="padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;
                                        <?php
                                        $statusColors = [
                                            'active' => 'background: #34c38f; color: white;',
                                            'inactive' => 'background: #74788d; color: white;',
                                            'suspended' => 'background: #f46a6a; color: white;'
                                        ];
                                        echo $statusColors[$user['status']] ?? 'background: #74788d; color: white;';
                                        ?>">
                                        <?php 
                                        $statusTranslations = [
                                            'active' => 'Aktivan',
                                            'inactive' => 'Neaktivan',
                                            'suspended' => 'Suspendovan'
                                        ];
                                        echo escape($statusTranslations[$user['status']] ?? $user['status']); 
                                        ?>
                                    </span>
                                </td>
                                <td style="padding: 0.875rem; color: #74788d; font-size: 0.875rem;">
                                    <?php echo $user['last_login'] ? date('d.m.Y H:i', strtotime($user['last_login'])) : 'Nikad'; ?>
                                </td>
                                <td style="padding: 0.875rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?php echo ADMIN_URL; ?>/users/edit/<?php echo $user['id']; ?>" 
                                           class="btn-edit" 
                                           style="padding: 0.375rem 0.75rem; background: #50a5f1; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem; transition: all 0.2s;">
                                            Izmeni
                                        </a>
                                        <?php if ($user['id'] != $_SESSION['admin_user_id']): ?>
                                            <a href="<?php echo ADMIN_URL; ?>/users/delete/<?php echo $user['id']; ?>?token=<?php echo generateCsrfToken(); ?>" 
                                               class="btn-delete" 
                                               onclick="return confirm('Da li ste sigurni da želite da obrišete ovog korisnika?');"
                                               style="padding: 0.375rem 0.75rem; background: #f46a6a; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem; transition: all 0.2s;">
                                                Obriši
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination" style="padding: 1rem; border-top: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #74788d; font-size: 0.875rem;">
                    Prikazano <?php echo count($users); ?> od <?php echo $total_users; ?> korisnika
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <?php if ($current_page > 1): ?>
                        <a href="<?php echo ADMIN_URL; ?>/users?page=<?php echo $current_page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="btn-pagination" 
                           style="padding: 0.5rem 0.875rem; background: white; color: #495057; text-decoration: none; border: 1px solid #e9ecef; border-radius: 0.25rem; font-size: 0.875rem;">
                            Prethodna
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <span style="padding: 0.5rem 0.875rem; background: #556ee6; color: white; border-radius: 0.25rem; font-size: 0.875rem; font-weight: 500;">
                                <?php echo $i; ?>
                            </span>
                        <?php else: ?>
                            <a href="<?php echo ADMIN_URL; ?>/users?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                               class="btn-pagination" 
                               style="padding: 0.5rem 0.875rem; background: white; color: #495057; text-decoration: none; border: 1px solid #e9ecef; border-radius: 0.25rem; font-size: 0.875rem;">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <a href="<?php echo ADMIN_URL; ?>/users?page=<?php echo $current_page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="btn-pagination" 
                           style="padding: 0.5rem 0.875rem; background: white; color: #495057; text-decoration: none; border: 1px solid #e9ecef; border-radius: 0.25rem; font-size: 0.875rem;">
                            Sledeća
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.btn-primary:hover {
    background: #4857d4 !important;
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.5rem rgba(85, 110, 230, 0.3);
}

.btn-edit:hover {
    background: #3d8fd8 !important;
}

.btn-delete:hover {
    background: #d85a5a !important;
}

.btn-pagination:hover {
    background: #f8f9fa !important;
    border-color: #556ee6 !important;
}

tr:hover {
    background-color: #f8f9fa !important;
}
</style>
