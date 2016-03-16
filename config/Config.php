<?php

class Configuration {

	public static $connection = [
		'base' => 'perco',

		//'host' => 'localhost',
		'host' => '172.28.120.39',
//		'host' => '172.28.122.24',

		//'user' => 'root',
		'user' => 'matyukhin',
//		'user' => 'max',

		'pass' => 'ksTg3276sm@',
		//'pass' => 'fell1x',
		//'pass' => 'maxmax0',
	];

	public static $scriptList = [
		'lib/jquery.min',
		'lib/jquery-ui.min',
		'lib/jquery.cookie',
		'lib/bootstrap.min',
		'lib/moment.min',
		'lib/i18n/moment-ru',               // rus moment.js
		'lib/bootstrap-select.min',
		'lib/jquery.bootstrap-growl.min',    // bootstrap pretty popups
		'lib/bootstrap-datetimepicker.min', // date & time picker
		'lib/i18n/defaults-ru_RU',          // rus selectpicker
		'lib/ie10-viewport-bug-workaround', // IE10 viewport hack for Surface/desktop Windows 8 bug
		'common',
	];

	public static $siteName = 'Проходная НГРЭС';
	public static $brandName = 'Мониторинг проходной';

	public static $dbpath = '/mnt/prohod/Baza/';
}