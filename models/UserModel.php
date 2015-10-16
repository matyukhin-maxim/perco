<?php

class UserModel extends CModel {
    
    public function getUserInfo($uid) {
        
        return $this->select('select * from person where id = :uid', [
            'uid' => $uid,
        ]);
        
    }
    
}