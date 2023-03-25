const SORTIEREN = new Object();

$(document).ready( function() {

    {
        SORTIEREN.$blanko_sortieren_element = $('.sortieren').find('.blanko').first(); $('.sortieren').empty();
    }



    // SORTIEREN IM DOM AKTUALISIEREN
    $(document).on( 'VAR_upd_DOM', function( event, prio_liste ) { const todo = new Array();
        if( prio_liste in LISTEN ) {
            todo.push( prio_liste );
            $.each( Object.keys( LISTEN ), function( index, liste) { if( liste != prio_liste ) todo.push( liste ); } );
        }
        $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ];
        
            // SORTIEREN AKTUALISIEREN
            $( '.sortieren[data-liste="'+liste+'"]' ).each( function() { const $sortieren = $(this);
                $sortieren.html( sortieren2$sortieren( LISTE.sortieren, liste ) );
            } );

        } );
    } );
    
    // FORMULAR (MODAL) ÖFFNEN
    $('#liste_sortieren_Modal').on('show.bs.modal', function ( event ) { const $formular = $(this); const $btn_oeffnend = $(event.relatedTarget);
        let liste = $btn_oeffnend.attr('data-liste'); const LISTE = LISTEN[ liste ];

        let titel_beschriftung; if( typeof element !== 'undefined' ) titel_beschriftung = element; else titel_beschriftung = liste;
        $formular.find('.modal-title').text( bezeichnung_kapitalisieren( unix2umlaute( titel_beschriftung ) )+' '+unix2umlaute( $btn_oeffnend.attr('data-aktion') ) );

        $formular.find('.sortieren, .sortieren_definitionen').attr( 'data-liste', liste );
        const $filtern_definition = $formular.find('.sortieren_definitionen');
        $filtern_definition.find('.sortieren_eigenschaft').empty();
        $.each( SORTIERBARE_EIGENSCHAFTEN[ liste ], function( index, eigenschaft) {
            $( '<option value="'+eigenschaft+'">'+EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ].beschriftung+'</option>' ).appendTo( $filtern_definition.find('.sortieren_eigenschaft') );
        } );
        
        $(document).trigger( 'VAR_upd_DOM', [ liste ] );
    } );

    // SORTIEREN ERSTELLEN
    $(document).on("click", ".btn_sortieren_erstellen" , function() {
        const $btn_erstellen = $(this); const $formular = $btn_erstellen.parents('.sortieren_definitionen').first();
        const liste = $btn_erstellen.parents('[data-liste]').first().attr('data-liste'); const LISTE = LISTEN[ liste ];

        const eigenschaft = $formular.find('.sortieren_eigenschaft').val();
        const richtung = Number( $formular.find('.sortieren_richtung:checked').val() );
        LISTE.sortieren.push( { richtung: richtung, eigenschaft: eigenschaft } );

        $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
    } );
        
    // SORTIEREN LÖSCHEN
    $(document).on("click", ".btn_sortieren_loeschen" , function() {
        const $btn_loeschen = $(this); const $sortieren = $btn_loeschen.parents('.sortieren').first();
        const liste = $btn_loeschen.parents('[data-liste]').first().attr('data-liste'); const LISTE = LISTEN[ liste ];
        const $element = $btn_loeschen.parents('.sortieren_element').first();

        $element.remove();
        LISTE.sortieren = $sortieren2sortieren( $sortieren, liste );
        $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
    } );    

} );

function array_sortieren( array, sortieren ) { // https://bithacker.dev/javascript-object-multi-property-sort
    if( array.length == 0 || sortieren.length == 0 ) return array; else return array.sort( function( a, b ) {
        let i = 0, result = 0;
        while(i < sortieren.length && result === 0) {
            let richtung = 1; if( sortieren[i].richtung == SORT_ASC ) richtung = 1; else if( sortieren[i].richtung == SORT_DESC ) richtung = -1;
            result = richtung*( umlaute2unix( a[ sortieren[i].eigenschaft ].toString() ) < umlaute2unix( b[ sortieren[i].eigenschaft ].toString() ) ? -1 : (umlaute2unix( a[ sortieren[i].eigenschaft ].toString() ) > umlaute2unix( b[ sortieren[i].eigenschaft ].toString() ) ? 1 : 0));
            i++;
        } return result;
    } );
}

function sortieren2$sortieren( sortieren, liste ) { const LISTE = LISTEN[ liste ]; const $sortieren = new Array();
    $.each( sortieren, function( index, element ) {
        const richtung = element.richtung; const eigenschaft = element.eigenschaft;
        const $neues_sortieren_element = SORTIEREN.$blanko_sortieren_element.clone().removeClass('blanko invisible').addClass('sortieren_element');
        $neues_sortieren_element.find('.eigenschaft').attr( 'data-eigenschaft', eigenschaft ).text( EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ].beschriftung );
        $neues_sortieren_element.find('.richtung').attr( 'data-richtung', richtung )
        if( richtung == SORT_ASC ) $neues_sortieren_element.find('.richtung').addClass( 'bi-'+SYMBOLE.asc.bootstrap );
        else if( richtung == SORT_DESC ) $neues_sortieren_element.find('.richtung').addClass( 'bi-'+SYMBOLE.desc.bootstrap );
        $neues_sortieren_element.find('.btn_sortieren_loeschen').attr( 'data-liste', liste );
        $sortieren.push( $neues_sortieren_element );
    } ); return $sortieren;
}

function $sortieren2sortieren( $sortieren, liste ) { const LISTE = LISTEN[ liste ]; const sortieren = new Array();
    $sortieren.children('.sortieren_element').each( function() { const $element = $(this);
        const richtung = Number( $element.find('.richtung').attr('data-richtung') );
        const eigenschaft = $element.find('.eigenschaft').attr('data-eigenschaft');
        sortieren.push( { richtung: richtung, eigenschaft: eigenschaft } );
    } ); return sortieren;
}