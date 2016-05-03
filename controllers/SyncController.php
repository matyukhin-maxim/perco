<?php

/** @property SyncModel $model */
class SyncController extends CController {

	public $path;
	private $cnt_sync_month = 2; // Количество месяцев для выполнения синхронизации событий

	public function __construct() {
		parent::__construct();

		$this->path = Configuration::$dbpath;
	}


	public function actionIndex() {

		$this->render('', false);

		$this->syncEvents(date('Y-m-d'));
		$this->syncUsers();
		$this->syncDepartments();

		$this->render('');
	}

	public function syncUsers() {

		if (!CModel::isConnected()) return false;

		try {
			$pdb = new ParadoxDB($this->path . "STAFF/STAFF.DB", true);
		} catch (Exception $ex) {
			printf("Paradox Error: %s\n", $ex->getMessage());
			return false;
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
				'tabn' => d2u(get_param($record, 'TabelId')),
				'dep' => d2u(get_param($record, 'Sdiv_Id')),
				'pos' => d2u(get_param($record, 'AppointId')),
				'pic' => get_param($record, 'Portret'),
				'del' => 0,
			];

			$ok *= $this->model->runStatement($params, 'person');
		}

		$ok *= $this->model->runStatement([
			'key' => 'USERS',
			'rcnt' => $pdb->getCount(),
		], 'version');
		$this->model->stopTransaction($ok);

		printf("[%s]: Sync user table %s\n", date('Y-m-d H:i:s'), $ok ? 'done' : 'fail');

