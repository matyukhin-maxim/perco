<?php

/** @property MonitorModel $model
 * @property PHPExcel $xls
 */
class ReportController extends CController {

	private $xls;

	public function __construct() {
		parent::__construct();

		$this->scripts[] = 'settings';
		$this->xls = null;
	}

	public function actionIndex() {

		// Выведем список всех доступных отчетов
		$this->render('report-list');
	}

	private function printHead($rowNum, $title) {

		if (!$this->xls) return;


	}

	public function actionLate() {


		$this->data['report'] = CHtml::createTag('tr', ['class' => 'warning strong'], [
			CHtml::createTag('td', ['colspan' => 6], 'Нет данных'),
		]);

		if (isPOST()) {

			// Если пришли по этому адресу POST запросом, то значит пользователь наэал кнопку "Сохранить"
			// Следовательно тут будем генерировать Excel файл отчета

			$bdate = filter_input(INPUT_POST, 'bdate', FILTER_SANITIZE_STRING) ?: date('Y-m-d');
			$edate = filter_input(INPUT_POST, 'edate', FILTER_SANITIZE_STRING) ?: date('Y-m-d');
			$split = get_param($_POST, 'split') === 'on';

			$this->initExcel();

			$report = $this->getLateReport($bdate, $edate);

			$columns = [   // Колонки отчета
				'ev_date' => [
					'title' => 'Дата',
					'width' => 15,
				],
				'ev_time' => [
					'title' => 'Время',
					'width' => 15
				],
				'tabnum' => [
					'title' => 'Табельный номер',
					'width' => 20
				],
				'fio' => [
					'title' => 'ФИО сотрудника',
					'width' => 40
				],
				'department' => [
					'title' => 'Подразделение',
					'width' => 30
				],
				'evt' => [
					'title' => 'Действие',
					'width' => 20
				],
			];
			$badChar = PHPExcel_Worksheet::getInvalidCharacters();      // Недопустимые символы для названия листов
			$cache = [];

			foreach ($report as $pTitle => $part) {

				foreach ($part as $line) {

					$dep = $split ? str_replace($badChar, ' ', get_param($line, 'department', '?')) : 'НГРЭС';
					if ($dep) {
						$sheet = $this->xls->getSheetByName($dep);
						if (!$sheet) {
							$sheet = $this->xls->createSheet()->setTitle($dep);


							// Установим нужные ширины колонок для нового листа
							$idx = 0;
							foreach ($columns as $title => $desc)
								$sheet->getColumnDimensionByColumn(++$idx)->setWidth(get_param($desc, 'width'));
						}
					} else continue;

					$printInfo = $cache[$dep]; // сводная информация о том, что напечатано на листе
					$lastRow = get_param($printInfo, 'last', 1);

					if (get_param($printInfo, $pTitle) === false) {
						// Табличку по текущей части отчета еще не рисовали на текущем листе


						// Заголовок периода
						$sheet->mergeCellsByColumnAndRow(1, ++$lastRow, count($columns), $lastRow);
						$sheet->setCellValueByColumnAndRow(1, $lastRow, $pTitle);

						// MAGIC !!!
						// Чтобы применить нужный стиль, нужно укзаать диапазон,
						// а т.к. у меня "динамика", нужного диапазрна я не знаю,
						// Взяв все объединенные диапазоны ячеек на странице, и возьмем оттуда последний элемент,
						// это и будет требуемый диапазон
						//
						$range = key(array_slice($sheet->getMergeCells(), -1, 1));
						$sheet->getStyle($range)->applyFromArray([
							'font' => [
								'name' => 'Helvetica',
								'size' => 12,
								'bold' => true,
								'italic' => true,
							],
							'borders' => [
								'allborders' => [
									'style' => PHPExcel_Style_Border::BORDER_THICK,
								],
							],
							'alignment' => [
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							],
							'fill' => [
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => [
									//'rgb' => '92CDDC',
									'rgb' => 'FABF8F',
								],
							]
						]);


						// Заголовки колонок
						$lastRow++;
						$idx = 1;
						foreach ($columns as $cell => $desc) {
							$cell = $sheet->setCellValueByColumnAndRow($idx++, $lastRow, get_param($desc, 'title'), true);
							$sheet->getStyle($cell->getCoordinate())->applyFromArray([
								'font' => [
									'bold' => true,
								],
								'borders' => [
									'allborders' => [
										'style' => PHPExcel_Style_Border::BORDER_THIN,
									],
								],
								'alignment' => [
									'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								],
							]);
						}

						$lastRow++;
						$printInfo[$pTitle] = 1;
					}

					// Чтобы не прописывать значение для каждой колонки, будем использовать ту же "динамику"
					// но значение в колонке с датой подменю, чтобы было более красиво
					//$idx = 0;
					//foreach(array_keys($columns) as $col) $sheet->setCellValueByColumnAndRow(++$idx, $lastRow, get_param($line, $col));

					// Заполняем значения колонок
					// т.к. некоторые значения нужно менять, цыкл по всем колонкам не прокатит...
					//
					$sheet->setCellValueByColumnAndRow(1, $lastRow, sqldate2human(get_param($line, 'ev_date'), 'd.m.Y', 'Y-m-d'));
					$sheet->setCellValueByColumnAndRow(2, $lastRow, get_param($line, 'ev_time'));
					$sheet->setCellValueByColumnAndRow(4, $lastRow, get_param($line, 'fio'));
					$sheet->setCellValueByColumnAndRow(5, $lastRow, get_param($line, 'department'));
					$sheet->setCellValueByColumnAndRow(6, $lastRow, get_param($line, 'evt'));
					$sheet->setCellValueExplicitByColumnAndRow(3, $lastRow, get_param($line, 'tabnum'), PHPExcel_Cell_DataType::TYPE_STRING);


					$lastRow++;
					$sheet->setSelectedCell('A1');

					$printInfo['last'] = $lastRow;
					$cache[$dep] = $printInfo;
				}
			}

			$this->xls->removeSheetByIndex(0); // Лист соданный по умолчанию (Worksheet) удаляем
			$this->xls->setActiveSheetIndex(0);
			$this->saveExcel();
			return;
		}

		$this->render('late', false);
		$this->render('data-table');
	}

	public function ajaxLate() {

		$bdate = filter_input(INPUT_POST, 'bdate', FILTER_SANITIZE_STRING) ?: date('Y-m-d');
		$edate = filter_input(INPUT_POST, 'edate', FILTER_SANITIZE_STRING) ?: date('Y-m-d');

		$this->model = new MonitorModel(); // Будем работатьс моделью мониторинга

		$report = [];
		$dump = $this->getLateReport($bdate, $edate);

		foreach ($dump as $item) {
			// Сливаем даные по 4 периодам в один обзий массив
			// для PHP отчета это разделение не особо нужно
			$report = array_merge($report, array_values($item));
		}

		$columns = ['ev_date', 'ev_time', 'tabnum', 'fio', 'department', 'evt'];
		$cnt = count($report);
		for ($idx = 0; $idx < $cnt; $idx++) {
			$cell = [];
			foreach ($columns as $cellname) $cell[] = CHtml::createTag('td', null, get_param($report[$idx], $cellname));
			echo CHtml::createTag('tr', null, $cell);
		}

		if (count($this->model->getErrors())) {
			$this->preparePopup($this->model->getErrorList());
		}
	}

	private function getLateReport($dateStart, $dateStop) {

		$result = [];
		$xmod = new MonitorModel();

		// Формируем отчет по 4 временным интервалам, развернув полученный ответ
		// т.к. в мониторинге используется обратный порядок просмотра

		$params = [];
		$params['bdate'] = $dateStart;
		$params['edate'] = $dateStop;

		// ВХОД 07:57 - 08:20
		$params['action'] = [2];
		$params['btime'] = '07:57';
		$params['etime'] = '08:20';
		$result['ВХОД 07:57 - 08:20'] = array_reverse($xmod->getActions($params, -1));

		// ВХОД 08:57 - 09:20
		$params['action'] = [2];
		$params['btime'] = '08:57';
		$params['etime'] = '09:20';
		$result['ВХОД 08:57 - 09:20'] = array_reverse($xmod->getActions($params, -1));

		// ВЫХОД 15:40 - 16:04
		$params['action'] = [1];
		$params['btime'] = '15:40';
		$params['etime'] = '16:04';
		$result['ВЫХОД 15:40 - 16:04'] = array_reverse($xmod->getActions($params, -1));

		// ВЫХОД 16:40 - 17:04
		$params['action'] = [1];
		$params['btime'] = '16:40';
		$params['etime'] = '17:04';
		$result['ВЫХОД 16:40 - 17:04'] = array_reverse($xmod->getActions($params, -1));

		if (count($xmod->getErrors())) $this->preparePopup($xmod->getErrorList()); // Ошибки
		return $result;
	}

	private function initExcel() {

		$this->xls = new PHPExcel();
		$this->xls->getDefaultStyle()->getFont()->setName('Tahoma')->setSize(10);
		$this->xls->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->xls->setActiveSheetIndex(0);
	}

	private function saveExcel() {

		if (!$this->xls) return;

		header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=report.xlsx");

		$objWriter = new PHPExcel_Writer_Excel2007($this->xls);
		$objWriter->save('php://output');

		//$this->scripts[] = 'autoclose';
		//$this->render('');
		//$objWriter->save('D:/report.xlsx');
		$this->xls = null;
	}

}
