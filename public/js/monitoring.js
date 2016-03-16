/* global moment */

$(function () {

    function update() {
        $.post('/monitor/getdata/', $('#filter').serialize(),
            function (data) {
                $('#monitor > tbody').html(data);
            });
    };
    
    function setDefaults() {
        
        // default values to filter
        
        var dt = moment().format('YYYY-MM-DD');
        $('input[name="bdate"], input[name="edate"]').val(dt);
        $('input[name="btime"]').val('00:00');
        $('input[name="etime"]').val('23:59');

        //$('input[name="bdate"]').val('2015-10-15');

        $('.selectpicker:not(#action)').selectpicker('deselectAll');
    }
    
    $('.dpicker, .tpicker').on('dp.hide', function (e) {
        update();
    });

    var tmr = 0;
    $('[type="text"], [type="checkbox"], .selectpicker').on('keyup change', function () {
        clearTimeout(tmr);
        tmr = setTimeout(function () {
            update();
        }, 1500);
    });
    
    $('#update').click(function () {
        update();
        return false;
    });
    
    $('#reset').click(function () {
        $('#filter').trigger('reset');
        setDefaults();
        update();
        return false;
    });

    setDefaults();
    update();
});

