<?php

class UserModel extends CModel {

	public function getUserInfo($uid) {

		$data = $this->select('
			SELECT p.tabnum, p.lname, p.fname, p.pname, p.position, d.title
			FROM person p
		  	LEFT JOIN departments d ON p.department = d.id
 			WHERE p.id = :uid', [
			'uid' => $uid,
		]);

		return get_param($data, 0, []);
	}

	public function getUsers($lname = '') {

		$query = 'SELECT p.*, d.title, p.position = "Гость" guest
                  FROM person p
                  LEFT JOIN departments d ON p.department = d.id';
		$param = [];

		if (!empty($lname)) {

			$query .= ' where lname like :lname';
			$param = [
				'lname' => toLike($lname),
			];
		}

		$query .= ' order by guest, lname, fname';

		$data = $this->select($query, $param);

		return $data;
	}

	public function getUserPhoto($uid) {

		$data = $this->select('SELECT photo FROM person WHERE id = :uid', ['uid' => $uid]);

		return get_param($data, 0, []);
	}

}