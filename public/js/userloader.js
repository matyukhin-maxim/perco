$(function () {

    function showusers() {
        $.post('/user/getlist/', {
                lname: $('#filter').val()
            },
            function (data) {
                $('#users > tbody').html(data);
            });
    };

    var tmr = undefined;
    $('#filter').on('keyup change', function () {
        clearTimeout(tmr);
        tmr = setTimeout(function () {
            showusers();
        }, 500);
    });

    $('#clear').click(function () {
        $('#filter').focus().val('').trigger('change');

        return false;
    });

    showusers();
});