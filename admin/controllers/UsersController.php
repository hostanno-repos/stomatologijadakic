<?php
/**
 * Users Controller
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class UsersController extends BaseController {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }
    
    /**
     * List all users
     */
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        // Get search query
        $search = sanitize($_GET['search'] ?? '');
        
        // Build query
        $where = [];
        $params = [];
        
        if (!empty($search)) {
            $where[] = "(username LIKE ? OR email LIKE ? OR first_name LIKE ? OR last_name LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }
        
        // Get total count
        $countSql = "SELECT COUNT(*) FROM users";
        if (!empty($where)) {
            $countSql .= " WHERE " . implode(' AND ', $where);
        }
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $totalUsers = $countStmt->fetchColumn();
        $totalPages = ceil($totalUsers / $perPage);
        
        // Get users
        $sql = "SELECT * FROM users";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        $sql .= " ORDER BY created_at DESC LIMIT " . (int)$perPage . " OFFSET " . (int)$offset;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $users = $stmt->fetchAll();
        
        $data = [
            'title' => 'Korisnici',
            'page_title' => 'Upravljanje korisnicima',
            'users' => $users,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_users' => $totalUsers,
            'search' => $search
        ];
        
        $this->render('users/index', $data);
    }
    
    /**
     * Show create user form
     */
    public function create() {
        $data = [
            'title' => 'Create User',
            'page_title' => 'Create New User',
            'user' => null,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('users/form', $data);
    }
    
    /**
     * Store new user
     */
    public function store() {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
            $this->redirect(ADMIN_URL . '/users/create');
        }
        
        // Get and sanitize input
        $username = sanitize($_POST['username'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $first_name = sanitize($_POST['first_name'] ?? '');
        $last_name = sanitize($_POST['last_name'] ?? '');
        $role = sanitize($_POST['role'] ?? 'author');
        $status = sanitize($_POST['status'] ?? 'active');
        
        // Validation
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'Korisničko ime je obavezno';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Korisničko ime mora imati najmanje 3 karaktera';
        } elseif ($this->userModel->findByUsername($username)) {
            $errors[] = 'Korisničko ime već postoji';
        }
        
        if (empty($email)) {
            $errors[] = 'Email je obavezan';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Nevažeći format email adrese';
        } elseif ($this->userModel->findByEmail($email)) {
            $errors[] = 'Email adresa već postoji';
        }
        
        if (empty($password)) {
            $errors[] = 'Lozinka je obavezna';
        } elseif (strlen($password) < PASSWORD_MIN_LENGTH) {
            $errors[] = 'Lozinka mora imati najmanje ' . PASSWORD_MIN_LENGTH . ' karaktera';
        }
        
        if (!in_array($role, ['admin', 'editor', 'author'])) {
            $errors[] = 'Nevažeća uloga';
        }
        
        if (!in_array($status, ['active', 'inactive', 'suspended'])) {
            $errors[] = 'Nevažeći status';
        }
        
        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/users/create');
        }
        
        // Create user
        try {
            $userData = [
                'username' => $username,
                'email' => $email,
                'password' => hashPassword($password),
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => $role,
                'status' => $status
            ];
            
            $userId = $this->userModel->create($userData);
            
            logMessage("User created: {$username} (ID: {$userId})", 'INFO');
            setFlash('success', 'Korisnik je uspešno kreiran');
            $this->redirect(ADMIN_URL . '/users');
            
        } catch (Exception $e) {
            logMessage("Error creating user: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri kreiranju korisnika');
            $this->redirect(ADMIN_URL . '/users/create');
        }
    }
    
    /**
     * Show edit user form
     */
    public function edit($id) {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            setFlash('error', 'User not found');
            $this->redirect(ADMIN_URL . '/users');
        }
        
        // Don't show password in form
        unset($user['password']);
        
        $data = [
            'title' => 'Izmeni korisnika',
            'page_title' => 'Izmeni korisnika',
            'user' => $user,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('users/form', $data);
    }
    
    /**
     * Update user
     */
    public function update($id) {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
            $this->redirect(ADMIN_URL . '/users/edit/' . $id);
        }
        
        $user = $this->userModel->find($id);
        if (!$user) {
            setFlash('error', 'Korisnik nije pronađen');
            $this->redirect(ADMIN_URL . '/users');
        }
        
        // Get and sanitize input
        $username = sanitize($_POST['username'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $first_name = sanitize($_POST['first_name'] ?? '');
        $last_name = sanitize($_POST['last_name'] ?? '');
        $role = sanitize($_POST['role'] ?? 'author');
        $status = sanitize($_POST['status'] ?? 'active');
        
        // Validation
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'Korisničko ime je obavezno';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Korisničko ime mora imati najmanje 3 karaktera';
        } else {
            $existingUser = $this->userModel->findByUsername($username);
            if ($existingUser && $existingUser['id'] != $id) {
                $errors[] = 'Korisničko ime već postoji';
            }
        }
        
        if (empty($email)) {
            $errors[] = 'Email je obavezan';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Nevažeći format email adrese';
        } else {
            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser && $existingUser['id'] != $id) {
                $errors[] = 'Email adresa već postoji';
            }
        }
        
        if (!empty($password) && strlen($password) < PASSWORD_MIN_LENGTH) {
            $errors[] = 'Lozinka mora imati najmanje ' . PASSWORD_MIN_LENGTH . ' karaktera';
        }
        
        if (!in_array($role, ['admin', 'editor', 'author'])) {
            $errors[] = 'Nevažeća uloga';
        }
        
        if (!in_array($status, ['active', 'inactive', 'suspended'])) {
            $errors[] = 'Nevažeći status';
        }
        
        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/users/edit/' . $id);
        }
        
        // Update user
        try {
            $userData = [
                'username' => $username,
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => $role,
                'status' => $status
            ];
            
            // Only update password if provided
            if (!empty($password)) {
                $userData['password'] = hashPassword($password);
            }
            
            $this->userModel->update($id, $userData);
            
            logMessage("User updated: {$username} (ID: {$id})", 'INFO');
            setFlash('success', 'Korisnik je uspešno ažuriran');
            $this->redirect(ADMIN_URL . '/users');
            
        } catch (Exception $e) {
            logMessage("Error updating user: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri ažuriranju korisnika');
            $this->redirect(ADMIN_URL . '/users/edit/' . $id);
        }
    }
    
    /**
     * Delete user
     */
    public function delete($id) {
        // Verify CSRF token
        $csrfToken = $_GET['token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token');
            $this->redirect(ADMIN_URL . '/users');
        }
        
        $user = $this->userModel->find($id);
        if (!$user) {
            setFlash('error', 'Korisnik nije pronađen');
            $this->redirect(ADMIN_URL . '/users');
        }
        
        // Prevent deleting yourself
        if ($id == $_SESSION['admin_user_id']) {
            setFlash('error', 'Ne možete obrisati sopstveni nalog');
            $this->redirect(ADMIN_URL . '/users');
        }
        
        try {
            $this->userModel->delete($id);
            logMessage("User deleted: {$user['username']} (ID: {$id})", 'INFO');
            setFlash('success', 'Korisnik je uspešno obrisan');
        } catch (Exception $e) {
            logMessage("Error deleting user: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri brisanju korisnika');
        }
        
        $this->redirect(ADMIN_URL . '/users');
    }
}
