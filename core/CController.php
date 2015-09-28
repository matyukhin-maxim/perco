<?php

class CController {

    public $arguments;
    public $title;
            
    function __construct() {
        
        $this->title = 'Проходная НГРЭС';
        $this->arguments = array();
    }
    
    public function render($view, $endpage = true) {
        
    }
    
    public function renderPartial($view) {
        
    }
    
    public function actionIndex() {
        
    }
    
    public function ajaxIndex() {
        
    }
    
    public function redirect($location) {
        
    }

}