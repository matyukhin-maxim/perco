<?php
/** @property PDOStatement $statements[] */
class SyncModel extends CModel {

    private $statements = [];

    public function __construct() {
        parent::__construct();
        
        $this->statements['person'] = self::$db->prepare(''
                . 'replace into person '
                . '(id, lname, fname, pname, tabnum, department, position, photo, deleted) '
                . 'values (:id, :lname, :fname, :pname, :tabn, :dep, :pos, :pic, :del)');
        
        $this->statements['event'] = self::$db->prepare(''
                . 'replace into events '
                . '(keyfile, id, ev_date, ev_time, ev_type, person_id) '
                . 'values (:key, :id, :date, :time, :type, :uid)');

        $this->statements['version'] = self::$db->prepare(''
                . 'replace into versions '
                . '(table_name, sync_id, sync_date) '
                . 'values (:key, :rcnt, now())');
    }

    public function runStatement($params, $sthname = 'stmt') {
        
        $sth = get_param($this->statements, $sthname);
        if (!$sth) {
            self::$errorlist[] = "Statement '$sthname' not found";
            return;
        }
        
        $res = $sth->execute($params);
        
        $einfo      = $sth->errorInfo();
        $message    = get_param($einfo, 2, '');
        if (!empty($message))
            self::$errorlist[] = $message;

        return $res;
    }
    
    public function getLastSyncId($tableName) {
        
        $data = $this->select('select sync_id from versions where table_name = :key ', [
            'key' => $tableName,
        ]);
        
        
        $rec = get_param($data, 0);
        return get_param($rec, 'sync_id', -1);
    }
    
    public function deleteAllUsers() {
        
        return self::$db->query('update person set deleted = 1') !== false;
    }

    public function isUserSyncNeeded() {

        $result = $this->select('
        select
        count(distinct person_id) cnt
        from events
        where
            ev_date > date_sub(now(), interval 1 month)
            and not exists (select id from person p where p.id = person_id)');

        // считаем количество пользователей в талице событий, id юзеров которых не найдены
        $data = get_param($result, 0);
        return get_param($data, 'cnt', 0) > 0;
    }
}