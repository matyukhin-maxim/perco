<?php

/** @property RunModel $model  */
class IndexController extends CController {
       
    public function actionIndex() {
        
        $this->model = new RunModel();
        $this->data['phead'] = "Монитор проходной НГРЭС";
        $this->render('../info', false);

        //var_dump($this->model);
        $this->render('menu');
        
    }
}
