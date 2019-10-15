$(document).ready( function () {

    // Need for input file generated with Form
    bsCustomFileInput.init();

    let table = $('table').DataTable({
        'searching': true,
        'paging': false,
        'info': false,
        'language': {
            "sEmptyTable":     "Aucune donnée disponible dans le tableau",
            "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     "Afficher _MENU_ éléments",
            "sLoadingRecords": "Chargement...",
            "sProcessing":     "Traitement...",
            "sSearch":         "Rechercher :",
            "sZeroRecords":    "Aucun élément correspondant trouvé",
            "oPaginate": {
                "sFirst":    "Premier",
                "sLast":     "Dernier",
                "sNext":     "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
            },
            "select": {
                "rows": {
                    "_": "%d lignes sélectionnées",
                    "0": "Aucune ligne sélectionnée",
                    "1": "1 ligne sélectionnée"
                }
            }
        }
    });

    $('#tableUser').on('click', 'tr', function () {
        let id = $('td', this).eq(1).text();
        let pseudo = $('td', this).eq(2).text();
        let nom = $('td', this).eq(3).text();
        let prenom = $('td', this).eq(4).text();
        let telephone  = $('td', this).eq(5).text();
        let mail  = $('td', this).eq(6).text();
        let campus  = $('td', this).eq(7).text();
        let actif  = $('td', this).eq(8).data('value');

        $('h5.modal-title').html(nom + ' ' + prenom + ' (' + pseudo + ')');

        $('input[name="participants[id]"]').val(id);
        $('#participants_pseudo').val(pseudo);
        $('#participants_nom').val(nom);
        $('#participants_prenom').val(prenom);
        $('#participants_telephone').val(telephone);
        $('#participants_mail').val(mail);
        $('option').each(function () {
            if($(this).html() === campus){
                $(this).attr('selected', true);
            }
        });
        if(actif === 1){
            $('#participants_actif').val(1);
            $('#participants_actif').attr('checked','checked');
        } else {
            $('#participants_actif').val(0);
            $('#participants_actif').removeAttr('checked');
        }

        $('#modalUser').modal("show");
    });

    $('#confirmDeleteBtn').click(function () {
        $('#modalUser').modal("hide");
        $('#modalConfirmDelete').modal("show");
    });

    $('#modalConfirmDelete').on('hidden.bs.modal', function () {
        $('#modalUser').modal("show");
    });

} );