/**
 * Main Admin JavaScript
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

(function() {
    'use strict';
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initSidebar();
        initActiveNavLinks();
    });
    
    /**
     * Initialize sidebar toggle functionality
     */
    function initSidebar() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (!sidebar) return;
        
        // Load saved state from localStorage
        const savedState = localStorage.getItem('sidebarClosed');
        const isClosed = savedState === 'true';
        
        // Set initial state
        if (isClosed && window.innerWidth > 768) {
            sidebar.classList.add('closed');
        }
        
        // Desktop toggle
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                toggleSidebar();
            });
        }
        
        // Mobile toggle
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                toggleSidebar();
            });
        }
        
        // Close sidebar when clicking overlay (mobile)
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        }
        
        // Close sidebar on mobile when clicking a link
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
        
        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('open');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                } else {
                    // On mobile, sidebar should be closed by default
                    if (!sidebar.classList.contains('open')) {
                        closeSidebar();
                    }
                }
            }, 250);
        });
    }
    
    /**
     * Toggle sidebar open/closed
     */
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (!sidebar) return;
        
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            // Mobile: toggle open class and overlay
            sidebar.classList.toggle('open');
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle('active');
            }
        } else {
            // Desktop: toggle closed class
            sidebar.classList.toggle('closed');
            
            // Save state to localStorage
            const isClosed = sidebar.classList.contains('closed');
            localStorage.setItem('sidebarClosed', isClosed.toString());
        }
    }
    
    /**
     * Close sidebar (mobile)
     */
    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (sidebar) {
            sidebar.classList.remove('open');
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.classList.remove('active');
        }
    }
    
    /**
     * Initialize active navigation links based on current URL
     */
    function initActiveNavLinks() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(function(link) {
            const href = link.getAttribute('href');
            if (href && currentPath.includes(href.replace(/\/$/, ''))) {
                link.classList.add('active');
            }
        });
    }
    
    // CSRF token handling for AJAX requests
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }
    
    // Export for use in other scripts
    window.AdminApp = {
        getCsrfToken: getCsrfToken,
        toggleSidebar: toggleSidebar,
        closeSidebar: closeSidebar
    };
})();
