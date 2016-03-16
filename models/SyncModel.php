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
			. '(keyfile, id, ev_date, ev_time, ev_type, person_id, original) '
			. 'values (:key, :id, :date, :time, :type, :uid, :time)');

		$this->statements['version'] = self::$db->prepare(''
			. 'replace into versions '
			. '(table_name, sync_id, sync_date) '
			. 'values (:key, :rcnt, now())');

		$this->statements['department'] = self::$db->prepare(''
			. 'replace into departments '
			. '(id, title) '
			. 'values (:depid, :depname) '
		);
	}

	public function runStatement($params, $sthname = 'stmt') {

		$sth = get_param($this->statements, $sthname);
		if (!$sth) {
			self::$errorlist[] = "Statement '$sthname' not found";
			return 0;
		}

		$res = $sth->execute($params);

		$einfo = $sth->errorInfo();
		$message = get_param($einfo, 2, '');
		if (!empty($message))
			self::$errorlist[] = $message;

		return $res;
	}

	public function getLastSyncId($tableName) {

		$data = $this->select('SELECT sync_id FROM versions WHERE table_name = :key ', [
			'key' => $tableName,
		]);


		$rec = get_param($data, 0);
		return get_param($rec, 'sync_id', -1);
	}

	public function deleteAllUsers() {

		return self::$db->query('UPDATE person SET deleted = 1') !== false;
	}

	public function isUserSyncNeeded() {

		$result = $this->select('
        SELECT
        count(DISTINCT person_id) cnt
        FROM events
        WHERE
            ev_date > date_sub(now(), INTERVAL 1 MONTH)
            AND NOT exists (SELECT id FROM person p WHERE p.id = person_id)');

		// считаем количество пользователей в талице событий, id юзеров которых не найдены
		$data = get_param($result, 0);
		return get_param($data, 'cnt', 0) > 0;
	}

	public function getVipList() {

		return $this->select('SELECT * FROM vip WHERE deleted = 0');
	}

	public function getUserEvents($workDate, $userid) {

		return $this->select('SELECT * FROM events WHERE ev_date = :fdate AND person_id = :uid ORDER BY ev_time', [
			'uid' => $userid,
			'fdate' => $workDate,
		]);
	}

	public function fixEvent($e_key, $e_id, $new_time) {

		$chk = 0;

		$this->select('
			UPDATE events SET ev_time = :ntime
			WHERE keyfile = :ekey AND id = :eid', [
			'ntime' => $new_time,
			'ekey' => $e_key,
			'eid' => $e_id,
		], $chk);

		return $chk === 1;
	}
}