// VAR VOM LOC AKTUALISIEREN
$(document).on("LOC_upd_VAR", function (event, prio_liste) {
    $.each(LISTEN, function (liste, LISTE) {
        LOC_upd_VAR(liste);
    });
    $(document).trigger("VAR_upd_DOM", [prio_liste]);
});
