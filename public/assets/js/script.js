$(document).ready(function($)
{

    $('.table_data').DataTable({

            "language": {
                "lengthMenu": "Afficher _MENU_ données par pages",
                "zeroRecords": "Nous n'avons rien trouvé - désolé",
                "info": " page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun enregistrement disponibles",
                "infoFiltered": "(Filtrer à partir de _MAX_ enregistrement)",
                "search":"Rechercher:",
                "paginate": {
                    "first":      "Premier",
                    "last":       "Dernier",
                    "next":       "Suivant",
                    "previous":   "Précedent"
                },
            }
        }
    );

    $('.excel_show').html();
});

