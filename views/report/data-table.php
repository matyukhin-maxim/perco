<div class="panel panel-default">
	<div class="panel-heading">
		<table class="table-header">
			<thead>
			<tr>
				<th class="col-xs-1">Дата</th>
				<th class="col-xs-1">Время</th>
				<th class="col-xs-1">ТАБ №</th>
				<th class="col-xs-5">Сотрудник</th>
				<th class="col-xs-3">Отдел</th>
				<th class="col-xs-1">Действие</th>
			</tr>
			</thead>
		</table>
	</div>
	<div class="panel-body" id="report--response">
		<table class="table table-hover text-center table-bordered table-condensed no-pad">
			<colgroup>
				<col class="col-xs-1">
				<col class="col-xs-1">
				<col class="col-xs-1">
				<col class="col-xs-5">
				<col class="col-xs-3">
				<col class="col-xs-1">
			</colgroup>
			<tbody id="report-response"><?= $report; ?></tbody>
		</table>
	</div>
</div>