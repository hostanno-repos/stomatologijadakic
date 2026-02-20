<?php
/**
 * Contents List View
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

<div class="contents-page">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">Upravljanje sadržajima</h1>
        <a href="<?php echo ADMIN_URL; ?>/database/import_contents_web.php" class="btn btn-primary" style="padding: 0.625rem 1.25rem; background: #34c38f; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; transition: all 0.2s;">
            Uvezi postojeće tekstove
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
    
    <!-- Filters -->
    <div class="contents-filters" style="background: white; padding: 1.25rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; margin-bottom: 1.5rem;">
        <form method="GET" action="<?php echo ADMIN_URL; ?>/contents" style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: end;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.875rem;">Stranica</label>
                <select name="page" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                    <option value="">Sve stranice</option>
                    <?php foreach ($available_pages as $pageKey => $pageName): ?>
                        <option value="<?php echo escape($pageKey); ?>" <?php echo $selected_page === $pageKey ? 'selected' : ''; ?>>
                            <?php echo escape($pageName); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-search" style="padding: 0.625rem 1.25rem; background: #556ee6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 500; height: fit-content;">
                    Filtriraj
                </button>
            </div>
        </form>
    </div>
    
    <!-- Contents grouped by page -->
    <?php if (empty($all_contents)): ?>
        <div class="empty-state" style="background: white; padding: 3rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; text-align: center;">
            <p style="color: #74788d; margin-bottom: 1rem;">Nema sadržaja. Kliknite na "Uvezi postojeće tekstove" da automatski unesete tekstove sa frontend sajta.</p>
            <a href="<?php echo ADMIN_URL; ?>/database/import_contents_web.php" class="btn btn-primary" style="padding: 0.625rem 1.25rem; background: #34c38f; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                Uvezi postojeće tekstove
            </a>
        </div>
    <?php else: ?>
        <div class="contents-list" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach ($all_contents as $page => $pageContents): ?>
                <div class="page-group" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid #e9ecef;">
                        <h2 style="margin: 0; color: #343a40; font-size: 1.25rem; font-weight: 600;">
                            <?php echo escape($available_pages[$page] ?? $page); ?>
                        </h2>
                        <a href="<?php echo ADMIN_URL; ?>/contents/edit?page=<?php echo urlencode($page); ?>" 
                           style="padding: 0.5rem 1rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500;">
                            Izmeni
                        </a>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
                        <?php foreach ($pageContents as $content): ?>
                            <div style="padding: 1rem; background: #f8f9fa; border-radius: 0.375rem; border: 1px solid #e9ecef;">
                                <div style="font-size: 0.75rem; color: #74788d; margin-bottom: 0.5rem; font-weight: 600; text-transform: uppercase;">
                                    <?php echo escape($content['key_name']); ?>
                                </div>
                                <?php if ($content['description']): ?>
                                    <div style="font-size: 0.7rem; color: #adb5bd; margin-bottom: 0.5rem; font-style: italic;">
                                        <?php echo escape($content['description']); ?>
                                    </div>
                                <?php endif; ?>
                                <div style="font-size: 0.875rem; color: #495057; line-height: 1.5; max-height: 4em; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo escape(strip_tags(substr($content['value'], 0, 150))); ?><?php echo strlen($content['value']) > 150 ? '...' : ''; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Quick Actions -->
    <div style="margin-top: 2rem; padding: 1.5rem; background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
        <h3 style="margin: 0 0 1rem 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">Brze akcije</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <?php foreach ($available_pages as $pageKey => $pageName): ?>
                <a href="<?php echo ADMIN_URL; ?>/contents/edit?page=<?php echo urlencode($pageKey); ?>" 
                   style="display: block; padding: 0.875rem; background: #f8f9fa; border-radius: 0.375rem; text-decoration: none; color: #495057; border: 1px solid #e9ecef; transition: all 0.2s;">
                    <strong style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem;"><?php echo escape($pageName); ?></strong>
                    <span style="font-size: 0.75rem; color: #74788d;">Izmeni sadržaj</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
