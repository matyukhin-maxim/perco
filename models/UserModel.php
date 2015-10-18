<?php

class UserModel extends CModel {
    
    public function getUserInfo($uid) {
        
        $data = $this->select('select * from person where id = :uid', [
            'uid' => $uid,
        ]);

        return get_param($data, 0, []);
    }

    public function getUsers($lname = '') {

        $query = 'select p.*, p.position = "Гость" guest
                  from person p';
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
    
}