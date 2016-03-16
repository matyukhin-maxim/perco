<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<table class="table-header">
					<thead>
					<tr>
						<th class="col-sm-2">Дата</th>
						<th class="col-sm-2">Время</th>
						<th class="col-sm-8">Действие</th>
					</tr>
					</thead>
				</table>
			</div>
			<div class="panel-body panel-response">
				<table class="table table-striped table-bordered table-condensed" id="monitor">
					<colgroup>
						<col class="col-xs-2">
						<col class="col-xs-2">
						<col class="col-xs-8">
					</colgroup>
					<tbody>
					<?= get_param($events_rendered); ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>