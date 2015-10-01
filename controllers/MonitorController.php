<?php

class MonitorController extends CController {

	public function actionIndex() {

		$this->data['p_head'] = 'Активность сотрудников';
		$this->render('../info', false);

		$this->render('filter', false);

		$this->render('table');

	}

}