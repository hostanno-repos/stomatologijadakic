<?php
/**
 * Contents Controller
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class ContentsController extends BaseController {
    private $contentModel;
    
    // Available pages
    private $availablePages = [
        'header' => 'Header',
        'footer' => 'Footer',
        'sidemenu' => 'Side Menu',
        'index' => 'Početna',
        'kontakt' => 'Kontakt',
        'onama' => 'O nama',
        'galerija' => 'Galerija',
        'novosti' => 'Novosti'
    ];
    
    public function __construct() {
        parent::__construct();
        $this->contentModel = new Content();
    }
    
    /**
     * List all contents grouped by page
     */
    public function index() {
        $selectedPage = sanitize($_GET['page'] ?? '');
        
        // Get all contents grouped
        $allContents = $this->contentModel->getAllGrouped();
        
        // Get available pages
        $pages = $this->availablePages;
        
        // Filter contents if page selected
        $filteredContents = [];
        if ($selectedPage) {
            $filteredContents = $this->contentModel->findByPage($selectedPage);
        } else {
            $filteredContents = $allContents;
        }
        
        $data = [
            'title' => 'Sadržaji',
            'page_title' => 'Upravljanje sadržajima',
            'contents' => $filteredContents,
            'all_contents' => $allContents,
            'available_pages' => $pages,
            'selected_page' => $selectedPage
        ];
        
        $this->render('contents/index', $data);
    }
    
    /**
     * Show edit form for a specific page
     */
    public function edit() {
        $page = sanitize($_GET['page'] ?? '');
        
        if (empty($page)) {
            setFlash('error', 'Stranica je obavezna');
            $this->redirect(ADMIN_URL . '/contents');
        }
        
        // Get existing contents for this page
        $contents = $this->contentModel->findByPage($page);
        
        // Get available keys for this page
        $existingKeys = array_column($contents, 'key_name');
        
        $data = [
            'title' => 'Izmeni sadržaj',
            'page_title' => 'Izmeni sadržaj: ' . ($this->availablePages[$page] ?? $page),
            'page' => $page,
            'contents' => $contents,
            'existing_keys' => $existingKeys,
            'csrf_token' => generateCsrfToken()
        ];
        
        $this->render('contents/form', $data);
    }
    
    /**
     * Update contents
     */
    public function update() {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token. Molimo pokušajte ponovo.');
            $this->redirect(ADMIN_URL . '/contents');
        }
        
        $page = sanitize($_POST['page'] ?? '');
        
        if (empty($page)) {
            setFlash('error', 'Stranica je obavezna');
            $this->redirect(ADMIN_URL . '/contents');
        }
        
        // Get all posted content fields
        $contents = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'content_') === 0) {
                $keyName = str_replace('content_', '', $key);
                $description = sanitize($_POST['desc_' . $keyName] ?? '');
                $contents[$keyName] = [
                    'value' => $value, // Don't sanitize HTML content
                    'description' => $description
                ];
            }
        }
        
        try {
            foreach ($contents as $keyName => $contentData) {
                // Check if content exists
                $existing = $this->contentModel->findByKey($page, $keyName);
                
                if ($existing) {
                    // Update existing
                    $this->contentModel->update($existing['id'], [
                        'value' => $contentData['value'],
                        'description' => $contentData['description']
                    ]);
                } else {
                    // Create new
                    $this->contentModel->create([
                        'page' => $page,
                        'key_name' => $keyName,
                        'value' => $contentData['value'],
                        'description' => $contentData['description'],
                        'created_by' => $_SESSION['admin_user_id'] ?? null
                    ]);
                }
            }
            
            logMessage("Contents updated for page: {$page}", 'INFO');
            setFlash('success', 'Sadržaj je uspešno ažuriran');
            $this->redirect(ADMIN_URL . '/contents?page=' . urlencode($page));
            
        } catch (Exception $e) {
            logMessage("Error updating contents: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri ažuriranju sadržaja');
            $this->redirect(ADMIN_URL . '/contents/edit?page=' . urlencode($page));
        }
    }
    
    /**
     * Add new content field
     */
    public function addField() {
        // Verify CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            $this->json(['success' => false, 'message' => 'Nevažeći sigurnosni token'], 403);
        }
        
        $page = sanitize($_POST['page'] ?? '');
        $section = sanitize($_POST['section'] ?? '');
        $keyName = sanitize($_POST['key_name'] ?? '');
        $value = $_POST['value'] ?? '';
        $description = sanitize($_POST['description'] ?? '');
        
        if (empty($page) || empty($section) || empty($keyName)) {
            $this->json(['success' => false, 'message' => 'Stranica, sekcija i ključ su obavezni'], 400);
        }
        
        // Check if key already exists
        $existing = $this->contentModel->findByKey($page, $section, $keyName);
        if ($existing) {
            $this->json(['success' => false, 'message' => 'Ključ već postoji za ovu stranicu i sekciju'], 400);
        }
        
        try {
            $id = $this->contentModel->create([
                'page' => $page,
                'section' => $section,
                'key_name' => $keyName,
                'value' => $value,
                'description' => $description,
                'created_by' => $_SESSION['admin_user_id'] ?? null
            ]);
            
            $this->json(['success' => true, 'message' => 'Sadržaj je uspešno dodat', 'id' => $id]);
        } catch (Exception $e) {
            logMessage("Error adding content: " . $e->getMessage(), 'ERROR');
            $this->json(['success' => false, 'message' => 'Došlo je do greške pri dodavanju sadržaja'], 500);
        }
    }
    
    /**
     * Delete content
     */
    public function delete($id) {
        // Verify CSRF token
        $csrfToken = $_GET['token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            setFlash('error', 'Nevažeći sigurnosni token');
            $this->redirect(ADMIN_URL . '/contents');
        }
        
        $content = $this->contentModel->find($id);
        if (!$content) {
            setFlash('error', 'Sadržaj nije pronađen');
            $this->redirect(ADMIN_URL . '/contents');
        }
        
        try {
            $this->contentModel->delete($id);
            logMessage("Content deleted: {$content['page']}/{$content['section']}/{$content['key_name']} (ID: {$id})", 'INFO');
            setFlash('success', 'Sadržaj je uspešno obrisan');
        } catch (Exception $e) {
            logMessage("Error deleting content: " . $e->getMessage(), 'ERROR');
            setFlash('error', 'Došlo je do greške pri brisanju sadržaja');
        }
        
        $this->redirect(ADMIN_URL . '/contents?page=' . urlencode($content['page']));
    }
}
