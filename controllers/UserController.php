<?php

/** @property UserModel $model */
class UserController extends CController {
    
    public function actionInfo() {

        $this->title .= ': Информация о сотруднике';
        
        $uid = get_param($this->arguments, 0, -1);
        
        $rec = $this->model->getUserInfo($uid);
        if (empty($rec)) {
            $this->scripts[] = 'autoclose';
            $this->render('user-not-found');
            return;
        }

        $this->data['uinfo'] = [
            'Табельный номер' => get_param($rec, 'tabnum'),
            'ФИО' => join(' ', get_array_part($rec, 'lname fname pname')),
            'Цэх' => get_param($rec, 'department'),
            'Должность' => get_param($rec, 'position'),
        ];


        $this->data['imageurl'] = "/user/photo/$uid/";
        $this->render('info',false);

        // формируем массив фильтра для модели мониторинга
        // чтобы выбрать события по текущему сотруднику за последний месяц
        $filter = [
            'bdate' => date('Y-m-d', strtotime('-1 month')),
            'edate' => date('Y-m-d'),
            'btime' => '00:00',
            'etime' => '23:59',
            'tabn'  => get_param($rec, 'tabnum'),
            'action' => [1, 2],
        ];
        
        $monitor = new MonitorModel();
        $this->data['events']  = $monitor->getActions($filter);
        $this->data['events_rendered'] = $this->renderPartial('rowdata');

        $this->render('actions');
        
    }

    public function actionPhoto($newsize = 200) {

        $uid = get_param($this->arguments, 0, -1);
        $rec = $this->model->getUserInfo($uid);
        $blob = get_param($rec, 'photo');

        // создаем картинку динамичски из blob данных пользователя
        // если вдруг формат картинки будет неправильный, спрячем warning
        $im = @imagecreatefromstring($blob);
        if ($im !== false) {
            header('Content-Type: image/jpeg');

            // пропорционально меняем размер картинки
            // привеля большую из сторон к размеру $newsize

            list($width, $height) = getimagesizefromstring($blob);
            $rate = $width > $height ? $width / $newsize : $height / $newsize;
            $wnew = round($width / $rate);
            $hnew = round($height / $rate);

            $resource = imagecreatetruecolor($wnew, $hnew);
            imagecopyresized($resource, $im, 0, 0, 0, 0, $wnew, $hnew, $width, $height);
            imagejpeg($resource);

            imagedestroy($im);
            imagedestroy($resource);
        }
    }

    public function actionIndex() {

        $this->title .= ': Поиск сотрудника';
        $this->data['p_head'] = 'Список сотрудников';
        $this->render('../info', false);

        $this->scripts[] = 'userloader';
        $this->render('user-list');

    }

    public function ajaxGetList() {

        $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);

        $this->data['persons'] = $this->model->getUsers($lname);
        echo $this->renderPartial('user-row');
    }
    
}