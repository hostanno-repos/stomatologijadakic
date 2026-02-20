<?php
/**
 * Employees Controller
 *
 * @package    DakicCMS
 * @subpackage Admin
 */

class EmployeesController extends BaseController {
    private $employeeModel;
    private $uploadPath;

    public function __construct() {
        parent::__construct();
        $this->employeeModel = new Employee();
        $this->uploadPath = ADMIN_PATH . '/assets/uploads/employees/';
        if (!is_dir(ADMIN_PATH . '/assets/uploads/')) {
            @mkdir(ADMIN_PATH . '/assets/uploads/', 0755, true);
        }
        if (!is_dir($this->uploadPath)) {
            @mkdir($this->uploadPath, 0755, true);
        }
    }

    /**
     * List all employees
     */
    public function index() {
        $employees = $this->employeeModel->findAllOrdered();
        $data = [
            'title' => 'Zaposleni',
            'page_title' => 'Upravljanje zaposlenima',
            'employees' => $employees
        ];
        $this->render('employees/index', $data);
    }

    /**
     * Show create form
     */
    public function create() {
        $data = [
            'title' => 'Dodaj zaposlenog',
            'page_title' => 'Dodaj zaposlenog',
            'employee' => null,
            'csrf_token' => generateCsrfToken()
        ];
        $this->render('employees/form', $data);
    }

    /**
     * Store new employee
     */
    public function store() {
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
            $this->redirect(ADMIN_URL . '/employees/create');
        }

        $firstName = sanitize($_POST['first_name'] ?? '');
        $lastName = sanitize($_POST['last_name'] ?? '');
        $position = sanitize($_POST['position'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $gender = in_array($_POST['gender'] ?? '', ['male', 'female']) ? $_POST['gender'] : 'male';

        $errors = [];
        if (empty($firstName)) $errors[] = 'Ime je obavezno';
        if (empty($lastName)) $errors[] = 'Prezime je obavezno';
        if (empty($position)) $errors[] = 'Pozicija je obavezna';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/employees/create');
        }

        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($_FILES['image']);
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['error'];
                setFlash('error', implode('<br>', $errors));
                $this->redirect(ADMIN_URL . '/employees/create');
            }
        }

        try {
            $maxOrder = 0;
            $all = $this->employeeModel->findAll([], 'sort_order DESC', 1);
            if (!empty($all)) {
                $maxOrder = (int)($all[0]['sort_order'] ?? 0);
            }
            $this->employeeModel->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'position' => $position,
                'description' => $description,
                'image' => $imagePath,
                'gender' => $gender,
                'sort_order' => $maxOrder + 1
            ]);
            setFlash('success', 'Zaposleni je uspešno dodat.');
            $this->redirect(ADMIN_URL . '/employees');
        } catch (Exception $e) {
            setFlash('error', 'Došlo je do greške.');
            $this->redirect(ADMIN_URL . '/employees/create');
        }
    }

    /**
     * Show edit form
     */
    public function edit($id) {
        $id = (int) $id;
        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            setFlash('error', 'Zaposleni nije pronađen.');
            $this->redirect(ADMIN_URL . '/employees');
        }
        $data = [
            'title' => 'Uredi zaposlenog',
            'page_title' => 'Uredi zaposlenog',
            'employee' => $employee,
            'csrf_token' => generateCsrfToken()
        ];
        $this->render('employees/form', $data);
    }

    /**
     * Update employee
     */
    public function update($id) {
        $id = (int) $id;
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token.');
            $this->redirect(ADMIN_URL . '/employees/edit/' . $id);
        }

        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            setFlash('error', 'Zaposleni nije pronađen.');
            $this->redirect(ADMIN_URL . '/employees');
        }

        $firstName = sanitize($_POST['first_name'] ?? '');
        $lastName = sanitize($_POST['last_name'] ?? '');
        $position = sanitize($_POST['position'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $gender = in_array($_POST['gender'] ?? '', ['male', 'female']) ? $_POST['gender'] : 'male';
        $removeImage = isset($_POST['remove_image']) && $_POST['remove_image'] === '1';

        $errors = [];
        if (empty($firstName)) $errors[] = 'Ime je obavezno';
        if (empty($lastName)) $errors[] = 'Prezime je obavezno';
        if (empty($position)) $errors[] = 'Pozicija je obavezna';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/employees/edit/' . $id);
        }

        $imagePath = $employee['image'] ?? null;
        if ($removeImage && $imagePath) {
            $fullPath = ADMIN_PATH . '/' . ltrim($imagePath, '/');
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
            $imagePath = null;
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if ($imagePath) {
                $fullPath = ADMIN_PATH . '/' . ltrim($imagePath, '/');
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
            $uploadResult = $this->handleImageUpload($_FILES['image']);
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['error'];
                setFlash('error', implode('<br>', $errors));
                $this->redirect(ADMIN_URL . '/employees/edit/' . $id);
            }
        }

        try {
            $this->employeeModel->update($id, [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'position' => $position,
                'description' => $description,
                'image' => $imagePath,
                'gender' => $gender
            ]);
            setFlash('success', 'Zaposleni je uspešno ažuriran.');
            $this->redirect(ADMIN_URL . '/employees');
        } catch (Exception $e) {
            setFlash('error', 'Došlo je do greške.');
            $this->redirect(ADMIN_URL . '/employees/edit/' . $id);
        }
    }

    /**
     * Delete employee
     */
    public function delete($id) {
        $id = (int) $id;
        $token = $_GET['token'] ?? '';
        if (!verifyCsrfToken($token)) {
            setFlash('error', 'Nevažeći sigurnosni token.');
            $this->redirect(ADMIN_URL . '/employees');
        }
        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            setFlash('error', 'Zaposleni nije pronađen.');
            $this->redirect(ADMIN_URL . '/employees');
        }
        try {
            if (!empty($employee['image'])) {
                $fullPath = ADMIN_PATH . '/' . ltrim($employee['image'], '/');
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
            $this->employeeModel->delete($id);
            setFlash('success', 'Zaposleni je obrisan.');
        } catch (Exception $e) {
            setFlash('error', 'Došlo je do greške pri brisanju.');
        }
        $this->redirect(ADMIN_URL . '/employees');
    }

    private function handleImageUpload($file) {
        $mimeType = @mime_content_type($file['tmp_name']);
        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return ['success' => false, 'error' => 'Dozvoljeni formati: JPEG, PNG, GIF, WebP.'];
        }
        if ($file['size'] > (defined('UPLOAD_MAX_SIZE') ? UPLOAD_MAX_SIZE : 5242880)) {
            return ['success' => false, 'error' => 'Maksimalna veličina je 5MB.'];
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) ?: 'jpg';
        $filename = 'emp_' . uniqid('', true) . '.' . $ext;
        $relativePath = 'assets/uploads/employees/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $this->uploadPath . $filename)) {
            return ['success' => true, 'path' => $relativePath];
        }
        return ['success' => false, 'error' => 'Greška pri čuvanju fajla.'];
    }
}
