$(function () {

    function update() {
        $.post('/monitor/getdata/', $('#filter').serialize(),
            function (data) {
                $('#monitor > tbody').html(data);
            });
    };

    var tmr = undefined;
    $('input[type="text"], select').on('keyup change', function () {
        clearTimeout(tmr);
        tmr = setTimeout(function () {
            update();
        }, 1500);
    });
    
    $('a').click(function () {
        update();
        return false;
    });

    update();
});

