$(function () {

    /*
    $.post('/monitor/getdata/', $('#filter').serialize(),
            function (data) {
                //console.log(data);
                $('#monitor > tbody').html(data);
            });
    */

    var tmr = undefined;
    $('input[type="text"]').on('keyup change', function () {
        clearTimeout(tmr);
        tmr = setTimeout(function () {
            $.post('/monitor/getdata/', $('#filter').serialize(),
                function (data) {
                    $('#monitor > tbody').html(data);
                });
        }, 1500);
    });
    
    $('input[name="fname"]').trigger('change');
});

