<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? escape($title) . ' - ' : ''; ?><?php echo APP_NAME; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/assets/css/main.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php if (isAuthenticated()): ?>
        <!-- Mobile overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar Navigation -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-brand"><?php echo APP_NAME; ?></h1>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li>
                        <a href="<?php echo ADMIN_URL; ?>/dashboard" class="nav-link">
                            <span class="nav-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 3H8V10H3V3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 3H17V6H12V3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 8H17V17H12V8Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 12H8V17H3V12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="nav-text">Kontrolna tabla</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo ADMIN_URL; ?>/users" class="nav-link">
                            <span class="nav-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M0 20C0 15.5817 4.47715 12 10 12C15.5228 12 20 15.5817 20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="nav-text">Korisnici</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo ADMIN_URL; ?>/galleries" class="nav-link">
                            <span class="nav-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 4C2 2.89543 2.89543 2 4 2H6C7.10457 2 8 2.89543 8 4V6C8 7.10457 7.10457 8 6 8H4C2.89543 8 2 7.10457 2 6V4Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 4C12 2.89543 12.8954 2 14 2H16C17.1046 2 18 2.89543 18 4V6C18 7.10457 17.1046 8 16 8H14C12.8954 8 12 7.10457 12 6V4Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 14C2 12.8954 2.89543 12 4 12H6C7.10457 12 8 12.8954 8 14V16C8 17.1046 7.10457 18 6 18H4C2.89543 18 2 17.1046 2 16V14Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 14C12 12.8954 12.8954 12 14 12H16C17.1046 12 18 12.8954 18 14V16C18 17.1046 17.1046 18 16 18H14C12.8954 18 12 17.1046 12 16V14Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="nav-text">Galerije</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo ADMIN_URL; ?>/news" class="nav-link">
                            <span class="nav-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 3H18C18.5523 3 19 3.44772 19 4V16C19 16.5523 18.5523 17 18 17H2C1.44772 17 1 16.5523 1 16V4C1 3.44772 1.44772 3 2 3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M1 6H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 3V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="nav-text">Novosti</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo ADMIN_URL; ?>/contents" class="nav-link">
                            <span class="nav-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 4C2 2.89543 2.89543 2 4 2H16C17.1046 2 18 2.89543 18 4V16C18 17.1046 17.1046 18 16 18H4C2.89543 18 2 17.1046 2 16V4Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 6H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 10H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 14H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="nav-text">Sadržaji</span>
                        </a>
                    </li>
                    <li class="nav-divider"></li>
                    <li>
                        <a href="<?php echo ADMIN_URL; ?>/auth/logout" class="nav-link nav-link-logout">
                            <span class="nav-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 18H3C2.44772 18 2 17.5523 2 17V3C2 2.44772 2.44772 2 3 2H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14 15L18 10L14 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18 10H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content Area -->
        <div class="main-container">
            <!-- Top Bar -->
            <header class="top-bar">
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="top-bar-title">
                    <?php echo isset($page_title) ? escape($page_title) : 'Kontrolna tabla'; ?>
                </div>
                <div class="top-bar-user">
                    <?php if (isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])): ?>
                        <span class="user-name"><?php echo escape($_SESSION['admin_name']); ?></span>
                    <?php endif; ?>
                </div>
            </header>
            
            <!-- Content -->
            <main class="admin-content">
                <?php if (isset($viewFile) && file_exists($viewFile)): ?>
                    <?php include $viewFile; ?>
                <?php elseif (isset($view)): ?>
                    <?php include ADMIN_PATH . '/views/' . $view . '.php'; ?>
                <?php endif; ?>
            </main>
        </div>
        <?php else: ?>
        <!-- No sidebar for non-authenticated pages -->
        <main class="admin-content">
            <?php if (isset($viewFile) && file_exists($viewFile)): ?>
                <?php include $viewFile; ?>
            <?php elseif (isset($view)): ?>
                <?php include ADMIN_PATH . '/views/' . $view . '.php'; ?>
            <?php endif; ?>
        </main>
        <?php endif; ?>
    </div>
    
    <script src="<?php echo ADMIN_URL; ?>/assets/js/main.js"></script>
</body>
</html>
