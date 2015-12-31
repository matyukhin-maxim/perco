<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-success">
			<div class="panel-heading">
				<i class="glyphicon glyphicon-search"></i>&nbsp;
				<strong>Настройка фильтра</strong>
			</div>
			<div class="panel-body">

				<form action="" id="filter">

					<div class="col-xs-12 col-md-5">
						<div class="row form-group">
							<label class="col-xs-12" for="">Дата :</label>
							<div class="col-xs-6">
								<div class="input-group date dpicker">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar" title="С"></i>
                                </span>
									<input type="text" class="form-control" name="bdate" readonly="true"/>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="input-group date dpicker">
                                <span class="input-group-addon" title="По">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>
									<input type="text" class="form-control" name="edate" readonly="true"/>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xs-12" for="">Время :</label>
							<div class="col-xs-6">
								<div class="input-group date tpicker">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-time" title="С"></i>
                                </span>
									<input type="text" class="form-control" name="btime" readonly="true"/>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="input-group date tpicker">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-time" title="По"></i>
                                </span>
									<input type="text" class="form-control" name="etime" readonly="true"/>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-md-7">

						<div class="col-xs-6">
							<label for="">Сотрудник :</label>
							<input type="text" class="form-control" placeholder="Фамилия" name="lname"/>
							<input type="text" class="form-control" placeholder="Имя" name="fname"/>
							<input type="text" class="form-control" placeholder="Отчество" name="pname"/>
						</div>

						<div class="col-xs-6">
							<div class="row">
								<label>Дополнительные данные :</label>
								<select class="selectpicker col-xs-12" multiple data-live-search="true"
								        title="Цех [не выбран]"
								        data-selected-text-format="count > 3"
								        data-size="10"
								        name="depot[]">
									<?php
									$options = get_param($depots, NULL, []);
									foreach ($options as $item)
										printf("<option>%s</option>\n", $item);
									?>
								</select>
							</div>
							<div class="row clearfix">
								<div class="col-xs-6">
									<input type="text" class="form-control" placeholder="Табельный №" name="tabn"/>
								</div>
								<div class="col-xs-6">
									<select id="action" name="action[]" class="selectpicker form-control" multiple title="Действие">
										<option value="2" selected>Вход</option>
										<option value="1" selected>Выход</option>
									</select>
								</div>
							</div>
							<div class="ro-w">
								<a href="#" class="btn btn-default col-xs-4" title="Сброс" id="reset">
									<i class="glyphicon glyphicon-repeat"></i>
								</a>
								<a href="#" class="btn btn-default col-xs-4 col-xs-offset-4" title="Обновить" id="update">
									<i class="glyphicon glyphicon-refresh"></i>
								</a>
							</div>
						</div>
					</div>
				</form>

			</div> <!-- panel body -->
		</div>

	</div>
</div>
