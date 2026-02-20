<?php
/**
 * Base Controller Class
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Render a view
     */
    protected function render($view, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Set view path for layout
        $viewFile = ADMIN_PATH . '/views/' . $view . '.php';
        
        if (!file_exists($viewFile)) {
            die("View {$view} not found");
        }
        
        // Store view file path in data for layout
        $data['view'] = $view;
        $data['viewFile'] = $viewFile;
        
        // Load layout
        $layout = ADMIN_PATH . '/views/layouts/main.php';
        if (file_exists($layout)) {
            include $layout;
        } else {
            include $viewFile;
        }
    }
    
    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}
