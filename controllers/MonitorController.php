<?php

/** @property MonitorModel $model */
class MonitorController extends CController {

	public function actionIndex() {

		$this->scripts[] = 'monitoring';

		$this->title .= ': Мониторинг';
		$this->data['p_head'] = 'Мониторинг сотрудников';
		//$this->render('../info', false);

		// get all departments for selectbox
		$depots = $this->model->getDepots();
		foreach ($depots as $did => $item) $this->data['options'] .= CHtml::createOption($item, $did);

		$this->data['sync'] = $this->model->getLastSync();

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
			'tabn' => FILTER_SANITIZE_STRING,
			'depot' => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags' => FILTER_REQUIRE_ARRAY,
			],
			'action' => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags' => FILTER_REQUIRE_ARRAY,
			],
		];

		$params = filter_input_array(INPUT_POST, $filter);
		$params['action'] = $params['action'] ?: [0];
		if (!get_param($params, 'depot')) unset($params['depot']); // Удаляем из параметров пустой массив (null)

		$data = $this->model->getActions($params);

		if (count($this->model->getErrors()))
			$this->preparePopup($this->model->getErrorList());

		//var_dump($params);
		$this->data['events'] = $data;
		echo $this->renderPartial('rowdata');

		//var_dump(array_merge($_POST, $data));
	}

}
