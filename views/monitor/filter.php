<div class="row">

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
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar" title="С"></i>
                                </span>
                                <input type="text" class="form-control" name="bdate"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon" title="По">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>
                                <input type="text" class="form-control" name="edate"/>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-xs-12" for="">Время :</label>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-time" title="С"></i>
                                </span>
                                <input type="text" class="form-control" name="btime"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-time" title="По"></i>
                                </span>
                                <input type="text" class="form-control" name="etime"/>
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
                        <label for="">Дополнительные данные :</label>
                        <select class="selectpicker" multiple data-live-search="true" 
                                title="Цех [не выбран]" 
                                data-selected-text-format="count > 3"
                                data-size="10"
                                data-width="100%"
                                name="depot[]">
                            <?php
                                $options = get_param($depots, NULL, []);
                                foreach ($options as $item)
                                    printf("<option>%s</option>\n", $item);
                            ?>
                        </select>
                        <input type="text" class="form-control" placeholder="Табельный номер" name="tabn"/>
                        <a href="#" class="btn btn-default col-xs-4" title="Сброс" id="reset">
                            <i class="glyphicon glyphicon-repeat"></i>
                        </a>
                        <a href="#" class="btn btn-default col-xs-4 col-xs-offset-4" title="Обновить" id="update">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                    </div>

                </div>

            </form>

        </div> <!-- panel body -->
    </div>

</div>