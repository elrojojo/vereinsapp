function Termine_PersonenkreisBeschraenkenLoeschen( $btn, liste ) {

    const $personenkreis_beschraenken = $btn.parents('.personenkreis_beschraenken').first();
    const element_id = $personenkreis_beschraenken.attr('data-element_id');
    const $element = $btn.parents('.personenkreis_beschraenken_element').first();
    const $sammlung = $btn.parents('.personenkreis_beschraenken_sammlung').first();

    let $knoten; if( $element.exists() ) { $knoten = $element; } else  $knoten = $sammlung;
    let $knoten_parallel = $knoten.siblings('.personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung');
    let $sammlung_ebene_hoeher = $knoten.parents('.personenkreis_beschraenken_sammlung').first();

    $knoten.remove();
    while( $knoten_parallel.length == 1 ) {

        const $knoten_ebene_hoeher = $sammlung_ebene_hoeher.siblings('.personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung');
        $sammlung_ebene_hoeher.replaceWith( $knoten_parallel )
        $knoten_parallel = $knoten_ebene_hoeher;
        $sammlung_ebene_hoeher = $knoten_parallel.first().parents('.personenkreis_beschraenken_sammlung').first();
        // sammlung_ebene_hoeher = $knoten_parallel.first().parents('.personenkreis_beschraenken_sammlung').first();

    }
    const filtern_mitglieder = $personenkreis_beschraenken2filtern_mitglieder( $personenkreis_beschraenken, 'mitglieder' );
    const AJAX_DATA = { id: element_id, filtern_mitglieder: JSON.stringify( filtern_mitglieder ) };

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue( {

        url: BASE_URL+'/'+liste+'/ajax_termin_personenkreis_beschraenken', method: 'post',
        data: AJAX_DATA, dataType: 'json',
        beforeSend: function() { $btn.addClass('invisible').prop( 'disabled', true ).after(STATUS_SPINNER_HTML); },
        success: function(antwort) {

            $('#csrf_hash').val(antwort.csrf_hash);

            if( typeof antwort.validation !== 'undefined' ) console.log( 'FEHLER personenkreis beschraenken: validation -> '+JSON.stringify(antwort.validation) );
            else {

                if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );

                LISTEN[ liste ].tabelle[ element_id ].filtern_mitglieder = filtern_mitglieder;

                $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );

            }
        },
        error: function(xhr) { console.log( 'FEHLER personenkreis beschraenken: ' + xhr.status + ' ' + xhr.statusText); },
        complete: function() { $btn.removeClass('invisible').prop( 'disabled', false ); $btn.siblings( '.'+STATUS_SPINNER_CLASS ).remove(); },

    } );

}