$(document).ready( function () {

    let mediaTable = $('#mediaTable').DataTable({
        'searching': false,
    });

    $('#playMediaModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let name = button.data('name');
        let type = button.data('type');
        let path = button.data('path');

        var modal = $(this);
        modal.find('.modal-title').html(name);
        if(type == 'Audio'){
            modal.find('.modal-body').html('<audio class="w-100" controls><source src="' + path + '" type="audio/mp3">Your browser does not support the audio element.</audio>');
        } else if (type == 'Video') {
            modal.find('.modal-body').html('<video class="w-100" width="320" height="240" controls><source src="' + path + '" type="audio/ogg">Your browser does not support the video element.</video>');
        }
    })

} );