<?php
/**
 * Galleries Controller
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class GalleriesController extends BaseController {
    private $galleryModel;
    private $imageModel;
    private $uploadPath;
    
    public function __construct() {
        parent::__construct();
        $this->galleryModel = new Gallery();
        $this->imageModel = new Image();
        $this->uploadPath = ADMIN_PATH . '/assets/uploads/galleries/';
        
        // Ensure uploads directory exists
        if (!file_exists(ADMIN_PATH . '/assets/uploads/')) {
            mkdir(ADMIN_PATH . '/assets/uploads/', 0755, true);
        }
        
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }
    
    /**
     * List all galleries
     */
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        // Get search query
        $search = sanitize($_GET['search'] ?? '');
        
        // Build conditions
        $conditions = [];
        $params = [];
        
        if (!empty($search)) {
            // We'll need to modify the query for search
            $galleries = $this->galleryModel->findAllWithImageCount([], 'sort_order ASC, created_at DESC');
            $galleries = array_filter($galleries, function($gallery) use ($search) {
                return stripos($gallery['title'], $search) !== false || 
                       stripos($gallery['description'] ?? '', $search) !== false;
            });
            $totalGalleries = count($galleries);
            $galleries = array_slice($galleries, $offset, $perPage);
        } else {
            $galleries = $this->galleryModel->findAllWithImageCount($conditions, 'sort_order ASC, created_at DESC');
            $totalGalleries = count($galleries);
            $galleries = array_slice($galleries, $offset, $perPage);
        }
        
        $totalPages = ceil($totalGalleries / $perPage);
        
        $data = [
            'title' => 'Galerije',
            'page_title' => 'Upravljanje galerijama',
            'galleries' => $galleries,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_galleries' => $totalGalleries,
            'search' => $search
        ];
        
        $this->render('galleries/index', $data);
    }
    
    /**
     * Show create gallery form
     */
    public function create() {
        $data = [
            'title' => 'Kreiraj galeriju',
            'page_title' => 'Kreiraj novu galeriju',
            'gallery' => null,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('galleries/form', $data);
    }
    
    /**
     * Store new gallery
     */
    public function store() {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect(ADMIN_URL . '/galleries/create');
        }
        
        // Get and sanitize input
        $title = sanitize($_POST['title'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $status = sanitize($_POST['status'] ?? 'active');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        
        // Validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Title is required';
        }
        
        if (!in_array($status, ['active', 'inactive'])) {
            $errors[] = 'Invalid status';
        }
        
        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/galleries/create');
        }
        
        // Create gallery
        try {
            $slug = $this->galleryModel->generateSlug($title);
            
            $galleryData = [
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'status' => $status,
                'sort_order' => $sortOrder,
                'created_by' => $_SESSION['admin_user_id'] ?? null
            ];
            
            $galleryId = $this->galleryModel->create($galleryData);
            
            logMessage("Gallery created: {$title} (ID: {$galleryId})", 'INFO');
            setFlash('success', 'Galerija je uspešno kreirana');
            $this->redirect(ADMIN_URL . '/galleries/view/' . $galleryId);
            
        } catch (Exception $e) {
            logMessage("Error creating gallery: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri kreiranju galerije');
            $this->redirect(ADMIN_URL . '/galleries/create');
        }
    }
    
    /**
     * View gallery with images
     */
    public function view($id) {
        $gallery = $this->galleryModel->find($id);
        
        if (!$gallery) {
            setFlash('error', 'Gallery not found');
            $this->redirect(ADMIN_URL . '/galleries');
        }
        
        $images = $this->imageModel->findByGalleryId($id);
        
        $data = [
            'title' => 'Galerija: ' . $gallery['title'],
            'page_title' => $gallery['title'],
            'gallery' => $gallery,
            'images' => $images,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('galleries/view', $data);
    }
    
    /**
     * Show edit gallery form
     */
    public function edit($id) {
        $gallery = $this->galleryModel->find($id);
        
        if (!$gallery) {
            setFlash('error', 'Gallery not found');
            $this->redirect(ADMIN_URL . '/galleries');
        }
        
        $data = [
            'title' => 'Izmeni galeriju',
            'page_title' => 'Izmeni galeriju',
            'gallery' => $gallery,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('galleries/form', $data);
    }
    
    /**
     * Update gallery
     */
    public function update($id) {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
            $this->redirect(ADMIN_URL . '/galleries/edit/' . $id);
        }
        
        $gallery = $this->galleryModel->find($id);
        if (!$gallery) {
            setFlash('error', 'Galerija nije pronađena');
            $this->redirect(ADMIN_URL . '/galleries');
        }
        
        // Get and sanitize input
        $title = sanitize($_POST['title'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $status = sanitize($_POST['status'] ?? 'active');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        
        // Validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Naziv je obavezan';
        }
        
        if (!in_array($status, ['active', 'inactive'])) {
            $errors[] = 'Nevažeći status';
        }
        
        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/galleries/edit/' . $id);
        }
        
        // Update gallery
        try {
            $slug = $this->galleryModel->generateSlug($title, $id);
            
            $galleryData = [
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'status' => $status,
                'sort_order' => $sortOrder
            ];
            
            $this->galleryModel->update($id, $galleryData);
            
            logMessage("Gallery updated: {$title} (ID: {$id})", 'INFO');
            setFlash('success', 'Galerija je uspešno ažurirana');
            $this->redirect(ADMIN_URL . '/galleries/view/' . $id);
            
        } catch (Exception $e) {
            logMessage("Error updating gallery: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri ažuriranju galerije');
            $this->redirect(ADMIN_URL . '/galleries/edit/' . $id);
        }
    }
    
    /**
     * Delete gallery
     */
    public function delete($id) {
        // Verify CSRF token
        $csrfToken = $_GET['token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Invalid security token');
            $this->redirect(ADMIN_URL . '/galleries');
        }
        
        $gallery = $this->galleryModel->find($id);
        if (!$gallery) {
            setFlash('error', 'Gallery not found');
            $this->redirect(ADMIN_URL . '/galleries');
        }
        
        try {
            // Delete all images first (CASCADE will handle this, but we delete files)
            $images = $this->imageModel->findByGalleryId($id);
            foreach ($images as $image) {
                $filePath = ADMIN_PATH . '/' . ltrim($image['file_path'], '/');
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $this->galleryModel->delete($id);
            logMessage("Gallery deleted: {$gallery['title']} (ID: {$id})", 'INFO');
            setFlash('success', 'Gallery deleted successfully');
        } catch (Exception $e) {
            logMessage("Error deleting gallery: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'An error occurred while deleting the gallery');
        }
        
        $this->redirect(ADMIN_URL . '/galleries');
    }
    
    /**
     * Upload images to gallery
     */
    public function uploadImages($galleryId) {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            $this->json(['success' => false, 'message' => 'Nevažeći sigurnosni token'], 403);
        }
        
        $gallery = $this->galleryModel->find($galleryId);
        if (!$gallery) {
            $this->json(['success' => false, 'message' => 'Galerija nije pronađena'], 404);
        }
        
        if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
            $this->json(['success' => false, 'message' => 'Nijedna datoteka nije otpremljena'], 400);
        }
        
        $uploadedFiles = [];
        $errors = [];
        
        $galleryUploadPath = $this->uploadPath . $galleryId . '/';
        if (!file_exists($galleryUploadPath)) {
            mkdir($galleryUploadPath, 0755, true);
        }
        
        $files = $_FILES['images'];
        $fileCount = count($files['name']);
        
        // Get current max sort order
        $maxSortOrder = $this->imageModel->countByGalleryId($galleryId);
        
        for ($i = 0; $i < $fileCount; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $errors[] = "File {$files['name'][$i]}: Upload error";
                continue;
            }
            
            // Validate file type (images and videos)
            $mimeType = mime_content_type($files['tmp_name'][$i]);
            $allowedTypes = [
                'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'
            ];
            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "File {$files['name'][$i]}: Invalid file type. Allowed: images (JPEG, PNG, GIF, WebP) and videos (MP4, WebM, OGG, MOV)";
                continue;
            }
            
            // Validate file size (50MB for videos, 5MB for images)
            $isVideo = strpos($mimeType, 'video/') === 0;
            $maxSize = $isVideo ? (50 * 1024 * 1024) : UPLOAD_MAX_SIZE; // 50MB for videos, 5MB for images
            if ($files['size'][$i] > $maxSize) {
                $maxSizeMB = $isVideo ? '50MB' : '5MB';
                $errors[] = "File {$files['name'][$i]}: File too large (max {$maxSizeMB})";
                continue;
            }
            
            // Generate unique filename
            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $prefix = $isVideo ? 'vid_' : 'img_';
            $filename = uniqid($prefix, true) . '.' . $extension;
            $filePath = $galleryUploadPath . $filename;
            $relativePath = '/assets/uploads/galleries/' . $galleryId . '/' . $filename;
            
            // Move uploaded file
            if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                $width = null;
                $height = null;
                
                // Get dimensions for images
                if (!$isVideo) {
                    $imageInfo = getimagesize($filePath);
                    $width = $imageInfo[0] ?? null;
                    $height = $imageInfo[1] ?? null;
                } else {
                    // For videos, try to get dimensions using getid3 or similar
                    // For now, we'll leave them null
                }
                
                // Save to database
                $imageData = [
                    'gallery_id' => $galleryId,
                    'title' => pathinfo($files['name'][$i], PATHINFO_FILENAME),
                    'filename' => $filename,
                    'original_filename' => $files['name'][$i],
                    'file_path' => $relativePath,
                    'file_size' => $files['size'][$i],
                    'mime_type' => $mimeType,
                    'width' => $width,
                    'height' => $height,
                    'sort_order' => $maxSortOrder + $i + 1,
                    'created_by' => $_SESSION['admin_user_id'] ?? null
                ];
                
                $this->imageModel->create($imageData);
                $uploadedFiles[] = $files['name'][$i];
            } else {
                $errors[] = "Datoteka {$files['name'][$i]}: Neuspešno čuvanje";
            }
        }
        
        if (!empty($uploadedFiles)) {
            logMessage("Media files uploaded to gallery {$galleryId}: " . implode(', ', $uploadedFiles), 'INFO');
        }
        
        $this->json([
            'success' => !empty($uploadedFiles),
            'uploaded' => $uploadedFiles,
            'errors' => $errors,
            'message' => !empty($uploadedFiles) 
                ? count($uploadedFiles) . ' fajl(ova) uspešno otpremljeno' 
                : 'Otpremanje nije uspelo'
        ]);
    }
    
    /**
     * Delete image
     */
    public function deleteImage($imageId) {
        // Verify CSRF token
        $csrfToken = $_GET['token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            $this->json(['success' => false, 'message' => 'Nevažeći sigurnosni token'], 403);
        }
        
        $image = $this->imageModel->find($imageId);
        if (!$image) {
            $this->json(['success' => false, 'message' => 'Slika nije pronađena'], 404);
        }
        
        try {
            // Delete file
            $filePath = ADMIN_PATH . '/' . ltrim($image['file_path'], '/');
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Delete from database
            $this->imageModel->delete($imageId);
            
            logMessage("Image deleted: {$image['filename']} (ID: {$imageId})", 'INFO');
            $this->json(['success' => true, 'message' => 'Slika je uspešno obrisana']);
        } catch (Exception $e) {
            logMessage("Error deleting image: " . $e->getMessage(), 'ERROR');
            $this->json(['success' => false, 'message' => 'Došlo je do greške pri brisanju slike'], 500);
        }
    }
    
    /**
     * Update image details
     */
    public function updateImage($imageId) {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            $this->json(['success' => false, 'message' => 'Nevažeći sigurnosni token'], 403);
        }
        
        $image = $this->imageModel->find($imageId);
        if (!$image) {
            $this->json(['success' => false, 'message' => 'Slika nije pronađena'], 404);
        }
        
        $title = sanitize($_POST['title'] ?? '');
        $altText = sanitize($_POST['alt_text'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        
        try {
            $this->imageModel->update($imageId, [
                'title' => $title,
                'alt_text' => $altText,
                'description' => $description,
                'sort_order' => $sortOrder
            ]);
            
            $this->json(['success' => true, 'message' => 'Slika je uspešno ažurirana']);
        } catch (Exception $e) {
            logMessage("Error updating image: " . $e->getMessage(), 'ERROR');
            $this->json(['success' => false, 'message' => 'Došlo je do greške pri ažuriranju slike'], 500);
        }
    }
}
