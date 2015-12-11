/* global moment */

$(function() {

    var ctrl = window.location.pathname.split('/')[1];
    if (ctrl.length) $('a[href*="' + ctrl + '"]').parent('li').addClass('active');
    
    moment.locale('ru');

    var dt = moment().format('YYYY-MM-DD');
    $('#bdate, #edate').val(dt);

    $('.dpicker').datetimepicker({
        format: 'YYYY-MM-DD',
        ignoreReadonly: true
    });

    $('.tpicker').datetimepicker({
        format: 'LT',
        ignoreReadonly: true
    });

});
