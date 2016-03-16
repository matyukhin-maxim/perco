/**
 * Created by Матюхин_МП on 09.03.2016.
 */
$(function () {
    var cur = moment();
    var bDate = moment([cur.year(), cur.month()]);
    var eDate = bDate.clone().endOf('month');

    $('[name="bdate"]').val( bDate.format('YYYY-MM-DD'));
    $('[name="edate"]').val( eDate.format('YYYY-MM-DD'));


    $('.show-report').click(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url : '/report/late/',
            data: $('input').serialize(),
            success: function(data) {
                $('#report-response').html(data);
            }
        });
    });
});