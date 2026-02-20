<?php
/**
 * SiteImage Model – replaceable site images (key => path).
 *
 * @package    DakicCMS
 * @subpackage Admin
 */

class SiteImage extends BaseModel {
    protected $table = 'site_images';
    protected $primaryKey = 'key';

    /**
     * Get path for a key (or null if using default).
     */
    public function getPath($key) {
        $stmt = $this->db->prepare("SELECT path FROM {$this->table} WHERE `key` = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ? $row['path'] : null;
    }

    /**
     * Set path for a key (insert or update).
     */
    public function setPath($key, $path) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (`key`, path) VALUES (?, ?) ON DUPLICATE KEY UPDATE path = VALUES(path)");
        return $stmt->execute([$key, $path]);
    }

    /**
     * Get all custom paths as key => path.
     */
    public function getAllPaths() {
        $stmt = $this->db->query("SELECT `key`, path FROM {$this->table}");
        $out = [];
        while ($row = $stmt->fetch()) {
            $out[$row['key']] = $row['path'];
        }
        return $out;
    }
}
