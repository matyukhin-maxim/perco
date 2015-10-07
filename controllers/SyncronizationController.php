<?php


/** @property SyncronizationModel $model */
class SyncronizationController extends CController {
    
    public $path;
    
    public function __construct() {
        parent::__construct();
        
        $config = include './config/config.php';
        $this->path = get_param($config, 'dbpath', '/');
    }


    public function actionIndex() {
        
        
        $this->render('', false);
        var_dump($this->path);
        
        $this->syncUsers();
        $this->render('');
        
    }
    
    public function syncUsers() {

        if (!CModel::isConnected()) return;
        
        try {
            $pdb = new ParadoxDB($this->path . "STAFF/STAFF.DB", true);
        } catch (Exception $ex) {
            printf("Paradox Error: <strong>%s</strong> <br/>\n", $ex->getMessage());
            $pdb = null;
            return;
        }
        
        
        $ok = 1;
        $this->model->startTransaction();
        $ok *= $this->model->deleteAllUsers();

        $cnt = $pdb->getCount();
        while (--$cnt >= 0 && $ok) {

            $record = $pdb->getRecord($cnt);
            $params = [
                'id' => get_param($record, 'PersonId'),
                'lname' => d2u(get_param($record, 'Family')),
                'fname' => d2u(get_param($record, 'Name')),
                'pname' => d2u(get_param($record, 'Patronymic')),
                'tabn'  => d2u(get_param($record, 'TabelId')),
                'dep'   => d2u(get_param($record, 'SubdivId')),
                'pos'   => d2u(get_param($record, 'AppointId')),
                'pic'   => get_param($record, 'Portret'),
                'del'   => 0,
            ];

            $ok *= $this->model->runStatement($params);
        }

        $this->model->stopTransaction($ok);
        $pdb->closeDB();
        
        var_dump($ok);
        var_dump($this->model->getErrors());
        return true;
    }
    
}