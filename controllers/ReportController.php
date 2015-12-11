<?php

class ReportController extends CController {

    public function actionIndex() {

        $this->render('filter');

    }

    public function actionSave() {

        if (!isPOST()) {
            $this->scripts[] = 'autoclose';
            $this->render('filter');
            return;
        }

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
        ];

        $params = filter_input_array(INPUT_POST, $filter);
        $params['btime'] = '07:30';
        $params['etime'] = '08:03';

        $model = new MonitorModel();

        //$this->render('', false);
        $data = $model->getActions($params, -1);

        $style = [
            'borders' => [
                'outline' => [
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                ],
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '696969',
                    ],
                ],
            ],
        ];

        $xls = new PHPExcel();
        $xls->getDefaultStyle()->getFont()->setName('Arial')->setSize(8);
        $sheet = $xls->setActiveSheetIndex(0);

        $sheet->setTitle('НГРЭС');
        $sheet->getStyle('B3')->applyFromArray($style);
        $sheet->getStyle('C3')->applyFromArray($style);

        $sheet->setCellValue('B3','ВХОД');
        $sheet->setCellValue('C3','С 7-57 ПО 8-30');
        $sheet->setCellValue('D2','ЧИСЛО');
        $sheet->setCellValue('E2','ВРЕМЯ');
        $sheet->setCellValue('F2','ТАБ №');
        $sheet->setCellValue('G2','Фамилия');
        $sheet->setCellValue('H2','Имя');
        $sheet->setCellValue('I2','Очество');
        $sheet->setCellValue('J2','Цех');
        $sheet->setCellValue('K2','123');

        $cnt = 3;
        foreach ($data as $row) {
            $sheet->setCellValueByColumnAndRow(1, ++$cnt, get_param($row, 'fio'));
        }

        header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/vnd.ms-excel" );
        header ( "Content-Disposition: attachment; filename=report.xls" );

        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');

        //var_dump($data);

        //$this->render('');
        /*
        $this->redirect([
            'back' => 1
        ]);
        */
    }

}
