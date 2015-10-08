<?php

/** @property MonitorModel $model */
class MonitorController extends CController {

    public function actionIndex() {

        $this->scripts[] = 'monitoring';

        $this->data['p_head'] = 'Мониторинг сотрудников';
        $this->render('../info', false);
        
        // get all departments for selectbox
        $this->data['depots'] = $this->model->getDepots();
        
        $this->render('filter', false);

        $this->render('table');
    }

    public function ajaxGetdata() {

        $filter = [
            'bdate' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^\d{4}(\-\d{2}){2}$/',
                    'default' => '2015-10-01' //date('Y-m-d'),
                ],
            ],
            'edate' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^\d{4}(\-\d{2}){2}$/',
                    'default' => date('Y-m-d'),
                ],
            ],
            'btime' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
                    'default' => '00:00',
                ],
            ],
            'etime' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
                    'default' => '23:59',
                ],
            ],
            'lname' => FILTER_SANITIZE_STRING,
            'fname' => FILTER_SANITIZE_STRING,
            'pname' => FILTER_SANITIZE_STRING,
            'depot' => [
                'filter' => FILTER_SANITIZE_STRING,
                'flags'  => FILTER_REQUIRE_ARRAY,
            ],
            'tabn'  => FILTER_SANITIZE_STRING,
        ];
        
        $params = filter_input_array(INPUT_POST, $filter); 
        $data = $this->model->getActions($params);
                
        //var_dump($data);
        
        $this->data['events'] = $data['data'];
        echo $this->renderPartial('rowdata');
        
        //var_dump(array_merge($_POST, $data));
    }

}
