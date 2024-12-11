function Schnittstelle_EventSqlUpdLocalstorage(folgendes_event) {
    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "einstellungen/ajax_tabellen",
        // data: { hash: sha256(String(Schnittstelle_LocalstorageRausZurueck(liste + "_tabelle"))), },
        folgendes_event: folgendes_event,
        rein_validation_pos_aktion: function (AJAX) {
            if (isObject(AJAX) && "antwort" in AJAX && isObject(AJAX.antwort) && "tabellen" in AJAX.antwort && isObject(AJAX.antwort.tabellen))
                $.each(AJAX.antwort.tabellen, function (liste, tabelle) {
                    Schnittstelle_LocalstorageRein(liste + "_tabelle", tabelle);
                });

            if (typeof AJAX.folgendes_event === "function" || (isArray(AJAX.folgendes_event) && AJAX.folgendes_event.length > 0))
                $.each(AJAX.antwort.tabellen, function (liste, tabelle) {
                    Schnittstelle_EventAusfuehren(AJAX.folgendes_event, { liste: liste });
                });
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
