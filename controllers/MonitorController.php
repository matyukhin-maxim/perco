<?php

class MonitorController extends CController {

	public function actionRun() {

		$this->scripts[] =  'run';
		$this->render('');
	}

}