<?php

class CController {

    // arguments passed in url, for selected action
    public $arguments;
    
    // page title for each page can be diferent
    public $title;
    
    // model class for controller
    public $model = null;
    
    // variables for output templates
    public $data = [];
    
    // some special vars for internal use
    private $hprint = false;
    private $viewFolder = './views/';
            
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
        
        extract($this->data);
        
        
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