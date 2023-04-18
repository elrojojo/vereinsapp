const FILTERN = new Object();

$(document).ready( function() {

    {
        FILTERN.$blanko_filtern_sammlung = $('.filtern').find('.blanko').first(); $('.filtern').empty();
        FILTERN.$blanko_filtern_element = FILTERN.$blanko_filtern_sammlung.find('.blanko').first(); FILTERN.$blanko_filtern_sammlung.find('.filtern_kind').empty();

        FILTERN.$blanko_filtern_definition = new Object();
        $( '.filtern_definitionen' ).find('.blanko').each( function() { const $blanko = $(this);
        FILTERN.$blanko_filtern_definition[ $blanko.attr('data-typ') ] = $blanko;
        } ); $( '.filtern_definitionen' ).empty();
    }
    


    // FILTERN IM DOM AKTUALISIEREN
    $(document).on( 'VAR_upd_DOM', function( event, prio_liste ) { const todo = new Array();
        if( prio_liste in LISTEN ) {
            todo.push( prio_liste );
            $.each( Object.keys( LISTEN ), function( index, liste) { if( liste != prio_liste ) todo.push( liste ); } );
        }
        $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ];

            // FILTERN AKTUALISIEREN
            $( '.filtern[data-liste="'+liste+'"]' ).each( function() { const $filtern = $(this);
                $filtern.html( filtern2$filtern( LISTE.filtern, liste ) );
            } );

        } );
    } );
    
    // FORMULAR (MODAL) ÖFFNEN
    $('#liste_filtern_Modal').on('show.bs.modal', function ( event ) { const $formular = $(this); const $btn_oeffnend = $(event.relatedTarget);
        let liste = $btn_oeffnend.attr('data-liste'); const LISTE = LISTEN[ liste ];

        let titel_beschriftung; if( typeof element !== 'undefined' ) titel_beschriftung = element; else titel_beschriftung = liste;
        $formular.find('.modal-title').text( bezeichnung_kapitalisieren( unix2umlaute( titel_beschriftung ) )+' '+unix2umlaute( $btn_oeffnend.attr('data-aktion') ) );

        $formular.find('.filtern, .filtern_definitionen').attr( 'data-liste', liste );
        $( '.filtern_definitionen' ).empty();
        $.each( FILTERBARE_EIGENSCHAFTEN[ liste ], function( index, eigenschaft) { const EIGENSCHAFT = EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ];
            const typ = EIGENSCHAFT.typ;
            const beschriftung = EIGENSCHAFT.beschriftung;
            const $neue_filtern_definition = FILTERN.$blanko_filtern_definition[ typ ].clone().removeClass('blanko invisible').addClass('filtern_definition').attr( 'data-eigenschaft', eigenschaft );
            $neue_filtern_definition.find('.accordion-button').attr( 'data-bs-target', '#filtern_'+eigenschaft ).text( beschriftung );
            $neue_filtern_definition.find('.accordion-collapse').attr( 'id', 'filtern_'+eigenschaft );
            if( typ == 'vorgegebene_werte' ) {
                $neue_filtern_definition.find('.filtern_wert').empty();
                $.each( VORGEGEBENE_WERTE[ liste ][ eigenschaft ], function( wert, eigenschaften) {
                    $( '<option value="'+wert+'">'+eigenschaften.beschriftung+'</option>' ).appendTo( $neue_filtern_definition.find('.filtern_wert') );
                } );
            }
            $neue_filtern_definition.appendTo( $formular.find( '.filtern_definitionen' ) );
        } );

        $(document).trigger( 'VAR_upd_DOM', [ liste ] );
    } );

    // FILTERN ERSTELLEN
    $(document).on("click", ".btn_filtern_erstellen" , function() {
        const $btn_erstellen = $(this); const $formular = $btn_erstellen.parents('.filtern_definition').first();
        const liste = $btn_erstellen.parents('[data-liste]').first().attr('data-liste'); const LISTE = LISTEN[ liste ];
        const eigenschaft = $formular.attr('data-eigenschaft');

        const filtern = new Array();
        $formular.find('.filtern_wert').each( function() { const $filtern_wert = $(this); if( $filtern_wert.val() ) {
            const operator = $filtern_wert.attr('data-operator');
            let wert = $filtern_wert.val();
            if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
            if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) wert = DateTime.fromISO( wert );
            filtern.push( { operator: operator, eigenschaft: eigenschaft, wert: wert } );
        } } );
        let filtern_knoten; if( filtern.length == 1 ) filtern_knoten = filtern[0];
        else filtern_knoten = { verknuepfung: '&&', filtern: filtern }

        if( LISTE.filtern.length == 0 ) LISTE.filtern.push( filtern_knoten );
        else {
            if( 'verknuepfung' in LISTE.filtern[0] ) LISTE.filtern[0].filtern.push( filtern_knoten );
            else { const einziges_element = LISTE.filtern[0];
                LISTE.filtern[0] = { verknuepfung: '&&', filtern: new Array() };
                LISTE.filtern[0].filtern.push( einziges_element );
                LISTE.filtern[0].filtern.push( filtern_knoten );
            }
        }

        $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
    } );

    // FILTERN LÖSCHEN
    $(document).on("click", ".btn_filtern_loeschen" , function() {
        const $btn_loeschen = $(this); const $filtern = $btn_loeschen.parents('.filtern').first();
        const liste = $btn_loeschen.parents('[data-liste]').first().attr('data-liste'); const LISTE = LISTEN[ liste ];
        const $element = $btn_loeschen.parents('.filtern_element').first(); const $sammlung = $btn_loeschen.parents('.filtern_sammlung').first();
        let $knoten; if( $element.exists() ) { $knoten = $element; } else  $knoten = $sammlung;
        let $knoten_parallel = $knoten.siblings('.filtern_element, .filtern_sammlung');
        let $sammlung_ebene_hoeher = $knoten.parents('.filtern_sammlung').first();

        $knoten.remove();
        while( $knoten_parallel.length == 1 ) {
            const $knoten_ebene_hoeher = $sammlung_ebene_hoeher.siblings('.filtern_element, .filtern_sammlung');
            $sammlung_ebene_hoeher.replaceWith( $knoten_parallel )
            $knoten_parallel = $knoten_ebene_hoeher;
            sammlung_ebene_hoeher = $knoten_parallel.first().parents('.filtern_sammlung').first();
        }
        LISTE.filtern = $filtern2filtern( $filtern, liste );
        $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
    } );
    
    // FILTERN ÄNDERN (VERKNÜPFUNG)
    $(document).on("click", ".btn_filtern_aendern" , function() {
        const $btn_aendern = $(this); const $filtern = $btn_aendern.parents('.filtern').first();
        const liste = $btn_aendern.parents('[data-liste]').first().attr('data-liste'); const LISTE = LISTEN[ liste ];
        const $verknuepfung = $btn_aendern.parents('.filtern_sammlung').first().find('.verknuepfung').first(); const verknuepfung = $verknuepfung.attr('data-verknuepfung');

        if( verknuepfung == '&&' ) $verknuepfung.attr('data-verknuepfung', '||');
        else if( verknuepfung == '||' ) $verknuepfung.attr('data-verknuepfung', '&&');

        LISTE.filtern = $filtern2filtern( $filtern, liste );
        $(document).trigger( 'VAR_upd_LOC', [ liste ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
    } );

} );

