const LISTEN = new Object();

$(document).ready( function() {

    $.each( LISTEN, function( liste, LISTE ) {

        LOC_upd_VAR( liste );

        LISTE.$blanko_auswertung = new Object();
        $( '.auswertungen[data-liste="'+liste+'"]' ).find('.blanko').each( function() { const $blanko_auswertung = $(this);
            LISTE.$blanko_auswertung[ $blanko_auswertung.parent().attr('id') ] = $blanko_auswertung;
        } ); $( '.auswertungen[data-liste="'+liste+'"]' ).empty();
    
        LISTE.$blanko_element = new Object();
        $( '.liste[data-liste="'+liste+'"]' ).find('.blanko').each( function() { const $blanko_element = $(this);
            LISTE.$blanko_element[ $blanko_element.parent().attr('id') ] = $blanko_element;
        } ); $( '.liste[data-liste="'+liste+'"]' ).empty();

        $(document).trigger( 'SQL_upd_LOC', [ true, liste ] ); // $(document).trigger( 'LOC_upd_VAR' );
    
    } );

    $(document).trigger( 'VAR_upd_DOM' );

    // LISTE UND ELEMENT IM DOM AKTUALISIEREN
    $(document).on( 'VAR_upd_DOM', function( event, prio_liste ) { const todo = new Array();
        if( prio_liste in LISTEN ) {
            todo.push( prio_liste );
            $.each( Object.keys( LISTEN ), function( index, liste) { if( liste != prio_liste ) todo.push( liste ); } );
        }
        $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ];

            // LISTE AKTUALISIEREN
            $( '.liste[data-liste="'+liste+'"]' ).each( function() { const $liste = $(this);

                // TABELLE FILTERN
                let filtern = $liste.attr('data-filtern'); if( typeof filtern !== 'undefined' ) filtern = phpfiltern2filtern( JSON.parse( filtern ), liste ); else filtern = new Array();
                if( LISTE.filtern.length >= 1 ) filtern = [ { verknuepfung: '&&', filtern: filtern.concat( LISTE.filtern ) } ];
                const tabelle_gefiltert = tabelle_filtern( filtern, liste );
                
                // TABELLE SORTIEREN
                let sortieren = $liste.attr('data-sortieren'); if( typeof sortieren !== 'undefined' ) sortieren = JSON.parse( sortieren ); else sortieren = new Array();
                if( LISTE.sortieren.length >= 1 ) sortieren = LISTE.sortieren.concat( sortieren );
                const tabelle_gefiltert_sortiert = array_sortieren( tabelle_gefiltert, sortieren );

                // DOM LÖSCHEN
                $liste.find( '.element[data-element="'+LISTE.element+'"]' ).each( function() { const $element = $(this);
                    if( !tabelle_gefiltert_sortiert.includes( LISTE.tabelle[ Number( $element.attr('data-element_id') ) ] ) ) $element.remove();
                } );
                
                // DOM ERGÄNZEN
                $.each( tabelle_gefiltert_sortiert, function( position, element) { const element_id = element['id']; const $element = $liste.find( '.element[data-element="'+LISTE.element+'"][data-element_id="'+element_id+'"]' );
                    if( !$element.exists() ) {
                        const $neues_element = LISTE.$blanko_element[ $liste.attr('id') ].clone().removeClass('blanko invisible').addClass('element').attr( 'data-element', LISTE.element ).attr( 'data-element_id', element_id );
                        
                        // Werkzeugkasten
                        $neues_element.find('[data-bs-target="#werkzeugkasten_"]').attr( 'data-bs-target', '#werkzeugkasten_'+LISTE.element+'_'+element_id );
                        $neues_element.find('#werkzeugkasten_').attr( 'id', 'werkzeugkasten_'+LISTE.element+'_'+element_id ).attr( 'data-bs-parent', '.liste[data-liste="'+liste+'"]');
                        
                        // link
                        $neues_element.find('a.stretched-link').attr( 'href', $neues_element.find('.stretched-link').attr('href')+'/'+element_id );

                        // check
                        $neues_element.find('label').attr( 'for', element_id );
                        $neues_element.find('.check').attr( 'id', element_id ).val( element_id );

                        if( position == 0 ) $neues_element.appendTo( $liste );
                        else $neues_element.insertAfter( $liste.find( '.element[data-element="'+LISTE.element+'"][data-element_id="'+tabelle_gefiltert_sortiert[ position-1 ]['id']+'"]') );
                    }
                } );

                // DOM SORTIEREN
                $.each( tabelle_gefiltert_sortiert, function( position, element) { const element_id = element['id']; const $element = $liste.find( '.element[data-element="'+LISTE.element+'"][data-element_id="'+element_id+'"]' );
                    if( position == 0 ) $element.appendTo( $liste );
                    else $element.insertAfter( $liste.find( '.element[data-element="'+LISTE.element+'"][data-element_id="'+tabelle_gefiltert_sortiert[ position-1 ]['id']+'"]') );
                } );

                // LETZTEN SPACER AUS DER LISTE LÖSCHEN
                const $letztes_element = $liste.children().last();
                if( $letztes_element.children().last().hasClass('spacer') ) $letztes_element.children().last().remove();

                // ÜBERSCHRIFTEN EIN-/AUSBLENDEN
                if ( $liste.children().length == 0 ) $liste.prev('.ueberschrift[data-liste_id="'+$liste.attr('id')+'"]').addClass('invisible');
                else $liste.prev('.ueberschrift[data-liste_id="'+$liste.attr('id')+'"]').removeClass('invisible');

            } );

            // ELEMENT AKTUALISIEREN
            $( '.element[data-element="'+LISTE.element+'"]' ).each( function() { const $element = $(this); const element_id = Number( $element.attr('data-element_id') );

                // EIGENSCHAFTEN AKTUALISIEREN
                $element.find('.eigenschaft').each( function() { const $eigenschaft = $(this);
                    const eigenschaft = $eigenschaft.attr('data-eigenschaft');
                    $eigenschaft.text( wert_formatieren( LISTE.tabelle[ element_id ][ eigenschaft ], eigenschaft, liste ) );
                } );

                // ZUSATZSYMBOLE AKTUALISIEREN
                $element.find('.zusatzsymbol').each( function() { const $zusatzsymbol = $(this); $zusatzsymbol.empty();
                    const zusatzsymbol = $zusatzsymbol.attr('data-zusatzsymbol');
                    if( zusatzsymbol == 'geburtstag' && LISTE.tabelle[ element_id ].geburtstag <= DateTime.now() && DateTime.now() <= LISTE.tabelle[ element_id ].geburtstag.plus( { days: 1 } ) ) $zusatzsymbol.html( SYMBOLE['geburtstag']['html'] );
                    if( zusatzsymbol == 'abwesend' && LISTE.tabelle[ element_id ].abwesend ) $zusatzsymbol.html( SYMBOLE['abwesend']['html'] );
                    if( zusatzsymbol == 'kategorie' ) $zusatzsymbol.html( VORGEGEBENE_WERTE[ liste ]['kategorie'][ LISTE.tabelle[ element_id ].kategorie ]['symbol'] );
                } );

                // LETZTEN SPACER AUS DER VORSCHAU LÖSCHEN
                const $letztes_vorschau_element = $element.find('.vorschau').children().last();
                if( $letztes_vorschau_element.hasClass('spacer') ) $letztes_vorschau_element.remove();

            } );

            $(document).trigger('VAR_upd_DOM_'+liste);

            //console.log( 'ERFOLG VAR_upd_DOM_'+liste );
        } );
    } );

    // ELEMENT ERSTELLEN
    $(document).on("click", ".btn_element_erstellen" , function() {
        const $btn = $(this); const btn_beschriftung = $btn.html(); const aktion = $btn.attr('data-aktion'); const $formular = $btn.parents('.formular').first();
        const element = $btn.attr('data-element'); const element_id = $btn.attr('data-element_id');
        let liste; $.each( LISTEN, function( liste_, LISTE_ ) { if( element == LISTE_.element ) liste = liste_; } );
        const LISTE = LISTEN[ liste ];
    
        const AJAX_DATA = new Object;
        if( typeof element_id !== 'undefined' ) AJAX_DATA.id = element_id;
        const data_werte = $btn.attr('data-werte'); if( typeof data_werte !== 'undefined' ) $.each( JSON.parse( data_werte ), function( eigenschaft, wert ) {
            AJAX_DATA[ eigenschaft ] = wert;
        } );

        // WERTE AUS DEM FORMULAR
        $formular.find('.eigenschaft').each( function() { const $eigenschaft = $(this); const eigenschaft = $eigenschaft.attr('data-eigenschaft'); let wert = $eigenschaft.val();
            if( $eigenschaft.attr('type') == 'date' ) {
                wert = DateTime.fromISO( wert );
                if( eigenschaft == 'ende' ) { wert = wert.plus( { days: 1 } ).minus( { seconds: 1 } ); }
                wert = wert.toFormat( SQL_DATETIME );
            }
            else if( $eigenschaft.attr('type') == 'time' ) {
                if( typeof AJAX_DATA[ eigenschaft ] !== 'undefined ') wert = DateTime.fromFormat( AJAX_DATA[ eigenschaft ], SQL_DATETIME ).toFormat( SQL_DATE ) + ' '+DateTime.fromISO( wert ).toFormat( SQL_TIME )
                else wert = DateTime.fromISO( wert ).toFormat( SQL_DATETIME );
            }
            AJAX_DATA[ eigenschaft ] = wert;
            $eigenschaft.removeClass( 'is-valid' ).removeClass( 'is-invalid' );
            $eigenschaft.find('.invalid-tooltip').remove();
        } );

        // AJAX IN DIE SCHLANGE
        $.ajaxQueue( {
            url: BASE_URL+'/'+LISTE.controller+'/ajax_'+element+'_'+aktion, method: 'post',
            data: AJAX_DATA, dataType: 'json',
            beforeSend: function() { $btn.html( STATUS_SPINNER_HTML ).prop( 'disabled', true ); },
            success: function(antwort) { $('#csrf_hash').val(antwort.csrf_hash);
        
                // WENN DIE VALIDATION FEHLSCHLÄGT
                if( typeof antwort.validation !== 'undefined' ) { console.log( 'FEHLER '+element+' '+aktion+': validation -> '+JSON.stringify(antwort.validation) );
                    $formular.find('.eigenschaft').each( function() { const $eigenschaft = $(this); const eigenschaft = $eigenschaft.attr('data-eigenschaft');
                    if( typeof antwort.validation[ eigenschaft ] !== 'undefined' ) {
                        $eigenschaft.addClass( 'is-invalid' ).removeClass( 'is-valid' );
                        $eigenschaft.after( '<div class="invalid-tooltip">'+antwort.validation[ eigenschaft ]+'</div>' );
                    } else { $eigenschaft.addClass( 'is-valid' ).removeClass( 'is-invalid' ); }
                    } );
                }

                // WENN DIE VALIDATION ERFOLGREICH DURCHLÄUFT
                else {
                    if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );
                    if( CSRF_NAME in AJAX_DATA ) delete AJAX_DATA[ CSRF_NAME ];
                    if( typeof element_id === 'undefined' ) { AJAX_DATA['id'] = LISTE.tabelle.length+1; LISTE.tabelle[ AJAX_DATA['id'] ] = new Object(); }
                    $.each( AJAX_DATA, function( eigenschaft, wert ) {
                        if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
                        if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][eigenschaft] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][eigenschaft]['typ'] == 'zeitpunkt' ) wert = DateTime.fromFormat( wert, SQL_DATETIME );
                        LISTE.tabelle[ AJAX_DATA['id'] ][ eigenschaft ] = wert;
                    } );
                    $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );
                    $btn.parents('.modal').first().modal('hide');
                }
            
            },
            error: function(xhr) { console.log( 'FEHLER '+element+' '+aktion+': ' + xhr.status + ' ' + xhr.statusText); },
            complete: function() { $btn.html( btn_beschriftung ).prop( 'disabled', false ); },
        } );
        
    } );

    // ELEMENT LÖSCHEN
    $(document).on("click", ".btn_element_loeschen" , function() {
        const $btn_element_loeschen = $(this); const btn_element_loeschen_beschriftung = $btn_element_loeschen.html(); const $formular = $btn_element_loeschen.parents('.formular').first();
        const element = $btn_element_loeschen.attr('data-element'); const element_id = $btn_element_loeschen.attr('data-element_id');
        let liste; if( typeof liste === 'undefined' ) $.each( LISTEN, function( liste_each, LISTE_each ) { if( element ==LISTE_each.element ) liste = liste_each; } );
        const LISTE = LISTEN[ liste ];

        $.ajaxQueue( {
            url: BASE_URL+'/'+LISTE.controller+'/ajax_'+element+'_loeschen', method: 'post',
            data: { [CSRF_NAME]: $('#csrf_hash').val(), 'id': element_id }, dataType: 'json',
            beforeSend: function() { $btn_element_loeschen.html( STATUS_SPINNER_HTML ).prop( 'disabled', true ); },
            success: function(antwort) { $('#csrf_hash').val(antwort.csrf_hash);
                if( typeof antwort.validation !== 'undefined' ) console.log( 'FEHLER '+element+' '+aktion+': validation -> '+JSON.stringify(antwort.validation) );
                else { if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );
                    delete LISTE.tabelle[ element_id ];
                    $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
                    $formular.modal('hide');
                }
            },
            error: function(xhr) { console.log( 'FEHLER '+element+' '+aktion+': ' + xhr.status + ' ' + xhr.statusText); },
            complete: function() { $btn_element_loeschen.html( btn_element_loeschen_beschriftung ).prop( 'disabled', false ); },
        } );
          
    } );

    // SORTABLE
    $('.sortable').sortable( {
        handle: '.sortable_handle',
        start: function( event, ui ) {
            ui.item.addClass('border-top border-primary shadow');
        },
        stop: function( event, ui ) {
            ui.item.removeClass('border-top border-primary shadow');
        },
        update: function() { 
            $('#sortable_speichern').attr( 'disabled', false );
        }
    } );

} );

