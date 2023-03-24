

$(document).ready( function() {






    // CHECKS IM DOM AKTUALISIEREN
    $(document).on( 'VAR_upd_DOM', function( event, prio_liste ) { const todo = new Array();
        if( prio_liste in LISTEN ) {
            todo.push( prio_liste );
            $.each( Object.keys( LISTEN ), function( index, liste) { if( liste != prio_liste ) todo.push( liste ); } );
        }
        $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ];

            // CHECK AKTUALISIEREN
            $( '.check[name="'+liste+'"]' ).each( function() {
                const $check = $(this); const $liste = $check.parents('.liste').first(); const $element = $check.parents('.element').first();
                let checked = false;

                $.each( LISTE.tabelle, function() { const element = this; if( 'id' in element ) {
                    if( element[ $liste.attr('data-gegen_element')+'_id' ] == Number( $liste.attr('data-gegen_element_id') ) && element[ $element.attr('data-element')+'_id' ] == Number( $check.val() ) ) checked = true;
                } } ); $check.attr( 'checked', checked );

            } );

        } );

    } );

    // CHECK_LISTE ÄNDERN
    $(document).on("change", ".check" , function() {
        const $check = $(this); const $check_beschriftung = $check.siblings('.beschriftung'); const check_beschriftung = $check_beschriftung.html();
        const $liste = $check.parents('.liste').first(); const aktion = $liste.attr('data-aktion');

        const liste = $liste.attr('data-liste'); const LISTE = LISTEN[ liste ]; const element = LISTE.element; const element_id = $check.val();
        const check_liste = $liste.attr('data-check_liste'); const CHECK_LISTE = LISTEN[ check_liste ]; const check_element = CHECK_LISTE.element;
        const gegen_element = $liste.attr('data-gegen_element'); const gegen_element_id = $liste.attr('data-gegen_element_id');

        const AJAX_DATA = { checked: $check.is(':checked') };
        AJAX_DATA[ element+'_id' ] = element_id;
        AJAX_DATA[ gegen_element+'_id' ] = gegen_element_id;

        // AJAX IN DIE SCHLANGE
        $.ajaxQueue( {
            url: BASE_URL+'/'+CHECK_LISTE.controller+'/ajax_'+check_element+'_'+aktion, method: 'post',
            data: AJAX_DATA, dataType: 'json',
            beforeSend: function() { $check_beschriftung.html( STATUS_SPINNER_HTML ).addClass('text-primary') },
            success: function(antwort) { $('#csrf_hash').val(antwort.csrf_hash);
                if( typeof antwort.validation !== 'undefined' ) console.log( 'FEHLER '+element+' '+aktion+': validation -> '+JSON.stringify(antwort.validation) );
                else { if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );
                    if( CSRF_NAME in AJAX_DATA ) delete AJAX_DATA[ CSRF_NAME ];
                    $.each( CHECK_LISTE.tabelle, function() { const element = this; if( 'id' in element ) {
                        if( element[ LISTE.element+'_id' ] == element_id && element[ gegen_element+'_id' ] == gegen_element_id ) delete CHECK_LISTE.tabelle[ element['id'] ];
                    } } );
                    if( AJAX_DATA.checked ) { AJAX_DATA['id'] = CHECK_LISTE.tabelle.length+1; CHECK_LISTE.tabelle[ AJAX_DATA['id'] ] = new Object();
                        delete AJAX_DATA.checked;
                        $.each( AJAX_DATA, function( eigenschaft, wert ) {
                            if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
                            CHECK_LISTE.tabelle[ AJAX_DATA['id'] ][ eigenschaft ] = wert;
                        } );
                    }
                    $(document).trigger( 'VAR_upd_LOC', [ check_liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );
                }
            },
            error: function(xhr) { console.log( 'FEHLER '+element+' '+aktion+': ' + xhr.status + ' ' + xhr.statusText); },
            complete: function() { $check_beschriftung.html( check_beschriftung ).removeClass('text-primary'); },
        } );
    } );

} );
