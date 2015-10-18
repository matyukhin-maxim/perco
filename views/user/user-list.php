<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="input-group">
                    <span class="input-group-addon white-bg">
                        <i class="glyphicon glyphicon-search"></i>
                    </span>
                    <input type="text" autofocus="true" class="form-control col-xs-11"
                           placeholder="Фильтр по фамилии..." id="filter"/>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"
                                id="clear" title="Очистить">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="panel-body panel-response">
                <table class="table table-striped table-condensed" id="users">
                    <colgroup>
                        <col class="col-xs-2">
                        <col class="col-xs-8">
                        <col class="col-xs-2">
                    </colgroup>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>