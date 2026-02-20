<?php
/**
 * Dashboard View
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}
?>

<div class="dashboard">
    <?php if (isset($user)): ?>
    <div class="welcome-message" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; margin-bottom: 1.5rem;">
        <h2 style="margin-bottom: 0.5rem; color: #343a40; font-size: 1.5rem;">Zdravo, dobrodošli nazad!</h2>
        <p style="color: #74788d; margin: 0;">Dobrodošli nazad, <strong><?php echo escape($user['name'] ?: $user['username']); ?></strong>!</p>
        <?php if (isset($stats['last_login']) && $stats['last_login']): ?>
            <p style="color: #74788d; margin: 0.5rem 0 0 0; font-size: 0.875rem;">
                Poslednja prijava: <strong><?php echo date('d.m.Y H:i', strtotime($stats['last_login'])); ?></strong>
            </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <!-- Statistics Cards -->
    <div class="dashboard-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                <h3 style="margin: 0; color: #74788d; font-size: 0.875rem; font-weight: 500; text-transform: uppercase;">Ukupno korisnika</h3>
                <div style="width: 40px; height: 40px; background: #e7f3ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0 20C0 15.5817 4.47715 12 10 12C15.5228 12 20 15.5817 20 20" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" style="font-size: 2rem; font-weight: 600; color: #343a40; margin-bottom: 0.5rem;">
                <?php echo isset($stats['total_users']) ? number_format($stats['total_users']) : 0; ?>
            </div>
            <div class="stat-label" style="color: #74788d; font-size: 0.875rem;">
                <?php echo isset($stats['active_users']) ? number_format($stats['active_users']) : 0; ?> aktivnih
            </div>
        </div>
        
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                <h3 style="margin: 0; color: #74788d; font-size: 0.875rem; font-weight: 500; text-transform: uppercase;">Galerije</h3>
                <div style="width: 40px; height: 40px; background: #fff4e6; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 4C2 2.89543 2.89543 2 4 2H6C7.10457 2 8 2.89543 8 4V6C8 7.10457 7.10457 8 6 8H4C2.89543 8 2 7.10457 2 6V4Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 4C12 2.89543 12.8954 2 14 2H16C17.1046 2 18 2.89543 18 4V6C18 7.10457 17.1046 8 16 8H14C12.8954 8 12 7.10457 12 6V4Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 14C2 12.8954 2.89543 12 4 12H6C7.10457 12 8 12.8954 8 14V16C8 17.1046 7.10457 18 6 18H4C2.89543 18 2 17.1046 2 16V14Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 14C12 12.8954 12.8954 12 14 12H16C17.1046 12 18 12.8954 18 14V16C18 17.1046 17.1046 18 16 18H14C12.8954 18 12 17.1046 12 16V14Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" style="font-size: 2rem; font-weight: 600; color: #343a40; margin-bottom: 0.5rem;">
                <?php echo isset($stats['total_galleries']) ? number_format($stats['total_galleries']) : 0; ?>
            </div>
            <div class="stat-label" style="color: #74788d; font-size: 0.875rem;">
                <?php echo isset($stats['active_galleries']) ? number_format($stats['active_galleries']) : 0; ?> aktivnih
            </div>
        </div>
        
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                <h3 style="margin: 0; color: #74788d; font-size: 0.875rem; font-weight: 500; text-transform: uppercase;">Ukupno slika</h3>
                <div style="width: 40px; height: 40px; background: #e6f7ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 4C2 2.89543 2.89543 2 4 2H16C17.1046 2 18 2.89543 18 4V16C18 17.1046 17.1046 18 16 18H4C2.89543 18 2 17.1046 2 16V4Z" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 8C7.55228 8 8 7.55228 8 7C8 6.44772 7.55228 6 7 6C6.44772 6 6 6.44772 6 7C6 7.55228 6.44772 8 7 8Z" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 12L13 7L7 13L2 8" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" style="font-size: 2rem; font-weight: 600; color: #343a40; margin-bottom: 0.5rem;">
                <?php echo isset($stats['total_images']) ? number_format($stats['total_images']) : 0; ?>
            </div>
            <div class="stat-label" style="color: #74788d; font-size: 0.875rem;">
                U svim galerijama
            </div>
        </div>
        
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                <h3 style="margin: 0; color: #74788d; font-size: 0.875rem; font-weight: 500; text-transform: uppercase;">Novosti</h3>
                <div style="width: 40px; height: 40px; background: #f3e8ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 3H18C18.5523 3 19 3.44772 19 4V16C19 16.5523 18.5523 17 18 17H2C1.44772 17 1 16.5523 1 16V4C1 3.44772 1.44772 3 2 3Z" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1 6H19" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 3V17" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" style="font-size: 2rem; font-weight: 600; color: #343a40; margin-bottom: 0.5rem;">
                <?php echo isset($stats['total_news']) ? number_format($stats['total_news']) : 0; ?>
            </div>
            <div class="stat-label" style="color: #74788d; font-size: 0.875rem;">
                <?php echo isset($stats['published_news']) ? number_format($stats['published_news']) : 0; ?> objavljenih, 
                <?php echo isset($stats['draft_news']) ? number_format($stats['draft_news']) : 0; ?> nacrta
            </div>
        </div>
    </div>
    
    <!-- Content Grid -->
    <div class="dashboard-content" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
        <!-- Recent News -->
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">Nedavne novosti</h3>
                <a href="<?php echo ADMIN_URL; ?>/news" style="color: #556ee6; text-decoration: none; font-size: 0.875rem; font-weight: 500;">Pogledaj sve →</a>
            </div>
            <?php if (!empty($recent_news)): ?>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($recent_news as $newsItem): ?>
                        <a href="<?php echo ADMIN_URL; ?>/news/edit/<?php echo $newsItem['id']; ?>" 
                           style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: #f8f9fa; border-radius: 0.375rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                            <div style="width: 50px; height: 50px; background: #f3e8ff; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.7;">
                                    <path d="M2 3H18C18.5523 3 19 3.44772 19 4V16C19 16.5523 18.5523 17 18 17H2C1.44772 17 1 16.5523 1 16V4C1 3.44772 1.44772 3 2 3Z" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M1 6H19" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 500; margin-bottom: 0.25rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo escape($newsItem['title']); ?>
                                </div>
                                <div style="font-size: 0.75rem; color: #74788d;">
                                    <?php 
                                    $statusTranslations = [
                                        'draft' => 'Nacrt',
                                        'published' => 'Objavljeno',
                                        'archived' => 'Arhivirano'
                                    ];
                                    $statusColor = [
                                        'draft' => '#74788d',
                                        'published' => '#34c38f',
                                        'archived' => '#f46a6a'
                                    ];
                                    $status = $newsItem['status'] ?? 'draft';
                                    ?>
                                    <span style="display: inline-block; padding: 0.125rem 0.5rem; background: <?php echo $statusColor[$status]; ?>20; color: <?php echo $statusColor[$status]; ?>; border-radius: 0.25rem; margin-right: 0.5rem;">
                                        <?php echo escape($statusTranslations[$status] ?? $status); ?>
                                    </span>
                                    <?php if ($newsItem['published_date']): ?>
                                        <?php echo date('d.m.Y', strtotime($newsItem['published_date'])); ?>
                                    <?php else: ?>
                                        Nije postavljeno
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #74788d; margin: 0; text-align: center; padding: 2rem 0;">
                    Nema novosti. <a href="<?php echo ADMIN_URL; ?>/news/create" style="color: #556ee6;">Kreiraj prvu novost</a>
                </p>
            <?php endif; ?>
        </div>
        
        <!-- Recent Galleries -->
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">Nedavne galerije</h3>
                <a href="<?php echo ADMIN_URL; ?>/galleries" style="color: #556ee6; text-decoration: none; font-size: 0.875rem; font-weight: 500;">Pogledaj sve →</a>
            </div>
            <?php if (!empty($recent_galleries)): ?>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($recent_galleries as $gallery): ?>
                        <a href="<?php echo ADMIN_URL; ?>/galleries/view/<?php echo $gallery['id']; ?>" 
                           style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: #f8f9fa; border-radius: 0.375rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                            <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.5;">
                                    <path d="M2 4C2 2.89543 2.89543 2 4 2H6C7.10457 2 8 2.89543 8 4V6C8 7.10457 7.10457 8 6 8H4C2.89543 8 2 7.10457 2 6V4Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M12 4C12 2.89543 12.8954 2 14 2H16C17.1046 2 18 2.89543 18 4V6C18 7.10457 17.1046 8 16 8H14C12.8954 8 12 7.10457 12 6V4Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M2 14C2 12.8954 2.89543 12 4 12H6C7.10457 12 8 12.8954 8 14V16C8 17.1046 7.10457 18 6 18H4C2.89543 18 2 17.1046 2 16V14Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M12 14C12 12.8954 12.8954 12 14 12H16C17.1046 12 18 12.8954 18 14V16C18 17.1046 17.1046 18 16 18H14C12.8954 18 12 17.1046 12 16V14Z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 500; margin-bottom: 0.25rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo escape($gallery['title']); ?>
                                </div>
                                <div style="font-size: 0.75rem; color: #74788d;">
                                    <?php echo (int)($gallery['image_count'] ?? 0); ?> slika • 
                                    <?php 
                                    $statusTranslations = [
                                        'active' => 'Aktivan',
                                        'inactive' => 'Neaktivan'
                                    ];
                                    echo escape($statusTranslations[$gallery['status']] ?? $gallery['status']); 
                                    ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #74788d; margin: 0; text-align: center; padding: 2rem 0;">
                    Nema galerija. <a href="<?php echo ADMIN_URL; ?>/galleries/create" style="color: #556ee6;">Kreiraj prvu galeriju</a>
                </p>
            <?php endif; ?>
        </div>
        
        <!-- Recent Users (Admin only) -->
        <?php if (isset($user['role']) && $user['role'] === 'admin' && !empty($recent_users)): ?>
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">Nedavni korisnici</h3>
                <a href="<?php echo ADMIN_URL; ?>/users" style="color: #556ee6; text-decoration: none; font-size: 0.875rem; font-weight: 500;">Pogledaj sve →</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <?php foreach ($recent_users as $recentUser): ?>
                    <a href="<?php echo ADMIN_URL; ?>/users/edit/<?php echo $recentUser['id']; ?>" 
                       style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: #f8f9fa; border-radius: 0.375rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                        <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.5;">
                                <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M0 20C0 15.5817 4.47715 12 10 12C15.5228 12 20 15.5817 20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 500; margin-bottom: 0.25rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?php echo escape($recentUser['username']); ?>
                            </div>
                            <div style="font-size: 0.75rem; color: #74788d;">
                                <?php 
                                $roleTranslations = [
                                    'admin' => 'Administrator',
                                    'editor' => 'Urednik',
                                    'author' => 'Autor'
                                ];
                                echo escape($roleTranslations[$recentUser['role']] ?? $recentUser['role']); 
                                ?> • 
                                <?php 
                                $statusTranslations = [
                                    'active' => 'Aktivan',
                                    'inactive' => 'Neaktivan',
                                    'suspended' => 'Suspendovan'
                                ];
                                echo escape($statusTranslations[$recentUser['status']] ?? $recentUser['status']); 
                                ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Quick Actions -->
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef;">
            <h3 style="margin-bottom: 1rem; color: #343a40; font-size: 1.125rem; font-weight: 600;">Brze akcije</h3>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="<?php echo ADMIN_URL; ?>/users/create" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem; background: #f8f9fa; border-radius: 0.5rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                    <div style="width: 36px; height: 36px; background: #e7f3ff; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 5V15M5 10H15" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <strong style="display: block; margin-bottom: 0.125rem; font-size: 0.875rem;">Dodaj novog korisnika</strong>
                        <span style="font-size: 0.75rem; color: #74788d;">Kreiraj novi korisnički nalog</span>
                    </div>
                </a>
                <a href="<?php echo ADMIN_URL; ?>/news/create" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem; background: #f8f9fa; border-radius: 0.5rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                    <div style="width: 36px; height: 36px; background: #f3e8ff; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 5V15M5 10H15" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <strong style="display: block; margin-bottom: 0.125rem; font-size: 0.875rem;">Kreiraj novu novost</strong>
                        <span style="font-size: 0.75rem; color: #74788d;">Dodaj novu novost sa sadržajem</span>
                    </div>
                </a>
                <a href="<?php echo ADMIN_URL; ?>/galleries/create" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem; background: #f8f9fa; border-radius: 0.5rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                    <div style="width: 36px; height: 36px; background: #fff4e6; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 5V15M5 10H15" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <strong style="display: block; margin-bottom: 0.125rem; font-size: 0.875rem;">Kreiraj novu galeriju</strong>
                        <span style="font-size: 0.75rem; color: #74788d;">Dodaj novu galeriju sa slikama</span>
                    </div>
                </a>
                <a href="<?php echo ADMIN_URL; ?>/users" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem; background: #f8f9fa; border-radius: 0.5rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                    <div style="width: 36px; height: 36px; background: #e7f3ff; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M0 20C0 15.5817 4.47715 12 10 12C15.5228 12 20 15.5817 20 20" stroke="#50a5f1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <strong style="display: block; margin-bottom: 0.125rem; font-size: 0.875rem;">Upravljaj korisnicima</strong>
                        <span style="font-size: 0.75rem; color: #74788d;">Pregled i upravljanje korisnicima</span>
                    </div>
                </a>
                <a href="<?php echo ADMIN_URL; ?>/news" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem; background: #f8f9fa; border-radius: 0.5rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                    <div style="width: 36px; height: 36px; background: #f3e8ff; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 3H18C18.5523 3 19 3.44772 19 4V16C19 16.5523 18.5523 17 18 17H2C1.44772 17 1 16.5523 1 16V4C1 3.44772 1.44772 3 2 3Z" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1 6H19" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <strong style="display: block; margin-bottom: 0.125rem; font-size: 0.875rem;">Upravljaj novostima</strong>
                        <span style="font-size: 0.75rem; color: #74788d;">Pregled i upravljanje novostima</span>
                    </div>
                </a>
                <a href="<?php echo ADMIN_URL; ?>/galleries" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem; background: #f8f9fa; border-radius: 0.5rem; text-decoration: none; color: #495057; transition: all 0.2s;">
                    <div style="width: 36px; height: 36px; background: #fff4e6; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 4C2 2.89543 2.89543 2 4 2H6C7.10457 2 8 2.89543 8 4V6C8 7.10457 7.10457 8 6 8H4C2.89543 8 2 7.10457 2 6V4Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 4C12 2.89543 12.8954 2 14 2H16C17.1046 2 18 2.89543 18 4V6C18 7.10457 17.1046 8 16 8H14C12.8954 8 12 7.10457 12 6V4Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 14C2 12.8954 2.89543 12 4 12H6C7.10457 12 8 12.8954 8 14V16C8 17.1046 7.10457 18 6 18H4C2.89543 18 2 17.1046 2 16V14Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 14C12 12.8954 12.8954 12 14 12H16C17.1046 12 18 12.8954 18 14V16C18 17.1046 17.1046 18 16 18H14C12.8954 18 12 17.1046 12 16V14Z" stroke="#f1b44c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <strong style="display: block; margin-bottom: 0.125rem; font-size: 0.875rem;">Upravljaj galerijama</strong>
                        <span style="font-size: 0.75rem; color: #74788d;">Pregled i upravljanje galerijama</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
