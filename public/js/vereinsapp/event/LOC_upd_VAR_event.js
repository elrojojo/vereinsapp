// VAR VOM LOC AKTUALISIEREN
$(document).on("LOC_upd_VAR", function (event, prio_liste) {
    $.each(G.LISTEN, function (liste, LISTE) {
        LOC_upd_VAR(liste);
    });
    $(document).trigger("VAR_upd_DOM", [prio_liste]);
});
