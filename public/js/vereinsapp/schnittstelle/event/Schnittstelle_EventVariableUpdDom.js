EVENT_VARIABLE_UPD_DOM_MODULE = new Array();

function Schnittstelle_EventVariableUpdDom(liste, naechste_aktionen) {
    Schnittstelle_EventDurchfuehren(liste, naechste_aktionen, function (liste) {
        // LISTE AKTUALISIEREN
        $('.liste[data-liste="' + liste + '"]').each(function () {
            Liste_Aktualisieren($(this), liste);
        });

        // ELEMENT AKTUALISIEREN
        $('.element[data-liste="' + liste + '"]').each(function () {
            Liste_ElementAktualisieren($(this), liste);
        });

        // LISTENSTATISTIK AKTUALISIEREN
        $('.listenstatistik[data-liste="' + liste + '"][data-listenstatistik="anzahl"]').each(function () {
            const $anzahl = $(this);
            const instanz = $anzahl.attr("data-instanz");
            if (typeof instanz !== "undefined") {
                $anzahl.text($('.liste[id="' + instanz + '"]').children().length);
            }
        });
        $('.listenstatistik[data-liste="' + liste + '"][data-listenstatistik="angewaehlt"]').each(function () {
            const $angewaehlt = $(this);
            const instanz = $angewaehlt.attr("data-instanz");
            if (typeof instanz !== "undefined") {
                $angewaehlt.text($('.liste[id="' + instanz + '"]').find(".check:checked").length);
            }
        });
        $('.listenstatistik[data-liste="' + liste + '"][data-listenstatistik="summe"]').each(function () {
            const $summe = $(this);
            const instanz = $summe.attr("data-instanz");
            const eigenschaft = $summe.attr("data-eigenschaft");
            if (typeof instanz !== "undefined" && typeof eigenschaft !== "undefined" && EIGENSCHAFTEN[liste][eigenschaft].typ == "zahl") {
                let summe = 0;
                $('.liste[id="' + instanz + '"]')
                    .children()
                    .each(function () {
                        summe += Number(Schnittstelle_VariableRausZurueck(eigenschaft, $(this).attr("data-element_id"), liste));
                    });
                $summe.text(Liste_WertFormatiertZurueck(summe, eigenschaft, liste));
            }
        });
        $('.listenstatistik[data-liste="' + liste + '"][data-listenstatistik="durchschnitt"]').each(function () {
            const $durchschnitt = $(this);
            const instanz = $durchschnitt.attr("data-instanz");
            const eigenschaft = $durchschnitt.attr("data-eigenschaft");
            if (typeof instanz !== "undefined" && typeof eigenschaft !== "undefined" && EIGENSCHAFTEN[liste][eigenschaft].typ == "zahl") {
                let summe = 0;
                $('.liste[id="' + instanz + '"]')
                    .children()
                    .each(function () {
                        summe += Number(Schnittstelle_VariableRausZurueck(eigenschaft, $(this).attr("data-element_id"), liste));
                    });
                $durchschnitt.text(Liste_WertFormatiertZurueck(summe / $('.liste[id="' + instanz + '"]').children().length, eigenschaft, liste));
            }
        });

        // AUSWERTUNGEN AKTUALISIEREN
        $('.auswertungen[data-auswertungen="' + liste + '"], .auswertungen[data-liste*=\'"' + liste + "\"']").each(function () {
            if ($(this).attr("data-auswertungen") == liste) Liste_AuswertungenAktualisieren($(this), liste);
            else Liste_AuswertungenAktualisieren($(this), $(this).attr("data-auswertungen"));
        });

        // AUSWERTUNG AKTUALISIEREN
        $('.auswertung[data-auswertungen="' + liste + '"], .auswertung[data-liste="' + liste + '"]').each(function () {
            if ($(this).attr("data-auswertungen") == liste) Liste_AuswertungAktualisieren($(this), liste);
            else Liste_AuswertungAktualisieren($(this), $(this).attr("data-auswertungen"));
        });

        // VERZEICHNIS AKTUALISIEREN
        $('.verzeichnis[data-liste="' + liste + '"]').each(function () {
            Liste_VerzeichnisAktualisieren($(this), liste);
        });

        // DATEI AKTUALISIEREN
        $('.datei[data-liste="' + liste + '"]').each(function () {
            Liste_DateiAktualisieren($(this), liste);
        });

        // SPEZIAL AKTUALISIEREN
        $.each(EVENT_VARIABLE_UPD_DOM_MODULE, function () {
            this();
        });

        $(".jetzt").each(function () {
            Schnittstelle_JetztAktualisieren($(this));
        });
    });
}
