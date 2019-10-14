$(document).ready( function () {

    // Need for input file generated with Form
    bsCustomFileInput.init();

    let table = $('table').DataTable({
        'searching': true,
        'paging': false,
        'info': false
    });

} );