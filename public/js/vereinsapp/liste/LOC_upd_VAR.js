// VAR VOM LOC AKTUALISIEREN
function LOC_upd_VAR( liste ) { const LISTE = LISTEN[ liste ];

    LISTE.tabelle = new Array(); const LOC_tabelle = localStorage.getItem( 'vereinsapp_'+liste+'_tabelle' ); if( LOC_tabelle !== null && LOC_tabelle != 'undefined' ) {
        $.each( JSON.parse( LOC_tabelle ), function() { const element = this;

            $.each( element, function( eigenschaft, wert ) {
                if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) element[ eigenschaft ] = Number(wert);
                if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) element[ eigenschaft ] = DateTime.fromFormat( wert, SQL_DATETIME );
            } );

            if( liste == 'mitglieder' ) {
                if( 'geburt' in element ) {
                    element['alter'] = (-1)* element['geburt'].diffNow('years').years;
                    element['geburtstag'] = DateTime.fromFormat( element['geburt'].toFormat('dd.MM.')+DateTime.now().toFormat('yyyy'), 'dd.MM.yyyy' );
                        if( element['geburtstag'] < DateTime.now().startOf('day') ) element['geburtstag'] = element['geburtstag'].plus( { years: 1 } );
                    element['alter_geburtstag'] = element['geburtstag'].diff( element['geburt'], 'years' ).years;
                }
                element['abwesend'] = false; if( 'abwesenheiten' in LISTEN ) $.each( LISTEN.abwesenheiten.tabelle, function() { const abwesenheit = this; if( 'id' in abwesenheit ) {
                    if( abwesenheit['mitglied_id'] == element['id'] && abwesenheit['start'] <= DateTime.now() && DateTime.now() <= abwesenheit['ende'] ) element['abwesend'] = true;
                } } );
            }
            else if( liste == 'termine' ) {
                element['ich_rueckmeldung_id'] = null; if( 'rueckmeldungen' in LISTEN ) $.each( LISTEN.rueckmeldungen.tabelle, function() { const rueckmeldung = this; if( 'id' in rueckmeldung ) {
                    if( rueckmeldung['termin_id'] == element['id'] && rueckmeldung['mitglied_id'] == ICH['id'] ) element['ich_rueckmeldung_id'] = rueckmeldung['id'];
                } } );
                element['filtern_mitglieder'] = sqlfiltern2filtern( JSON.parse( element['filtern_mitglieder'] ), 'mitglieder' );
                element['ich_eingeladen'] = false; $.each( tabelle_filtern( element['filtern_mitglieder'], 'mitglieder' ), function() { const mitglied = this;
                    if( mitglied['id'] == ICH['id'] ) element['ich_eingeladen'] = true;
                } );
            }

            LISTE.tabelle[ element['id'] ] = element;
        } );
    }

    LISTE.sortieren = new Array(); const LOC_sortieren = localStorage.getItem( 'vereinsapp_'+liste+'_sortieren' ); if( LOC_sortieren !== null && LOC_sortieren != 'undefined' ) LISTE.sortieren = JSON.parse( LOC_sortieren );

    LISTE.filtern = new Array(); const LOC_filtern = localStorage.getItem( 'vereinsapp_'+liste+'_filtern' ); if( LOC_filtern !== null && LOC_filtern != 'undefined' ) LISTE.filtern = JSON.parse( LOC_filtern );
    function LOC_upd_VAR_filtern( filtern, liste ) { const LISTE = LISTEN[ liste ];
        $.each( filtern, function( index, knoten ) {
            if( 'verknuepfung' in knoten ) LOC_upd_VAR_filtern( knoten.filtern, liste );
            else if( 'operator' in knoten ) { const eigenschaft = knoten.eigenschaft; let wert = knoten.wert;
                if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) knoten.wert = Number(wert);
                if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) knoten.wert = DateTime.fromFormat( wert, SQL_DATETIME );
            }
        } );
    } LOC_upd_VAR_filtern( LISTE.filtern, liste );

}
$(document).on( 'LOC_upd_VAR', function( event, prio_liste ) {
    // const todo = Object.keys( LISTEN ); if( prio_liste in LISTEN ) {
    //     todo[0] = prio_liste;
    //     $.each( Object.keys( LISTEN ), function( index, liste) { todo[ index + 1 ] = liste; } );
    // }
    // $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ]; LISTE.tabelle = new Array();
    $.each( LISTEN, function( liste, LISTE ) { LOC_upd_VAR( liste ) } );
    $(document).trigger( 'VAR_upd_DOM', [ prio_liste ] );
} );