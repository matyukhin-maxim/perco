/* global moment */

$(function() {

    var ctrl = window.location.pathname.split('/')[1];
    if (ctrl.length) $('a[href*="' + ctrl + '"]').parent('li').addClass('active');
    
    moment.locale('ru');

});
