<?php


//    'mysql' => [
//        'host' => '172.28.120.39',
//        'user' => 'matyukhin',
//        'pass' => 'ksTg3276sm@',
//        'base' => 'perco',
//    ],


class Configuration {

	public static $connection = [
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'fell1x',
		'base' => 'perco',
	];

	public static $scriptList = [
		'lib/jquery.min',
		'lib/jquery-ui.min',
		'lib/jquery.cookie',
		'lib/bootstrap.min',
		'lib/moment.min',
		'lib/i18n/moment-ru',               // rus moment.js
		'lib/bootstrap-select.min',
		'lib/bootstrap-datetimepicker.min', // date & time picker
		'lib/i18n/defaults-ru_RU',          // rus selectpicker
		'lib/ie10-viewport-bug-workaround', // IE10 viewport hack for Surface/desktop Windows 8 bug
		'common',
	];

	public static $dbpath = '/mnt/prohod/Baza';

	public static $siteName  = 'Сервер проходной';
	public static $brandName = 'PERCo.';

}