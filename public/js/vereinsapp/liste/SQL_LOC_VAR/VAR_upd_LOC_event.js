// LOC VON VAR AKTUALISIEREN
$(document).on("VAR_upd_LOC", function (event, prio_liste) {
    // const todo = Object.keys( LISTEN ); if( prio_liste in LISTEN ) {
    //     todo[0] = prio_liste;
    //     $.each( Object.keys( LISTEN ), function( index, liste) { todo[ index + 1 ] = liste; } );
    // }
    // $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ]; const LOC = new Array();
    $.each(LISTEN, function (liste, LISTE) {
        VAR_upd_LOC(liste);
    });
    $(document).trigger("LOC_upd_VAR", [prio_liste]);
});
