<?php
/**
 * News List View
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

<div class="news-page">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">Upravljanje novostima</h1>
        <a href="<?php echo ADMIN_URL; ?>/news/create" class="btn btn-primary" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; transition: all 0.2s;">
            + Kreiraj novu novost
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
    <div class="news-filters" style="background: white; padding: 1.25rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; margin-bottom: 1.5rem;">
        <form method="GET" action="<?php echo ADMIN_URL; ?>/news" style="display: flex; gap: 1rem; align-items: center;">
            <input type="text" 
                   name="search" 
                   value="<?php echo escape($search ?? ''); ?>" 
                   placeholder="Pretraži novosti..." 
                   style="flex: 1; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
            <button type="submit" class="btn btn-search" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 500;">
                Pretraži
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?php echo ADMIN_URL; ?>/news" class="btn btn-clear" style="padding: 0.625rem 1.25rem; background: #74788d; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                    Obriši
                </a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- News Table -->
    <div class="news-table-container" style="background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; overflow: hidden;">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="news-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Naslov</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Status</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Datum objave</th>
                        <th style="padding: 0.875rem; text-align: left; font-weight: 600; color: #495057; font-size: 0.875rem;">Kreirano</th>
                        <th style="padding: 0.875rem; text-align: center; font-weight: 600; color: #495057; font-size: 0.875rem;">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($news)): ?>
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #74788d;">
                                Nema pronađenih novosti. <a href="<?php echo ADMIN_URL; ?>/news/create" style="color: #556ee6;">Kreiraj jednu sada</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($news as $item): ?>
                            <tr style="border-bottom: 1px solid #e9ecef; transition: background-color 0.2s;">
                                <td style="padding: 0.875rem;">
                                    <div style="font-weight: 500; color: #343a40; margin-bottom: 0.25rem;">
                                        <?php echo escape($item['title']); ?>
                                    </div>
                                    <?php if (!empty($item['excerpt'])): ?>
                                        <div style="font-size: 0.75rem; color: #74788d; line-height: 1.4;">
                                            <?php echo escape(substr($item['excerpt'], 0, 100)) . (strlen($item['excerpt']) > 100 ? '...' : ''); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 0.875rem;">
                                    <?php
                                    $statusTranslations = [
                                        'draft' => ['text' => 'Nacrt', 'color' => '#74788d'],
                                        'published' => ['text' => 'Objavljeno', 'color' => '#34c38f'],
                                        'archived' => ['text' => 'Arhivirano', 'color' => '#f46a6a']
                                    ];
                                    $statusInfo = $statusTranslations[$item['status']] ?? ['text' => $item['status'], 'color' => '#74788d'];
                                    ?>
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: <?php echo $statusInfo['color']; ?>20; color: <?php echo $statusInfo['color']; ?>; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">
                                        <?php echo $statusInfo['text']; ?>
                                    </span>
                                </td>
                                <td style="padding: 0.875rem; color: #495057; font-size: 0.875rem;">
                                    <?php 
                                    if ($item['published_date']) {
                                        echo date('d.m.Y H:i', strtotime($item['published_date']));
                                    } else {
                                        echo '<span style="color: #74788d;">Nije postavljeno</span>';
                                    }
                                    ?>
                                </td>
                                <td style="padding: 0.875rem; color: #495057; font-size: 0.875rem;">
                                    <?php echo date('d.m.Y H:i', strtotime($item['created_at'])); ?>
                                </td>
                                <td style="padding: 0.875rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?php echo ADMIN_URL; ?>/news/edit/<?php echo $item['id']; ?>" 
                                           style="padding: 0.375rem 0.75rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500; transition: all 0.2s;">
                                            Izmeni
                                        </a>
                                        <a href="<?php echo ADMIN_URL; ?>/news/delete/<?php echo $item['id']; ?>?token=<?php echo generateCsrfToken(); ?>" 
                                           onclick="return confirm('Da li ste sigurni da želite da obrišete ovu novost?');"
                                           style="padding: 0.375rem 0.75rem; background: #f46a6a; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500; transition: all 0.2s;">
                                            Obriši
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <div class="pagination" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 1.5rem;">
            <span style="color: #495057; font-size: 0.875rem; margin-right: 1rem;">
                Prikazano <?php echo count($news); ?> od <?php echo $total_news; ?> novosti
            </span>
            <?php if ($current_page > 1): ?>
                <a href="<?php echo ADMIN_URL; ?>/news?page=<?php echo $current_page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                   style="padding: 0.5rem 1rem; background: white; color: #495057; text-decoration: none; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                    Prethodna
                </a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $current_page): ?>
                    <span style="padding: 0.5rem 1rem; background: #556ee6; color: white; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500;">
                        <?php echo $i; ?>
                    </span>
                <?php else: ?>
                    <a href="<?php echo ADMIN_URL; ?>/news?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                       style="padding: 0.5rem 1rem; background: white; color: #495057; text-decoration: none; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                        <?php echo $i; ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if ($current_page < $total_pages): ?>
                <a href="<?php echo ADMIN_URL; ?>/news?page=<?php echo $current_page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                   style="padding: 0.5rem 1rem; background: white; color: #495057; text-decoration: none; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                    Sledeća
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
