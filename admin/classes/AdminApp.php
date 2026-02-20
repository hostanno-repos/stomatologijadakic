<?php
/**
 * Main Application Class
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class AdminApp {
    private $controller;
    private $action;
    private $params;
    
    public function __construct() {
        $this->parseRequest();
    }
    
    private function parseRequest() {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Check for route parameter first (works without .htaccess)
        if (isset($_GET['route'])) {
            $path = trim($_GET['route'], '/');
        } else {
            $path = parse_url($uri, PHP_URL_PATH);
            
            // Dynamically detect base path
            $scriptName = $_SERVER['SCRIPT_NAME'];
            // Extract base path (everything up to /admin/index.php or /admin/)
            $basePath = dirname($scriptName);
            
            // Remove base path from request path
            if (strpos($path, $basePath) === 0) {
                $path = substr($path, strlen($basePath));
            }
            
            // Also try removing common patterns
            $path = preg_replace('#^/dakic_cms/admin#', '', $path);
            $path = preg_replace('#^/admin#', '', $path);
            
            // Remove index.php if present in path
            $path = preg_replace('#/index\.php#', '', $path);
            $path = preg_replace('#^index\.php#', '', $path);
            
            $path = trim($path, '/');
        }
        
        // Remove trailing slash if present
        $path = rtrim($path, '/');
        
        // Split into segments
        $segments = explode('/', $path);
        
        // Filter out empty segments
        $segments = array_filter($segments, function($seg) {
            return !empty($seg);
        });
        $segments = array_values($segments);
        
        // Set controller (default: Dashboard)
        $this->controller = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DashboardController';
        
        // Set action (default: index)
        // Convert hyphenated actions to camelCase (e.g., upload-images -> uploadImages)
        $action = !empty($segments[1]) ? $segments[1] : 'index';
        $this->action = $this->hyphenToCamelCase($action);
        
        // Set parameters
        $this->params = array_slice($segments, 2);
        
        // #region agent log
        $logEntry2 = [
            'sessionId' => 'debug-session',
            'runId' => 'run2',
            'hypothesisId' => 'FIXED',
            'location' => 'AdminApp.php:parseRequest',
            'message' => 'Request parsed - POST FIX',
            'data' => [
                'after_replace' => $path,
                'segments' => $segments,
                'controller' => $this->controller,
                'action' => $this->action,
                'params' => $this->params
            ],
            'timestamp' => time() * 1000
        ];
        file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logEntry2) . "\n", FILE_APPEND);
        // #endregion
    }
    
    public function run() {
        // #region agent log
        $logEntry = [
            'sessionId' => 'debug-session',
            'runId' => 'run2',
            'hypothesisId' => 'FIXED',
            'location' => 'AdminApp.php:run',
            'message' => 'Run method started - POST FIX',
            'data' => [
                'controller' => $this->controller,
                'action' => $this->action,
                'is_auth_route' => $this->isAuthRoute(),
                'is_authenticated' => $this->isAuthenticated()
            ],
            'timestamp' => time() * 1000
        ];
        file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logEntry) . "\n", FILE_APPEND);
        // #endregion
        
        // Check authentication (except for auth routes)
        if (!$this->isAuthRoute() && !$this->isAuthenticated()) {
            header('Location: ' . ADMIN_URL . '/auth/login');
            exit;
        }
        
        // Load controller
        $controllerFile = ADMIN_PATH . '/controllers/' . $this->controller . '.php';
        
        if (!file_exists($controllerFile)) {
            $this->controller = 'DashboardController';
            $controllerFile = ADMIN_PATH . '/controllers/' . $this->controller . '.php';
        }
        
        require_once $controllerFile;
        
        if (!class_exists($this->controller)) {
            die("Controller {$this->controller} not found");
        }
        
        $controller = new $this->controller();
        
        if (!method_exists($controller, $this->action)) {
            die("Action {$this->action} not found in {$this->controller}");
        }
        
        // Call controller action
        call_user_func_array([$controller, $this->action], $this->params);
    }
    
    private function isAuthRoute() {
        // Check if controller is AuthController
        $isAuthController = strpos($this->controller, 'Auth') !== false;
        $isAuthAction = isset($this->action) && ($this->action === 'login' || $this->action === 'logout');
        
        // Also check if the path contains 'auth' (case-insensitive)
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $pathContainsAuth = stripos($uri, '/auth/') !== false || stripos($uri, '/auth') !== false;
        
        return $isAuthController || $isAuthAction || $pathContainsAuth;
    }
    
    private function isAuthenticated() {
        return isset($_SESSION['admin_user_id']) && !empty($_SESSION['admin_user_id']);
    }
    
    /**
     * Convert hyphenated string to camelCase
     * Example: upload-images -> uploadImages
     */
    private function hyphenToCamelCase($string) {
        if (strpos($string, '-') === false) {
            return $string;
        }
        
        $parts = explode('-', $string);
        $camelCase = $parts[0];
        
        for ($i = 1; $i < count($parts); $i++) {
            $camelCase .= ucfirst($parts[$i]);
        }
        
        return $camelCase;
    }
}
