<?php
/**
 * Employee Model
 *
 * @package    DakicCMS
 * @subpackage Admin
 */

class Employee extends BaseModel {
    protected $table = 'employees';
    protected $primaryKey = 'id';

    /**
     * Find all employees ordered by sort_order
     */
    public function findAllOrdered($orderBy = 'sort_order ASC, last_name ASC, first_name ASC') {
        return $this->findAll([], $orderBy);
    }
}
