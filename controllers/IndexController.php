<?php

/** @property RunModel $model  */
class IndexController extends CController {
       
    public function actionIndex() {

        $this->redirect('/monitor/');

        //$this->data['p_head'] = "Монитор проходной НГРЭС";
        //$this->render('../info', false);

        //var_dump($this->model);
        //$this->render('menu');
        
    }
}
