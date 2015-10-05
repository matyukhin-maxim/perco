<?php

class AboutController extends CController {

    public function actionIndex() {
        
        $this->scripts[] = 'test';
        
        $this->render('index');
    }
    
}