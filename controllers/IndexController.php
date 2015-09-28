<?php

/** @property RunModel $model  */
class IndexController extends CController {
       
    public function actionIndex() {
        
        $this->model = new RunModel();
        
        //var_dump($this->model);
        echo "hello";
        
    }
}