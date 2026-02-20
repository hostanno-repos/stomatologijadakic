<?php
/**
 * Image Model
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

class Image extends BaseModel {
    protected $table = 'images';
    protected $primaryKey = 'id';
    
    /**
     * Find images by gallery ID
     */
    public function findByGalleryId($galleryId, $orderBy = 'sort_order ASC, created_at DESC') {
        $sql = "SELECT * FROM {$this->table} WHERE gallery_id = ?";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$galleryId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get image count for a gallery
     */
    public function countByGalleryId($galleryId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE gallery_id = ?");
        $stmt->execute([$galleryId]);
        return $stmt->fetchColumn();
    }
}
