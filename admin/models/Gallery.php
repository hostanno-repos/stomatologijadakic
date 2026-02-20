<?php
/**
 * Gallery Model
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class Gallery extends BaseModel {
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    
    /**
     * Find gallery by slug
     */
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    /**
     * Get galleries with image count
     */
    public function findAllWithImageCount($conditions = [], $orderBy = 'sort_order ASC, created_at DESC') {
        $sql = "SELECT g.*, COUNT(i.id) as image_count 
                FROM {$this->table} g 
                LEFT JOIN images i ON g.id = i.gallery_id";
        
        $where = [];
        $params = [];
        
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $where[] = "g.{$key} = ?";
                $params[] = $value;
            }
        }
        
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $sql .= " GROUP BY g.id";
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Generate unique slug from title
     */
    public function generateSlug($title, $excludeId = null) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            $existing = $this->findBySlug($slug);
            if (!$existing || ($excludeId && $existing['id'] == $excludeId)) {
                return $slug;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    }
}
