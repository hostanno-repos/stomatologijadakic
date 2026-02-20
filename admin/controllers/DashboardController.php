<?php
/**
 * Dashboard Controller
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class DashboardController extends BaseController {
    private $userModel;
    private $galleryModel;
    private $imageModel;
    private $newsModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->galleryModel = new Gallery();
        $this->imageModel = new Image();
        $this->newsModel = new News();
    }
    
    public function index() {
        // Get current user info from session
        $userInfo = [
            'id' => $_SESSION['admin_user_id'] ?? null,
            'username' => $_SESSION['admin_username'] ?? 'Guest',
            'email' => $_SESSION['admin_email'] ?? '',
            'name' => $_SESSION['admin_name'] ?? 'Guest',
            'role' => $_SESSION['admin_role'] ?? 'guest'
        ];
        
        // Get statistics
        $stats = $this->getStatistics();
        
        // Get recent galleries
        $recentGalleries = $this->getRecentGalleries(5);
        
        // Get recent news
        $recentNews = $this->getRecentNews(5);
        
        // Get recent users (only for admins)
        $recentUsers = [];
        if ($userInfo['role'] === 'admin') {
            $recentUsers = $this->getRecentUsers(5);
        }
        
        $data = [
            'title' => 'Kontrolna tabla',
            'page_title' => 'Kontrolna tabla',
            'user' => $userInfo,
            'stats' => $stats,
            'recent_galleries' => $recentGalleries,
            'recent_news' => $recentNews,
            'recent_users' => $recentUsers
        ];
        
        $this->render('dashboard/index', $data);
    }
    
    /**
     * Get dashboard statistics
     */
    private function getStatistics() {
        $stats = [];
        $db = Database::getInstance()->getConnection();
        
        // Total users
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $stats['total_users'] = $stmt->fetchColumn();
        
        // Active users
        $stmt = $db->query("SELECT COUNT(*) FROM users WHERE status = 'active'");
        $stats['active_users'] = $stmt->fetchColumn();
        
        // Total galleries
        $stmt = $db->query("SELECT COUNT(*) FROM galleries");
        $stats['total_galleries'] = $stmt->fetchColumn();
        
        // Active galleries
        $stmt = $db->query("SELECT COUNT(*) FROM galleries WHERE status = 'active'");
        $stats['active_galleries'] = $stmt->fetchColumn();
        
        // Total images
        $stmt = $db->query("SELECT COUNT(*) FROM images");
        $stats['total_images'] = $stmt->fetchColumn();
        
        // Total news
        $stmt = $db->query("SELECT COUNT(*) FROM news");
        $stats['total_news'] = $stmt->fetchColumn();
        
        // Published news
        $stmt = $db->query("SELECT COUNT(*) FROM news WHERE status = 'published'");
        $stats['published_news'] = $stmt->fetchColumn();
        
        // Draft news
        $stmt = $db->query("SELECT COUNT(*) FROM news WHERE status = 'draft'");
        $stats['draft_news'] = $stmt->fetchColumn();
        
        // Get current user's last login
        if (isset($_SESSION['admin_user_id'])) {
            $user = $this->userModel->find($_SESSION['admin_user_id']);
            $stats['last_login'] = $user['last_login'] ?? null;
        }
        
        return $stats;
    }
    
    /**
     * Get recent galleries
     */
    private function getRecentGalleries($limit = 5) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT g.*, COUNT(i.id) as image_count 
            FROM galleries g 
            LEFT JOIN images i ON g.id = i.gallery_id 
            GROUP BY g.id 
            ORDER BY g.created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get recent news
     */
    private function getRecentNews($limit = 5) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT * FROM news 
            ORDER BY published_date DESC, created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get recent users
     */
    private function getRecentUsers($limit = 5) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT * FROM users 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
