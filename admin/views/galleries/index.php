<?php
/**
 * Galleries List View
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

<div class="galleries-page">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">Upravljanje galerijama</h1>
        <a href="<?php echo ADMIN_URL; ?>/galleries/create" class="btn btn-primary">
            + Kreiraj novu galeriju
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
    
    <!-- Search and Filters -->
    <div class="galleries-filters" style="background: white; padding: 1.25rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; margin-bottom: 1.5rem;">
        <form method="GET" action="<?php echo ADMIN_URL; ?>/galleries" style="display: flex; gap: 1rem; align-items: center;">
            <input type="text" 
                   name="search" 
                   value="<?php echo escape($search ?? ''); ?>" 
                   placeholder="Pretraži galerije..." 
                   style="flex: 1; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
            <button type="submit" class="btn btn-search" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 500;">
                Pretraži
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?php echo ADMIN_URL; ?>/galleries" class="btn btn-clear" style="padding: 0.625rem 1.25rem; background: #74788d; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                    Obriši
                </a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Galleries Grid -->
    <?php if (empty($galleries)): ?>
        <div class="empty-state" style="background: white; padding: 3rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; text-align: center;">
            <p style="color: #74788d; margin-bottom: 1rem;">Nema pronađenih galerija.</p>
            <a href="<?php echo ADMIN_URL; ?>/galleries/create" class="btn btn-primary">Kreiraj svoju prvu galeriju</a>
        </div>
    <?php else: ?>
        <div class="galleries-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            <?php foreach ($galleries as $gallery): ?>
                <div class="gallery-card" style="background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; overflow: hidden; transition: all 0.3s ease;">
                    <div class="gallery-card-image" style="width: 100%; height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        <?php if ($gallery['cover_image']): ?>
                            <img src="<?php echo ADMIN_URL . $gallery['cover_image']; ?>" alt="<?php echo escape($gallery['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <svg width="64" height="64" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.3;">
                                <path d="M2 4C2 2.89543 2.89543 2 4 2H6C7.10457 2 8 2.89543 8 4V6C8 7.10457 7.10457 8 6 8H4C2.89543 8 2 7.10457 2 6V4Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M12 4C12 2.89543 12.8954 2 14 2H16C17.1046 2 18 2.89543 18 4V6C18 7.10457 17.1046 8 16 8H14C12.8954 8 12 7.10457 12 6V4Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M2 14C2 12.8954 2.89543 12 4 12H6C7.10457 12 8 12.8954 8 14V16C8 17.1046 7.10457 18 6 18H4C2.89543 18 2 17.1046 2 16V14Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M12 14C12 12.8954 12.8954 12 14 12H16C17.1046 12 18 12.8954 18 14V16C18 17.1046 17.1046 18 16 18H14C12.8954 18 12 17.1046 12 16V14Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        <?php endif; ?>
                        <div class="gallery-card-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: 500;"><?php echo (int)($gallery['image_count'] ?? 0); ?> slika</span>
                        </div>
                    </div>
                    <div class="gallery-card-content" style="padding: 1.25rem;">
                        <h3 style="margin: 0 0 0.5rem 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">
                            <?php echo escape($gallery['title']); ?>
                        </h3>
                        <?php if (!empty($gallery['description'])): ?>
                            <p style="color: #74788d; font-size: 0.875rem; margin: 0 0 1rem 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?php echo escape($gallery['description']); ?>
                            </p>
                        <?php endif; ?>
                        <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                            <span class="badge badge-status" style="padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;
                                <?php
                                $statusColors = [
                                    'active' => 'background: #34c38f; color: white;',
                                    'inactive' => 'background: #74788d; color: white;'
                                ];
                                echo $statusColors[$gallery['status']] ?? 'background: #74788d; color: white;';
                                ?>">
                                <?php 
                                $statusTranslations = [
                                    'active' => 'Aktivan',
                                    'inactive' => 'Neaktivan'
                                ];
                                echo escape($statusTranslations[$gallery['status']] ?? $gallery['status']); 
                                ?>
                            </span>
                            <span style="color: #74788d; font-size: 0.75rem; margin-left: auto;">
                                <?php echo (int)($gallery['image_count'] ?? 0); ?> slika
                            </span>
                        </div>
                        <div style="display: flex; gap: 0.5rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
                            <a href="<?php echo ADMIN_URL; ?>/galleries/view/<?php echo $gallery['id']; ?>" 
                               class="btn-edit" 
                               style="flex: 1; padding: 0.5rem; background: #50a5f1; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem; text-align: center; transition: all 0.2s;">
                                Pregled
                            </a>
                            <a href="<?php echo ADMIN_URL; ?>/galleries/edit/<?php echo $gallery['id']; ?>" 
                               class="btn-edit" 
                               style="flex: 1; padding: 0.5rem; background: #f1b44c; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem; text-align: center; transition: all 0.2s;">
                                Izmeni
                            </a>
                            <a href="<?php echo ADMIN_URL; ?>/galleries/delete/<?php echo $gallery['id']; ?>?token=<?php echo generateCsrfToken(); ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Da li ste sigurni da želite da obrišete ovu galeriju? Sve slike će biti obrisane.');"
                               style="flex: 1; padding: 0.5rem; background: #f46a6a; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem; text-align: center; transition: all 0.2s;">
                                Obriši
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination" style="margin-top: 2rem; padding: 1rem; background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #74788d; font-size: 0.875rem;">
                    Prikazano <?php echo count($galleries); ?> od <?php echo $total_galleries; ?> galerija
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <?php if ($current_page > 1): ?>
                        <a href="<?php echo ADMIN_URL; ?>/galleries?page=<?php echo $current_page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="btn-pagination">
                            Prethodna
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <span style="padding: 0.5rem 0.875rem; background: #556ee6; color: white; border-radius: 0.25rem; font-size: 0.875rem; font-weight: 500;">
                                <?php echo $i; ?>
                            </span>
                        <?php else: ?>
                            <a href="<?php echo ADMIN_URL; ?>/galleries?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                               class="btn-pagination">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <a href="<?php echo ADMIN_URL; ?>/galleries?page=<?php echo $current_page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="btn-pagination">
                            Sledeća
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.gallery-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

.gallery-card:hover .gallery-card-overlay {
    opacity: 1;
}

@media (max-width: 768px) {
    .galleries-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
