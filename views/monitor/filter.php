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

                    <div class="row form-group">
                        <label for="" class="col-xs-12">Сотрудник :</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control" placeholder="Фамилия" name="lname"/>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" placeholder="Имя" name="fname"/>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" placeholder="Отчество" name="pname"/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-6">
                            <!--<input type="text" class="form-control" placeholder="Цех" name="depatrment"/>-->
                            
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" placeholder="Табельный номер" name="tabn"/>
                        </div>
                    </div>

                </div>

                
                <select class="selectpicker" multiple data-live-search="true" 
                        title="Цех" 
                        data-selected-text-format="count > 3"
                        data-size="15"
                        name="depot[]">
                    <option value="1">Mustard</option>
                    <option>Ketchup</option>
                    <option>Relish</option>
                    <option>123331dsdf</option>
                    <option>qweqweqw</option>
                </select>
            </form>

        </div> <!-- panel body -->
    </div>

</div>