function wert_formatieren( wert, eigenschaft, liste ) {
    if( eigenschaft == 'geburt' ) wert = wert.toFormat('dd.MM.yyyy');
    if( eigenschaft == 'geburtstag' ) wert = wert.toFormat('dd.MM.');
    if( eigenschaft == 'alter' ) wert = Math.floor( wert )+' Jahre';
    if( eigenschaft == 'alter_geburtstag' ) wert = Math.floor( wert )+' Jahre';
    if( eigenschaft == 'geschlecht' ) wert = VORGEGEBENE_WERTE[ liste ].geschlecht[ wert ].beschriftung;
    if( eigenschaft == 'register' ) wert = VORGEGEBENE_WERTE[ liste ].register[ wert ].beschriftung;
    if( eigenschaft == 'funktion' ) wert = VORGEGEBENE_WERTE[ liste ].funktion[ wert ].beschriftung;
    if( eigenschaft == 'vorstandschaft' ) wert = JANEIN[ wert ].beschriftung;
    if( eigenschaft == 'aktiv' ) wert = JANEIN[ wert ].beschriftung;
    if( eigenschaft == 'start' ) wert = WOCHENTAGE[ wert.weekday ].kurz+', '+wert.toFormat('dd.MM.yyyy HH:mm');
    if( eigenschaft == 'ende' ) wert = WOCHENTAGE[ wert.weekday ].kurz+', '+wert.toFormat('dd.MM.yyyy HH:mm');
    if( eigenschaft == 'kategorie' ) wert = VORGEGEBENE_WERTE[ liste ].kategorie[ wert ].beschriftung;
    return wert;
}