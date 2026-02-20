<?php
/**
 * News Controller
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class NewsController extends BaseController {
    private $newsModel;
    private $uploadPath;
    
    public function __construct() {
        parent::__construct();
        $this->newsModel = new News();
        $this->uploadPath = ADMIN_PATH . '/assets/uploads/news/';
        
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
     * List all news
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
            $news = $this->newsModel->findAll([], 'published_date DESC, created_at DESC');
            $news = array_filter($news, function($item) use ($search) {
                return stripos($item['title'], $search) !== false || 
                       stripos($item['excerpt'] ?? '', $search) !== false ||
                       stripos($item['content'] ?? '', $search) !== false;
            });
            $totalNews = count($news);
            $news = array_slice($news, $offset, $perPage);
        } else {
            $news = $this->newsModel->findAll($conditions, 'published_date DESC, created_at DESC');
            $totalNews = count($news);
            $news = array_slice($news, $offset, $perPage);
        }
        
        $totalPages = ceil($totalNews / $perPage);
        
        $data = [
            'title' => 'Novosti',
            'page_title' => 'Upravljanje novostima',
            'news' => $news,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_news' => $totalNews,
            'search' => $search
        ];
        
        $this->render('news/index', $data);
    }
    
    /**
     * Show create news form
     */
    public function create() {
        $data = [
            'title' => 'Kreiraj novost',
            'page_title' => 'Kreiraj novu novost',
            'news' => null,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('news/form', $data);
    }
    
    /**
     * Store new news
     */
    public function store() {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
            $this->redirect(ADMIN_URL . '/news/create');
        }
        
        // Get and sanitize input
        $title = sanitize($_POST['title'] ?? '');
        $excerpt = sanitize($_POST['excerpt'] ?? '');
        $content = $_POST['content'] ?? ''; // Don't sanitize HTML content
        $status = sanitize($_POST['status'] ?? 'draft');
        $publishedDate = sanitize($_POST['published_date'] ?? '');
        $publishedTime = sanitize($_POST['published_time'] ?? '00:00');
        
        // Validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Naziv je obavezan';
        }
        
        if (empty($content)) {
            $errors[] = 'Sadržaj je obavezan';
        }
        
        if (!in_array($status, ['draft', 'published', 'archived'])) {
            $errors[] = 'Nevažeći status';
        }
        
        // Parse published date
        $publishedDateTime = null;
        if (!empty($publishedDate)) {
            $publishedDateTime = $publishedDate . ' ' . $publishedTime . ':00';
            if (!strtotime($publishedDateTime)) {
                $errors[] = 'Nevažeći datum objave';
            }
        }
        
        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/news/create');
        }
        
        // Handle featured image upload
        $featuredImage = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($_FILES['featured_image']);
            if ($uploadResult['success']) {
                $featuredImage = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }
        
        // Create news
        try {
            $slug = $this->newsModel->generateSlug($title);
            
            $newsData = [
                'title' => $title,
                'slug' => $slug,
                'excerpt' => $excerpt,
                'content' => $content,
                'featured_image' => $featuredImage,
                'status' => $status,
                'published_date' => $publishedDateTime,
                'created_by' => $_SESSION['admin_user_id'] ?? null
            ];
            
            $newsId = $this->newsModel->create($newsData);
            
            logMessage("News created: {$title} (ID: {$newsId})", 'INFO');
            setFlash('success', 'Novost je uspešno kreirana');
            $this->redirect(ADMIN_URL . '/news');
            
        } catch (Exception $e) {
            logMessage("Error creating news: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri kreiranju novosti');
            $this->redirect(ADMIN_URL . '/news/create');
        }
    }
    
    /**
     * Show edit news form
     */
    public function edit($id) {
        $news = $this->newsModel->find($id);
        
        if (!$news) {
            setFlash('error', 'Novost nije pronađena');
            $this->redirect(ADMIN_URL . '/news');
        }
        
        $data = [
            'title' => 'Izmeni novost',
            'page_title' => 'Izmeni novost',
            'news' => $news,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('news/form', $data);
    }
    
    /**
     * Update news
     */
    public function update($id) {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
            $this->redirect(ADMIN_URL . '/news/edit/' . $id);
        }
        
        $news = $this->newsModel->find($id);
        if (!$news) {
            setFlash('error', 'Novost nije pronađena');
            $this->redirect(ADMIN_URL . '/news');
        }
        
        // Get and sanitize input
        $title = sanitize($_POST['title'] ?? '');
        $excerpt = sanitize($_POST['excerpt'] ?? '');
        $content = $_POST['content'] ?? ''; // Don't sanitize HTML content
        $status = sanitize($_POST['status'] ?? 'draft');
        $publishedDate = sanitize($_POST['published_date'] ?? '');
        $publishedTime = sanitize($_POST['published_time'] ?? '00:00');
        $removeImage = isset($_POST['remove_featured_image']) && $_POST['remove_featured_image'] == '1';
        
        // Validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Naziv je obavezan';
        }
        
        if (empty($content)) {
            $errors[] = 'Sadržaj je obavezan';
        }
        
        if (!in_array($status, ['draft', 'published', 'archived'])) {
            $errors[] = 'Nevažeći status';
        }
        
        // Parse published date
        $publishedDateTime = null;
        if (!empty($publishedDate)) {
            $publishedDateTime = $publishedDate . ' ' . $publishedTime . ':00';
            if (!strtotime($publishedDateTime)) {
                $errors[] = 'Nevažeći datum objave';
            }
        }
        
        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            $this->redirect(ADMIN_URL . '/news/edit/' . $id);
        }
        
        // Handle featured image upload or removal
        $featuredImage = $news['featured_image'];
        if ($removeImage) {
            // Delete old image
            if ($featuredImage) {
                $oldImagePath = ADMIN_PATH . '/' . ltrim($featuredImage, '/');
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $featuredImage = null;
        } elseif (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            // Delete old image if exists
            if ($featuredImage) {
                $oldImagePath = ADMIN_PATH . '/' . ltrim($featuredImage, '/');
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Upload new image
            $uploadResult = $this->handleImageUpload($_FILES['featured_image']);
            if ($uploadResult['success']) {
                $featuredImage = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }
        
        // Update news
        try {
            $slug = $this->newsModel->generateSlug($title, $id);
            
            $newsData = [
                'title' => $title,
                'slug' => $slug,
                'excerpt' => $excerpt,
                'content' => $content,
                'featured_image' => $featuredImage,
                'status' => $status,
                'published_date' => $publishedDateTime
            ];
            
            $this->newsModel->update($id, $newsData);
            
            logMessage("News updated: {$title} (ID: {$id})", 'INFO');
            setFlash('success', 'Novost je uspešno ažurirana');
            $this->redirect(ADMIN_URL . '/news');
            
        } catch (Exception $e) {
            logMessage("Error updating news: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri ažuriranju novosti');
            $this->redirect(ADMIN_URL . '/news/edit/' . $id);
        }
    }
    
    /**
     * Delete news
     */
    public function delete($id) {
        // Verify CSRF token
        $csrfToken = $_GET['token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token');
            $this->redirect(ADMIN_URL . '/news');
        }
        
        $news = $this->newsModel->find($id);
        if (!$news) {
            setFlash('error', 'Novost nije pronađena');
            $this->redirect(ADMIN_URL . '/news');
        }
        
        try {
            // Delete featured image if exists
            if ($news['featured_image']) {
                $imagePath = ADMIN_PATH . '/' . ltrim($news['featured_image'], '/');
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $this->newsModel->delete($id);
            logMessage("News deleted: {$news['title']} (ID: {$id})", 'INFO');
            setFlash('success', 'Novost je uspešno obrisana');
        } catch (Exception $e) {
            logMessage("Error deleting news: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri brisanju novosti');
        }
        
        $this->redirect(ADMIN_URL . '/news');
    }
    
    /**
     * Handle image upload
     */
    private function handleImageUpload($file) {
        // Validate file type
        $mimeType = mime_content_type($file['tmp_name']);
        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return ['success' => false, 'error' => 'Nevažeći tip fajla. Dozvoljeni su: JPEG, PNG, GIF, WebP'];
        }
        
        // Validate file size (5MB)
        if ($file['size'] > UPLOAD_MAX_SIZE) {
            return ['success' => false, 'error' => 'Fajl je prevelik (maksimum 5MB)'];
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('news_', true) . '.' . $extension;
        $filePath = $this->uploadPath . $filename;
        $relativePath = '/assets/uploads/news/' . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return ['success' => true, 'path' => $relativePath];
        } else {
            return ['success' => false, 'error' => 'Neuspešno čuvanje fajla'];
        }
    }
}
