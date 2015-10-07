<?php
/** @property PDOStatement $statements[] */
class SyncronizationModel extends CModel {

    private $usth; // percon statement
    private $esth; // events statemant
    private $statements = [];

    public function __construct() {
        parent::__construct();
        
        $this->statements['person'] = $this->db->prepare(''
                . 'replace into person '
                . '(id, lname, fname, pname, tabnum, department, position, photo, deleted) '
                . 'values (:id, :lname, :fname, :pname, :tabn, :dep, :pos, :pic, :del)');
               
    }

    public function runStatement($params, $sthname) {
        
        /** @var PDOStatement */
        $sth = get_param($this->statements, $sthname);
        if (!$sth) {
            self::$errorlist[] = "Statement '$sthname' not found";
            return;
        }
        
        
    }
    
    public function deleteAllUsers() {
        
        return $this->db->query('update person set deleted = 1');
    }

}