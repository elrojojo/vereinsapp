function Schnittstelle_EventSqlUpdLocalstorage(liste, schleife, naechste_aktionen) {
    if (!Array.isArray(naechste_aktionen)) naechste_aktionen = new Array();

    if (!(liste in LISTEN) || Array.isArray(liste)) {
        let listen;
        if (!(liste in LISTEN)) listen = Object.keys(LISTEN);
        else if (Array.isArray(liste)) listen = liste;

        let neue_ajax_id = AJAXSCHLANGE.length;
        const wartende_ajax_ids = new Array();
        $.each(listen, function (prio, liste) {
            wartende_ajax_ids.push(neue_ajax_id);
            ++neue_ajax_id;
        });

        const warten_auf_ajax_id = wartende_ajax_ids.pop();
        $.each(listen, function (prio, liste) {
            // angenommen, es geht um die letzte liste, also um die ID warten_auf_ajax_id
            let neue_ajax_id = warten_auf_ajax_id;
            let warten_auf = wartende_ajax_ids;
            if (prio < wartende_ajax_ids.length) {
                // wenn dem nicht so ist, dann ändere neue_ajax_id und warten_auf
                neue_ajax_id = wartende_ajax_ids[prio];
                warten_auf = warten_auf_ajax_id;
            }
            SqlUpdLocalstorage(liste, schleife, naechste_aktionen, neue_ajax_id, warten_auf);
        });
    } else SqlUpdLocalstorage(liste, schleife, naechste_aktionen, AJAXSCHLANGE.length);

    function SqlUpdLocalstorage(liste, schleife, naechste_aktionen, neue_ajax_id, warten_auf) {
        if (typeof warten_auf === "undefined") warten_auf = neue_ajax_id;

        // AJAX wird vorbereitet
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: LISTEN[liste].controller + "/ajax_" + liste,
            // data: { hash: sha256(String(Schnittstelle_LocalstorageRausZurueck(liste + "_tabelle"))), },
            liste: liste,
            naechste_aktionen: naechste_aktionen,
            warten_auf: warten_auf,
            rein_validation_pos_aktion: function (AJAX) {
                if (isObject(AJAX) && "antwort" in AJAX && isObject(AJAX.antwort) && "tabelle" in AJAX.antwort)
                    Schnittstelle_LocalstorageRein(AJAX.liste + "_tabelle", AJAX.antwort.tabelle);

                Schnittstelle_NaechsteAktion(liste, AJAX.naechste_aktionen);
            },
        };

        // Falls die Funktion ein weiteres Mal durchgeführt werden soll ("Schleife"), dann wird die Funktion entsprechend übergeben
        if (schleife) AJAXSCHLANGE[neue_ajax_id].schleife = Schnittstelle_EventSqlUpdLocalstorage;

        // AJAX wird in die Schlange mitaufgenommen
        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