		return (boolean)$ok;
	}

	public function syncEvents($pdate) {

		// if MySQL not available - fuck off
		if (!CModel::isConnected()) return false;


		// Parse input date by components ( & check it by the way )
		$check = date_parse_from_format('Y-m-d', $pdate);
		$error = get_param($check, 'error_count', 0) + get_param($check, 'warning_count', 0);

		if ($error > 0)
			return false;

		// create start timepoint ( first day of input date )
		$starttime = mktime(0, 0, 0, $check['month'], 1, $check['year']);

		// sync 2 last month
		for ($index = 0; $index < $this->cnt_sync_month; $index++) {

			$key = date('mY', $starttime);
			$fname = "$key.db"; // create database file name (in perco is - MMYYYY.db)
			// try read this database
			try {
				$pdb = new ParadoxDB($this->path . "EVENTS/$fname");
			} catch (Exception $ex) {
				printf("Paradox Error: %s\n", $ex->getMessage());
				$pdb = null;
			}

			if ($pdb) {
				// if db file was opened, begin our work
				// get last sync id of current db
				$lastid = $this->model->getLastSyncId($key);

				$ok = 1;
				$this->model->startTransaction();

				// read paradox db, and put records into mysql
				$pxcount = $pdb->getCount();
				$delta = $pxcount - $lastid;

				if ($pxcount > $lastid) {
					// save into mysql lasy syncronized id
					// if below will be error, transaction will rollback and changes don't saved
					$ok *= $this->model->runStatement([
						'key' => $key,
						'rcnt' => $pxcount,
					], 'version');
				}

				while (--$pxcount > $lastid && $ok) {

					$data = $pdb->getRecord($pxcount); // get current record

					// filter data by specified ccriteria (like person_id & s.o.)
					if (get_param($data, 'PERSONID') === 0) {
						--$delta;
						continue; // records with undefined user, there is nothing to db
					}

					if (get_param($data, 'EV_ID') > 1) {
						--$delta;
						continue; // we need only input/output event (1/0)
					}

					// make date from 1st row of data (   year & month get from 'startdate', day number - from db
					$mdate = date('Y-m', $starttime) . sprintf("-%02d", get_param($data, 'EV_DAY', 1));

					$params = [
						'key' => $key,
						'id' => get_param($data, 'ID'),
						'date' => $mdate,
						'time' => gmdate('H:i:s', get_param($data, 'EV_TIME', 0)),
						'type' => get_param($data, 'EV_ADRADD'), // 2-вход; 1-выход
						'uid' => get_param($data, 'PERSONID'),
					];

					$ok *= $this->model->runStatement($params, 'event');
				}

				$this->model->stopTransaction($ok);


				if ($delta > 0) {
					printf("[%s]: Sync %s table %s. %d record append.\n", date('Y-m-d H:i:s'), $fname, $ok ? 'done' : 'fail', $delta);
				}
				$pdb->closeDB();
			}

			$starttime = strtotime("-1 month", $starttime);
		}

		return true;
	}

	public function syncDepartments() {

		if (!CModel::isConnected()) return false;

		try {
			$pdb = new ParadoxDB($this->path . "STAFF/SDIV.DB", true);
		} catch (Exception $ex) {
			printf("Paradox Error: %s\n", $ex->getMessage());
			return false;
		}


		$ok = 1;
		$this->model->startTransaction();

		$cnt = $pdb->getCount();
		while (--$cnt >= 0 && $ok) {

			$record = $pdb->getRecord($cnt);
			$params = [
				'depid' => get_param($record, 'ID'),
				'depname' => d2u(get_param($record, 'Name')),
			];

			$ok *= $this->model->runStatement($params, 'department');
		}

		$ok *= $this->model->runStatement([
			'key' => 'DEPARTMENTS',
			'rcnt' => $pdb->getCount(),
		], 'version');
		$this->model->stopTransaction($ok);

		printf("[%s]: Sync departments table %s\n", date('Y-m-d H:i:s'), $ok ? 'done' : 'fail');

		return (boolean)$ok;
	}

	public function actionCli() {

		if (!CModel::isConnected()) return false;

		// Метод вызываемый при работе из консоли (cron)
		// Делаем то же самое что и при actionIndex, но добавим вывол в лог
		// и "умную" синхронизацию пользоватеелй

		// синхронизируем события за последние 2 месяца
		$this->syncEvents(date('Y-m-d'));

		// если нужно, то и юзеров
		if ($this->model->isUserSyncNeeded()) {
			$this->syncUsers();
			$this->syncDepartments();
		}

	}

	public function actionProtection($wdate = null) {

		if (!CModel::isConnected()) return false;

		// Если дата не передана в качестве аргумента функции, то ищем ее в аргументах запроса
		// а если и там нет, то берем текущую дату
		$wdate = $wdate ?: get_param($this->arguments, 0, date('Y-m-d'));
		$ctrl = DateTime::createFromFormat('Y-m-d', $wdate);
		if (!$ctrl) die("Проверяемая дата задана неверно.  YYYY-MM-DD");

		$vip = $this->model->getVipList();
		//$this->render('', false);

		$ok = 1;
		$this->model->startTransaction();

		foreach ($vip as $person) {

			// Обрабатываем каждого ВИПа отдельно,
			// т.к. в зависимости от пола (gender) исправления будут разные

			// Получаем все события по текущумю сотруднику за указаный день
			$userid = get_param($person, 'user_id', -1);
			$elist = $this->model->getUserEvents($wdate, $userid);
			//var_dump(get_param($person, 'fullname'), $elist);

			// Выбираем первый вход, и последний выход
			// т.к. из базы данные получены уже упорядоченные, то сравнение не нужно
			// просто берем 1ый ev_type == 2, и последний ev_type == 1
			$first = $last = [];
			foreach ($elist as $event) {

				$first = get_param($event, 'ev_type') === '2' ? $first ?: $event : $first;
				$last = get_param($event, 'ev_type') === '1' ? $event : $last;
			}

			$client = get_param($person, 'fullname', '???');

			// И делаем исправления если в этом есть необходимость
			if ($first) {
				// Переносим вход за "пограничное" время

				$zone = '07:55:00';
				$time = get_param($first, 'ev_time');
				if ($time >= $zone) {

					$shift = mt_rand(300, 1200); // Сдвиг в секундах от пограничной даты [5-20 минут]
					$time = DateTime::createFromFormat('H:i:s', $zone)
						->sub(DateInterval::createFromDateString("$shift seconds"))
						->format('H:i:s');

					$ok *= $this->model->fixEvent(get_param($first, 'keyfile'), get_param($first, 'id'), $time);
					printf("[%s]: \tFIX - [%s] %s %s -> %s\n",
						date('Y-m-d H:i:s'),
						$wdate,
						$client,
						get_param($first, 'ev_time'),
						$time);
				}
			}

			if ($last) {
				// И выход за него
				// Но не просто переностим а в зависимости от пола сотрудника (ибо девушки заканчивают работу раньше),
				// дня недели, признака нового режима и текущего времени
				//
				// чтобы не получить что сотрудник вышел в будущем времени

				$base = '16:05:00';
				$A = $wdate >= '2016-04-01';                     // Действуета новый колдоговор
				$W = date('w', strtotime($wdate)) === '5';       // Пятница?  (волшебный день)
				$G = get_param($person, 'gender') === '1';       // Пол сотрудкика (1 - М; 0 - Ж)

				$d = ($A & $W) ? 30 : ((!$W & $G) ? 60 : 0);     // Прибавка к базовой границе

				// Границу, раньше которой не должен выйти сотрудник получим путем прибавления N минут к базовому значению
				$zone = DateTime::createFromFormat('H:i:s', $base)
					->add(DateInterval::createFromDateString("$d minutes"))
					->format('H:i:s');

				// А теперь проверим, вышли ли мы за границу
				$time = get_param($last, 'ev_time');
				if ($time <= $zone) {
					$shift = mt_rand(30, 400);                                          // Сдвиг в секундах
					$time = DateTime::createFromFormat('H:i:s', $zone)
						->add(DateInterval::createFromDateString("$shift seconds"))// + рандомное число секунд
						->format('H:i:s');

					// Проверим что полученное фейковое время не превышает текуще, чтобы в будущее не улететь
					if (date('Y-m-d H:i:s') >= "$wdate $time") {

						$ok *= $this->model->fixEvent(get_param($last, 'keyfile'), get_param($last, 'id'), $time);
						printf("[%s]: \tFIX - [%s] %s %s -> %s\n",
							date('Y-m-d H:i:s'),
							$wdate,
							$client,
							get_param($last, 'ev_time'),
							$time);
					}
				}
			}
		}

		if (!$ok) {
			printf("Ошибки MySQL: %s\n", $this->model->getErrorList());
		}

		$this->model->stopTransaction($ok);

		//$this->render('');
	}

	public function actionVipReload() {

		return;
		$this->render('', false);
		$dStop = DateTime::createFromFormat('Y-m-d', '2016-03-01');
		$oneDay = new DateInterval('P1D');

		$current = new DateTime();

		while ($current >= $dStop) {
			//var_dump($current->format('d.m.Y'));
			$this->actionProtection($current->format('Y-m-d'));
			$current->sub($oneDay);
		}

		var_dump("DONE!");
		$this->render('');
	}
}