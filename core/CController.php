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
    private $classname;
            
    function __construct() {
        
        $this->title = 'Проходная НГРЭС';
        $this->arguments = array();
        $this->classname = get_class($this);

        // сформируем и проинициализируем модель по умолчанию 
        // для текущего контроллера.
        // её можно будет переопределить в конструкторе потомка
        $defaultModel = str_replace('Controller', 'Model', $this->classname);
        if (class_exists($defaultModel))
            $this->model = new $defaultModel();
    }
    
    public function render($view, $endpage = true) {
        
        extract($this->data);
        if (!$this->hprint) {
            include $this->viewFolder . 'hcommon.php';
            $this->hprint = true;
        }

        $viewfile = $this->viewFolder . $this->classname . "/$view.php";
        if (file_exists($viewfile)) {
            include $viewfile;
        }

        if ($endpage) {
            include $this->viewFolder . 'fcommon.php';
        }
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