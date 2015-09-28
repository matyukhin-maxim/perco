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
        $this->classname = str_replace('Controller', '', get_class($this));

        // сформируем и проинициализируем модель по умолчанию 
        // для текущего контроллера.
        // её можно будет переопределить в конструкторе потомка
        $defaultModel = $this->classname . "Model";
        if (class_exists($defaultModel))
            $this->model = new $defaultModel();
    }
    
    public function render($view, $endpage = true) {
        
        extract($this->data);
        if (!$this->hprint) {
            include $this->viewFolder . 'hcommon.php';
            $this->hprint = true;
        }

        $viewfile = strtolower($this->viewFolder . $this->classname . "/$view.php");
        if (file_exists($viewfile)) {
            include $viewfile;
        }

        if ($endpage) {
            include $this->viewFolder . 'fcommon.php';
        }
    }
    
    public function renderPartial($view) {
        
        ob_start();
        ob_implicit_flush(false);

        extract($this->data);
        $viewfile = strtolower($this->viewFolder . $this->classname . "/$view.php");
        if (file_exists($viewfile)) {
            include $viewfile;
        }

        return ob_get_clean();
    }
    
    public function redirect($param = []) {
        
        $location = ROOT . get_param($param, 'location', '');
        if (get_param($param, 'back') === 1)
            $location = get_param($_SERVER, 'HTTP_REFERER', $location);
        if (get_param($param, 'soft') === 1) {
            $delay = get_param($param, 'delay', 3);
            echo "<meta http-equiv=\"refresh\" content=\"$delay; URL=$location\">";
        } else
            header("Location: $location");
        die;
    }
    
    // просто чтоб были (переопределяются в потомках)
    public function actionIndex() {
        
    }
    
    public function ajaxIndex() {
        
    }

}