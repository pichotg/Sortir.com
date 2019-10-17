$(document).ready( function () {
    moment.locale('fr');
    $('#sorties_datedebut').datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        useCurrent: false,
        widgetPositioning : {
            horizontal: 'auto',
            vertical: 'top',
        },
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
        } 
    });
    $('#sorties_datecloture').datetimepicker({
        format: 'YYYY/MM/DD',
        useCurrent: false,
        widgetPositioning : {
            horizontal: 'auto',
            vertical: 'top',
        },
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
        } 
    });

    $("#sorties_datecloture").on("change.datetimepicker", function (e) {
        $('#sorties_datedebut').datetimepicker('minDate', e.date);
    });
    $("#sorties_datedebut").on("change.datetimepicker", function (e) {
        $('#sorties_datecloture').datetimepicker('maxDate', e.date);
    });
});