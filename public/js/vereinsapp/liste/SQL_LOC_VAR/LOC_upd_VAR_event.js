// VAR VOM LOC AKTUALISIEREN
$(document).on("LOC_upd_VAR", function (event, prio_liste) {
    // const todo = Object.keys( LISTEN ); if( prio_liste in LISTEN ) {
    //     todo[0] = prio_liste;
    //     $.each( Object.keys( LISTEN ), function( index, liste) { todo[ index + 1 ] = liste; } );
    // }
    // $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ]; LISTE.tabelle = new Array();
    $.each(LISTEN, function (liste, LISTE) {
        LOC_upd_VAR(liste);
    });
    $(document).trigger("VAR_upd_DOM", [prio_liste]);
});