function filtern2$filtern( filtern, liste ) { const LISTE = LISTEN[ liste ]; const $filtern = new Array();
    $.each( filtern, function( index, knoten ) {
        if( 'verknuepfung' in knoten ) { const verknuepfung = knoten.verknuepfung;
            const $neue_filtern_sammlung = FILTERN.$blanko_filtern_sammlung.clone().removeClass('blanko invisible').addClass('filtern_sammlung');
            const $verknuepfung = $neue_filtern_sammlung.find('.verknuepfung');
            $verknuepfung.attr( 'data-verknuepfung', verknuepfung );
            if( verknuepfung == '&&' ) $verknuepfung.text('UND'); else if( verknuepfung == '||' ) $verknuepfung.text('ODER');
            $.each( filtern2$filtern( knoten.filtern, liste ), function( index, $filtern) { $filtern.appendTo( $neue_filtern_sammlung.find('.filtern_kind').first() ); } );
            $filtern.push( $neue_filtern_sammlung );
        } else { const operator = knoten.operator; const eigenschaft = knoten.eigenschaft; const wert = knoten.wert;
            const $neues_filtern_element = FILTERN.$blanko_filtern_element.clone().removeClass('blanko invisible').addClass('filtern_element');
            $neues_filtern_element.find('.eigenschaft').attr( 'data-eigenschaft', eigenschaft ).text( EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ].beschriftung );
            $neues_filtern_element.find('.operator').attr( 'data-operator', operator ).text( operator );
            let data_wert = wert; if( EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ].typ == 'zeitpunkt' ) data_wert = wert.toFormat( SQL_DATETIME );
            $neues_filtern_element.find('.wert').attr( 'data-wert', data_wert ).html( wert_formatieren( wert, eigenschaft, liste ) );
            $neues_filtern_element.find('.btn_filtern_loeschen').attr( 'data-liste', liste );
            $filtern.push( $neues_filtern_element );
        }
    } ); return $filtern;
}

