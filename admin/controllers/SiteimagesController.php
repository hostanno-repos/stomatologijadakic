<?php
/**
 * Site Images Controller – zamjena slika na sajtu.
 *
 * @package    DakicCMS
 * @subpackage Admin
 */

class SiteimagesController extends BaseController {
    private $model;
    private $uploadPath;
    private $slots;

    public function __construct() {
        parent::__construct();
        $this->model = new SiteImage();
        $this->uploadPath = ADMIN_PATH . '/assets/uploads/site/';
        $this->slots = require ADMIN_PATH . '/config/site_images_slots.php';

        if (!is_dir(ADMIN_PATH . '/assets/uploads/')) {
            @mkdir(ADMIN_PATH . '/assets/uploads/', 0755, true);
        }
        if (!is_dir($this->uploadPath)) {
            @mkdir($this->uploadPath, 0755, true);
        }
    }

    /**
     * List all image slots with current image and link to replace.
     */
    public function index() {
        $paths = $this->model->getAllPaths();
        $list = [];
        foreach ($this->slots as $key => $slot) {
            $list[] = [
                'key'     => $key,
                'label'   => $slot['label'],
                'default' => $slot['default'],
                'path'    => $paths[$key] ?? null,
            ];
        }
        $data = [
            'title'    => 'Slike na sajtu',
            'page_title'=> 'Zamjena slika na sajtu',
            'slots'    => $list,
            'csrf_token' => generateCsrfToken(),
        ];
        $this->render('site_images/index', $data);
    }

    /**
     * Show replace form for one slot.
     */
    public function edit($key) {
        $key = (string) $key;
        if (!isset($this->slots[$key])) {
            setFlash('error', 'Nevažeći slot za sliku.');
            $this->redirect(ADMIN_URL . '/siteimages');
        }
        $path = $this->model->getPath($key);
        $slot = $this->slots[$key];
        $data = [
            'title'      => 'Zamijeni sliku: ' . $slot['label'],
            'page_title' => 'Zamijeni sliku',
            'slot_key'   => $key,
            'slot_label' => $slot['label'],
            'default_path' => $slot['default'],
            'current_path' => $path,
            'csrf_token'  => generateCsrfToken(),
        ];
        $this->render('site_images/edit', $data);
    }

    /**
     * Upload new image and set as path for slot.
     */
    public function update($key) {
        $key = (string) $key;
        if (!isset($this->slots[$key])) {
            setFlash('error', 'Nevažeći slot.');
            $this->redirect(ADMIN_URL . '/siteimages');
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token.');
            $this->redirect(ADMIN_URL . '/siteimages/edit/' . $key);
        }

        $remove = isset($_POST['remove_image']) && $_POST['remove_image'] === '1';
        if ($remove) {
            $current = $this->model->getPath($key);
            if ($current) {
                $full = ADMIN_PATH . '/' . ltrim($current, '/');
                if (file_exists($full)) {
                    @unlink($full);
                }
            }
            $this->model->setPath($key, null);
            setFlash('success', 'Slika je uklonjena; prikazuje se zadana.');
            $this->redirect(ADMIN_URL . '/siteimages');
            return;
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            setFlash('error', 'Odaberite sliku za upload.');
            $this->redirect(ADMIN_URL . '/siteimages/edit/' . $key);
            return;
        }

        $result = $this->handleUpload($_FILES['image'], $key);
        if (!$result['success']) {
            setFlash('error', $result['error']);
            $this->redirect(ADMIN_URL . '/siteimages/edit/' . $key);
            return;
        }

        // Remove old file if exists
        $oldPath = $this->model->getPath($key);
        if ($oldPath) {
            $oldFull = ADMIN_PATH . '/' . ltrim($oldPath, '/');
            if (file_exists($oldFull)) {
                @unlink($oldFull);
            }
        }

        $this->model->setPath($key, $result['path']);
        setFlash('success', 'Slika je uspješno zamijenjena.');
        $this->redirect(ADMIN_URL . '/siteimages');
    }

    private function handleUpload($file, $key) {
        $mime = @mime_content_type($file['tmp_name']);
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])) {
            return ['success' => false, 'error' => 'Dozvoljeni formati: JPEG, PNG, GIF, WebP, SVG.'];
        }
        $max = defined('UPLOAD_MAX_SIZE') ? UPLOAD_MAX_SIZE : 5242880;
        if ($file['size'] > $max) {
            return ['success' => false, 'error' => 'Maksimalna veličina 5MB.'];
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) ?: 'jpg';
        $filename = preg_replace('/[^a-z0-9_-]/', '_', $key) . '_' . uniqid('', true) . '.' . $ext;
        $relativePath = 'assets/uploads/site/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $this->uploadPath . $filename)) {
            return ['success' => true, 'path' => $relativePath];
        }
        return ['success' => false, 'error' => 'Greška pri čuvanju fajla.'];
    }
}
