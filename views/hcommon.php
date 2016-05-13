<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="data:;base64,iVBORw0KGgo=">
	<title><?= $this->title; ?></title>
	<link rel="stylesheet" href="/public/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="/public/css/bootstrap-theme.css"/>
	<link rel="stylesheet" href="/public/css/bootstrap-select.min.css"/>
	<link rel="stylesheet" href="/public/css/bootstrap-datetimepicker.min.css"/>
	<link rel="stylesheet" href="/public/css/jquery-ui.css"/>
	<link rel="stylesheet" href="/public/css/main.css"/>
	<!--[if lt IE 9]>
	<script src="/public/js/lib/html5shiv.min.js"></script>
	<script src="/public/js/lib/respond.min.js"></script>
	<script src="/public/js/lib/es5-shim.js"></script>
	<![endif]-->
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar"
		        aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Переключить</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand strong" href="/">
			<span><?= $brand; ?></span>
		</a>
	</div>
	<div class="pull-right">
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav strong">
				<li><a href="/monitor/">Мониторинг</a></li>
				<li><a href="/user/">Сотрудники</a></li>
				<li><a href="/report/">Построитель отчетов</a></li>
				<!--<li><a href="/about/">Помощь</a></li>-->
			</ul>
		</div>
	</div>

	<div class="container">
		<div class="pull-right col-xs-5">
			<div class="alert text-center strong" id="status-box"></div>
		</div>
	</div>
</nav>

<!-- Begin page content -->
<div class="container wrapper">

	<!-- ajax debug block -->
	<div id="response"></div>