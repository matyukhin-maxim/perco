function showPopup() {

    var message = $.cookie('status');
    var type    = $.cookie('class') || 'danger';

    $.removeCookie('status', {path: '/'});
    $.removeCookie('class' , {path: '/'});

    if (message) $.bootstrapGrowl(message, {type: type});
}

$(function() {

    var ctrl = window.location.pathname.split('/')[1];
    if (ctrl.length) $('a[href*="' + ctrl + '"]').parent('li').addClass('active');

    moment.locale('ru');

    $.bootstrapGrowl.default_options.delay = 5000;

    $.ajaxSetup({
        complete: function() { showPopup(); }
    });
	
	$('a.disabled').click(function (e) {
        e.preventDefault();
    });
	
	$('.modal').on('hide.bs.modal', function (e) {
        $(this).removeData('bs.modal');
    });

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

    // блок с информаций об отделе
    $('#asu-info').click(function() {
        $('#info-block').slideToggle('slow');
    });

    // Блок с mysql ошибками
    $('#status-text:not(:empty)').closest('#status-footer').show();

    $('.selectpicker').selectpicker({
        dropupAuto : false
    });

    // подсказки для кнопок, текст которых может свернуться на мелких экранах
    $('.btn-group-justified .btn').each(function () {
        var self = $(this);
        self.attr('title', $.trim(self.text()));
    });

    $('[data-toggle="popover"]').popover();

    showPopup();
});
