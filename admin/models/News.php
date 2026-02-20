<?php
/**
 * News Model
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class News extends BaseModel {
    protected $table = 'news';
    protected $primaryKey = 'id';
    
    /**
     * Find news by slug
     */
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    /**
     * Find published news
     */
    public function findPublished($limit = null, $orderBy = 'published_date DESC') {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'published'";
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Generate unique slug from title
     */
    public function generateSlug($title, $excludeId = null) {
        $baseSlug = $this->slugify($title);
        $slug = $baseSlug;
        $counter = 1;
        
        while (true) {
            $existing = $this->findBySlug($slug);
            if (!$existing || ($excludeId && $existing['id'] == $excludeId)) {
                return $slug;
            }
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
    }
    
    /**
     * Convert string to URL-friendly slug
     */
    private function slugify($text) {
        // Serbian Latin character mapping
        $serbian = [
            'č' => 'c', 'ć' => 'c', 'đ' => 'd', 'š' => 's', 'ž' => 'z',
            'Č' => 'C', 'Ć' => 'C', 'Đ' => 'D', 'Š' => 'S', 'Ž' => 'Z'
        ];
        
        $text = strtr($text, $serbian);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        
        return $text;
    }
    
    /**
     * Find published news by slug
     */
    public function findPublishedBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}
