<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="glyphicon glyphicon-cog"></i>&nbsp;
				Настройки отчета
			</div>
			<div class="panel-body">
				<form target="_blank" action="/report/save/" method="post">
					<div class="row">
						<div class="col-xs-4">
							<label for="bdate">Дата с:</label>
						</div>
						<div class="col-xs-4">
							<label for="edate">Дата по:</label>&nbsp;
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<input class="form-control dpicker" type="text" name="bdate" id="bdate" readonly/>
						</div>
						<div class="col-xs-4">
							<input class="form-control dpicker" type="text" name="edate" id="edate" readonly/>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
							<button class="btn btn-primary btn-group-justified" type="submit">
								<i class="glyphicon glyphicon-download-alt"></i>
								<span class="hidden-xs">Сформировать</span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>