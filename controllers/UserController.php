<?php

/** @property UserModel $model */
class UserController extends CController {
    
    public function actionInfo() {
        
        //var_dump($this->arguments);
        $this->render('', false);
        
        $uid = get_param($this->arguments, 0, -1);
        
        $uinfo = $this->model->getUserInfo($uid);
        //var_dump($uinfo);
        
        $data  = get_param($uinfo, 'data');
        $rec   = get_param($data, 0);
        
        $this->data['blob'] = base64_encode(get_param($rec, 'photo'));
        $this->render('info');
        
    }
    
}