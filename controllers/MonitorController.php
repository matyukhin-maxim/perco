<?php

class MonitorController extends CController {

    public function actionIndex() {

        $this->scripts[] = 'monitoring';

        $this->data['p_head'] = 'Активность сотрудников';
        $this->render('../info', false);

        $this->render('filter', false);

        $this->render('table');
    }

    public function ajaxGetdata() {

        $filter = [
            'bdate' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^\d{4}(\-\d{2}){2}$/',
                    'default' => date('Y-m-d'),
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
            
        ];

        /*
        $bdate = filter_input(INPUT_POST, 'bdate', FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => '/^\d{4}(\-\d{2}){2}$/',
                'default' => date('Y-m-d'),
            ],
        ]);*/
        
        $data = filter_input_array(INPUT_POST, $filter);

        var_dump($data);
        //var_dump($_POST);
        
        //var_dump(array_merge($_POST, $data));
    }

}
