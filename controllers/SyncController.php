<?php

/** @property SyncModel $model */
class SyncController extends CController {
    
    public $path;
    private $cnt_sync_month = 2; // Количество месяцев для выполнения синхронизации событий
    
    public function __construct() {
        parent::__construct();
        
        $this->path = get_param(CController::$cfg, 'dbpath', '/');
    }


    public function actionIndex() {

        $this->render('', false);
        
        $this->syncEvents(date('Y-m-d'));
        //$this->syncUsers();

        $this->render('');
        
    }
    
    public function syncUsers() {

        if (!CModel::isConnected()) return false;
        
        try {
            $pdb = new ParadoxDB($this->path . "STAFF/STAFF.DB", true);
        } catch (Exception $ex) {
            printf("Paradox Error: <strong>%s</strong> <br/>\n", $ex->getMessage());
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
                'tabn'  => d2u(get_param($record, 'TabelId')),
                'dep'   => d2u(get_param($record, 'SubdivId')),
                'pos'   => d2u(get_param($record, 'AppointId')),
                'pic'   => get_param($record, 'Portret'),
                'del'   => 0,
            ];

            $ok *= $this->model->runStatement($params, 'person');
        }

        $this->model->stopTransaction($ok);

        printf ("[%s]: Sync user table %s\n", date('Y-m-d H:i:s'), $ok ? 'done' : 'fail');
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
                printf("Paradox Error: <strong>%s</strong> <br/>\n", $ex->getMessage());
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
                        'key'  => $key,
                        'id'   => get_param($data, 'ID'),
                        'date' => $mdate,
                        'time' => gmdate('H:i:s', get_param($data, 'EV_TIME', 0)),
                        'type' => get_param($data, 'EV_ADRADD'), // 2-вход; 1-выход
                        'uid'  => get_param($data, 'PERSONID'),
                    ];

                    $ok *= $this->model->runStatement($params, 'event');
                }

                $this->model->stopTransaction($ok);
                

                if ($delta > 0) {
	                printf("[%s]: Sync %s table %s. %d record append.\n", date('Y-m-d H:i:s'), $fname, $ok ? 'done' : 'fail', $delta);
	                if (php_sapi_name() !== 'cli') echo "<br/>";
                }
                $pdb->closeDB();
            }

            $starttime = strtotime("-1 month", $starttime);
        }

        return true;
    }

    public function actionCli() {
        // Метод вызываемый при работе из консоли (cron)
        // Делаем то же самое что и при actionIndex, но добавим вывол в лог
        // и "умную" синхронизацию пользоватеелй

        // синхронизируем события за последние 2 месяца
        $this->syncEvents(date('Y-m-d'));

        // если нужно, то и юзеров
        if ($this->model->isUserSyncNeeded()) {
            $this->syncUsers();
        }

    }
}