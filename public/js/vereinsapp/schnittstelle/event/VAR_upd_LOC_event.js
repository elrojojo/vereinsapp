// LOC VON VAR AKTUALISIEREN
$(document).on("VAR_upd_LOC", function (event, prio_liste) {
    $.each(G.LISTEN, function (liste) {
        VAR_upd_LOC(liste);
    });
    $(document).trigger("LOC_upd_VAR", [prio_liste]);
});