function $filtern2filtern( $filtern, liste ) { const LISTE = LISTEN[ liste ]; const filtern = new Array();
    $filtern.children('.filtern_element, .filtern_sammlung').each( function() { const $knoten = $(this);
        if( $knoten.hasClass('filtern_sammlung') ) {
            const verknuepfung = $knoten.find('.verknuepfung').attr('data-verknuepfung');
            filtern.push( { verknuepfung: verknuepfung, filtern: $filtern2filtern( $knoten.find('.filtern_kind').first(), liste ) } );
        }
        else if( $knoten.hasClass('filtern_element') ) {
            const operator = $knoten.find('.operator').attr('data-operator');
            const eigenschaft = $knoten.find('.eigenschaft').attr('data-eigenschaft');
            let wert = $knoten.find('.wert').attr('data-wert');
            if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
            if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) wert = DateTime.fromFormat( wert, SQL_DATETIME );
            filtern.push( { operator: operator, eigenschaft: eigenschaft, wert: wert } );
        }
    } ); return filtern;
}

function phpfiltern2filtern( phpfiltern, liste ) { const LISTE = LISTEN[ liste ]; const filtern = new Array();
    $.each( phpfiltern, function( index, knoten ) {
        if( 'verknuepfung' in knoten ) {
            const verknuepfung = knoten.verknuepfung;
            filtern.push( { verknuepfung: verknuepfung, filtern: phpfiltern2filtern( knoten.filtern, liste ) } );
        }
        else { const operator = knoten.operator; const eigenschaft = knoten.eigenschaft; let wert = knoten.wert;
            if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
            if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) wert = DateTime.fromFormat( wert, SQL_DATETIME );
            filtern.push( { operator: operator, eigenschaft: eigenschaft, wert: wert } );
        }
    } ); return filtern;
}

function sqlfiltern2filtern( phpfiltern, liste ) { const LISTE = LISTEN[ liste ]; const filtern = new Array();
    $.each( phpfiltern, function( index, knoten ) {
        if( 'verknuepfung' in knoten ) {
            const verknuepfung = knoten.verknuepfung;
            filtern.push( { verknuepfung: verknuepfung, filtern: sqlfiltern2filtern( knoten.filtern, liste ) } );
        }
        else { const operator = knoten.operator; const eigenschaft = knoten.eigenschaft; let wert = knoten.wert;
            if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
            if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) wert = DateTime.fromISO( wert );
            filtern.push( { operator: operator, eigenschaft: eigenschaft, wert: wert } );
        }
    } ); return filtern;
}

function tabelle_filtern( filtern, liste ) { const LISTE = LISTEN[ liste ];
    function element_filtern( element, filtern, liste ) { const LISTE = LISTEN[ liste ]; const sammler = new Array();
        $.each( filtern, function( position, knoten ) { 
            if( 'verknuepfung' in knoten ) { const sammler_knoten = element_filtern( element, knoten.filtern, liste );
                if( ( knoten.verknuepfung == '&&' && sammler_knoten.includes(false) ) || ( knoten.verknuepfung == '||' && !sammler_knoten.includes(true) ) ) sammler.push( false ); else sammler.push( true );
            } else sammler.push(
                    ( knoten.operator == '==' && element[ knoten.eigenschaft ] == knoten.wert )
                ||  ( knoten.operator == '!=' && element[ knoten.eigenschaft ] != knoten.wert )
                ||  ( knoten.operator == '<=' && element[ knoten.eigenschaft ] <= knoten.wert )
                ||  ( knoten.operator == '>=' && element[ knoten.eigenschaft ] >= knoten.wert )
                );
        } ); return sammler;
    } const tabelle_gefiltert = new Array(); $.each( LISTE.tabelle, function() { const element = this; if( 'id' in element ) {
        if( filtern.length == 0 || element_filtern( element, filtern, liste )[0] ) tabelle_gefiltert.push( element );
    } } ); return tabelle_gefiltert;
}