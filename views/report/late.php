<form action="" method="post">

	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading strong">
					<i class="glyphicon glyphicon-cog"></i>&nbsp;
					Отчет по опоздавшим сотрудникам
				</div>
				<div class="panel-body">
					<div class="row form-group">
						<div class="col-sm-6">
							<div class="col-xs-4 control-label text-right">Дата с:</div>
							<div class="col-xs-8">
								<div class="input-group dpicker">
									<input type="text" class="form-control" name="bdate" readonly>
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								</span>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="col-xs-4 control-label text-right">Дата по:</div>
							<div class="col-xs-8">
								<div class="input-group dpicker">
									<input type="text" class="form-control" name="edate" readonly>
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row form--group">
						<!--						ЦЕХА-->
					</div>
				</div>
				<div class="panel-footer clearfix">
					<div class="pull-left">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-default active btn-check">
								<i class="glyphicon glyphicon-ok"></i>
								<input name="split" type="checkbox" autocomplete="off" checked> Разбить по цехам
							</label>
						</div>
					</div>
					<div class="pull-right">
						<div class="btn-group strong">
							<button type="button" class="btn btn-default show-report">Сформировать</button>
							<button type="submit" class="btn btn-primary strong" formtarget="_blank">Сохранить</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</form>