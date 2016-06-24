<?php

/**
 * Created by PhpStorm.
 * User: Матюхин_МП
 * Date: 16.05.2016
 * Time: 8:32
 */
class AuthController extends CController {

	public function actionIndex() {

		$this->actionOpenID();
	}

	public function actionOpenID() {

		Session::destroy(true);

		$secure = get_param($this->arguments, 0);
		$message = '';
		$this->render('', false);
		//var_dump($secure, PASSKEY);

		if (!$secure) $message = 'Отсутствуют авторизационные данные';
		else {
			// иначе - расшифровываем
			$plain = Cipher::decode($secure, PASSKEY);
			//var_dump($plain);
			if (!$plain) $message = 'Ошибка при расшифровке данных.';
			else {

				// Проверка срока годности
				$dt = new DateTime();
				$dt->add(DateInterval::createFromDateString('5 minutes'));

				$expire = get_param($plain, 1) > $dt->format('Y-m-d H:i');
				$uid = get_param($plain, 0);

				//if ($expire) $message = 'Срок авторизации истек. Попробуйте еще раз.';

				if ($uid) {
					Session::set('auth', [
						'id' => $uid,
						'fullname' => get_param($plain, 2),
					]);
				}
			}
		}

		$this->data['error'] = $message;
		$this->render('info', false);

		$this->redirect([
			'location' => '/',
			'soft' => intval(!empty($message)),
			'delay' => 10,
		]);

		$this->render('');
	}

	public function actionExit() {

		Session::destroy();
		$this->redirect();
	}
}