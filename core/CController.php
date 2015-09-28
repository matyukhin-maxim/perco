<?php

class CController {

    public $arguments;
    public $title;
    public $model = null;
            
    function __construct() {
        
        $this->title = 'Проходная НГРЭС';
        $this->arguments = array();
        
        // сформируем и проинициализируем модель по умолчанию 
        // для текущего контроллера.
        // её можно будет переопределить в конструкторе потомка
        $defaultModel = str_replace('Controller', 'Model', get_class($this));
        if (class_exists($defaultModel))
            $this->model = new $defaultModel();
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