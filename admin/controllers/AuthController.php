<?php
/**
 * Authentication Controller
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class AuthController extends BaseController {
    
    public function login() {
        // #region agent log
        $logEntry = [
            'sessionId' => 'debug-session',
            'runId' => 'run1',
            'hypothesisId' => 'A,B,C,D',
            'location' => 'AuthController.php:login',
            'message' => 'Login method called',
            'data' => [
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'N/A',
                'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
                'has_post_data' => !empty($_POST),
                'post_keys' => array_keys($_POST ?? [])
            ],
            'timestamp' => time() * 1000
        ];
        file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logEntry) . "\n", FILE_APPEND);
        // #endregion
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // #region agent log
            $logEntry2 = [
                'sessionId' => 'debug-session',
                'runId' => 'run1',
                'hypothesisId' => 'A,B',
                'location' => 'AuthController.php:login',
                'message' => 'POST request detected',
                'data' => [
                    'post_data_received' => !empty($_POST),
                    'csrf_token_present' => isset($_POST['csrf_token']),
                    'username_present' => isset($_POST['username']),
                    'password_present' => isset($_POST['password'])
                ],
                'timestamp' => time() * 1000
            ];
            file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logEntry2) . "\n", FILE_APPEND);
            // #endregion
            
            // Verify CSRF token
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!verifyCsrfToken($csrfToken)) {
                setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
                $this->redirect(ADMIN_URL . '/auth/login');
            }
            
            $username = sanitize($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validate input
            if (empty($username) || empty($password)) {
                setFlash('error', 'Username and password are required');
                $this->redirect(ADMIN_URL . '/auth/login');
            }
            
            // Check credentials
            try {
                $userModel = new User();
                $user = $userModel->findByUsername($username);
                
                if ($user && verifyPassword($password, $user['password'])) {
                    // Check if user is active
                    if ($user['status'] !== 'active') {
                        setFlash('error', 'Vaš nalog nije aktivan. Molimo kontaktirajte administratora.');
                        $this->redirect(ADMIN_URL . '/auth/login');
                    }
                    
                    // Set session variables
                    $_SESSION['admin_user_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_email'] = $user['email'];
                    $_SESSION['admin_role'] = $user['role'];
                    $_SESSION['admin_name'] = trim($user['first_name'] . ' ' . $user['last_name']);
                    
                    // Update last login
                    $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
                    
                    // Log successful login
                    logMessage("User '{$username}' logged in successfully", 'INFO');
                    
                    // Redirect to dashboard
                    $this->redirect(ADMIN_URL . '/dashboard');
                } else {
                    logMessage("Failed login attempt for username: '{$username}'", 'WARNING');
                    setFlash('error', 'Invalid username or password');
                    $this->redirect(ADMIN_URL . '/auth/login');
                }
            } catch (Exception $e) {
                logMessage("Login error: " . $e->getMessage(), 'ERROR');
                setFlash('error', 'Došlo je do greške. Molimo pokušajte ponovo.');
                $this->redirect(ADMIN_URL . '/auth/login');
            }
        }
        
        // Show login form
        $data = [
            'title' => 'Prijava',
            'csrf_token' => generateCsrfToken()
        ];
        
        $viewFile = ADMIN_PATH . '/views/auth/login.php';
        if (file_exists($viewFile)) {
            extract($data);
            include $viewFile;
        } else {
            // Simple login form
            echo '<!DOCTYPE html><html><head><title>Login</title></head><body>';
            echo '<h1>Login</h1>';
            echo '<form method="POST">';
            echo '<input type="hidden" name="csrf_token" value="' . escape($data['csrf_token']) . '">';
            echo '<input type="text" name="username" placeholder="Username" required><br><br>';
            echo '<input type="password" name="password" placeholder="Password" required><br><br>';
            echo '<button type="submit">Login</button>';
            echo '</form>';
            echo '</body></html>';
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect(ADMIN_URL . '/auth/login');
    }
}
