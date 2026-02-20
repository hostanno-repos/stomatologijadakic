<?php
/**
 * Content Model
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class Content extends BaseModel {
    protected $table = 'contents';
    protected $primaryKey = 'id';
    
    /**
     * Find content by page and key
     */
    public function findByKey($page, $keyName) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE page = ? AND key_name = ? 
            LIMIT 1
        ");
        $stmt->execute([$page, $keyName]);
        return $stmt->fetch();
    }
    
    /**
     * Find all contents by page
     */
    public function findByPage($page) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE page = ? 
            ORDER BY key_name ASC
        ");
        $stmt->execute([$page]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get all unique pages
     */
    public function getAllPages() {
        $stmt = $this->db->query("
            SELECT DISTINCT page 
            FROM {$this->table} 
            ORDER BY page ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Get all contents grouped by page
     */
    public function getAllGrouped() {
        $stmt = $this->db->query("
            SELECT * FROM {$this->table} 
            ORDER BY page ASC, key_name ASC
        ");
        $contents = $stmt->fetchAll();
        
        $grouped = [];
        foreach ($contents as $content) {
            if (!isset($grouped[$content['page']])) {
                $grouped[$content['page']] = [];
            }
            $grouped[$content['page']][] = $content;
        }
        
        return $grouped;
    }
}
