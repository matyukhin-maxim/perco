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
						<div class="row">

							<div class="col-xs-6">
								<label for="">Сотрудник :</label>
								<input type="text" class="form-control" placeholder="Фамилия" name="lname"/>
								<input type="text" class="form-control" placeholder="Имя" name="fname"/>
								<input type="text" class="form-control" placeholder="Табельный номер" name="tabn"/>
							</div>

							<div class="col-xs-6">
								<div class="row">
									<label>Дополнительные данные :</label>
									<select class="selectpicker form-control" multiple data-live-search="true"
									        title="Цех [ ВСЕ ]"
									        data-selected-text-format="count > 3"
									        data-size="10"
									        name="depot[]">
										<?= $options; ?>
									</select>
								</div>

								<div class="row">
									<div class="btn-group btn-group-justified" data-toggle="buttons">
										<label class="btn btn-default active">
											<input type="checkbox" autocomplete="off" name="action[]" value="2" checked>
											Вход
										</label>
										<label class="btn btn-default active">
											<input type="checkbox" autocomplete="off" name="action[]" value="1" checked>
											Выход
										</label>
									</div>
								</div>

								<div class="row">
									<a href="#" class="btn btn-default col-xs-6" title="Сброс" id="reset">
										<i class="glyphicon glyphicon-repeat"></i>
										Сброс фильтра
									</a>
									<a href="#" class="btn btn-default col-xs-6" title="Обновить" id="update">
										<i class="glyphicon glyphicon-refresh"></i>
										Обновить
									</a>
								</div>

							</div>
						</div>
					</div>
				</form>

			</div> <!-- panel body -->
		</div>

	</div>
</div>
