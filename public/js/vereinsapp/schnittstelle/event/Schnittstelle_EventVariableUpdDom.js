function Schnittstelle_EventVariableUpdDom(liste, naechste_aktionen) {
    Schnittstelle_EventDurchfuehren(liste, naechste_aktionen, function (liste) {
        // LISTE AKTUALISIEREN
        $('.liste[data-liste="' + liste + '"]').each(function () {
            Liste_Aktualisieren($(this));
        });

        // ELEMENT AKTUALISIEREN
        $('.element[data-liste="' + liste + '"]').each(function () {
            Liste_ElementAktualisieren($(this), liste);
        });

        // LISTENSTATISTIK AKTUALISIEREN
        $('.listenstatistik[data-listenstatistik="gefunden"]').each(function () {
            const $listenstatistik = $(this);
            const instanz = $listenstatistik.attr("data-instanz");
            if (typeof instanz !== "undefined") {
                $(this).text($('.liste[id="' + instanz + '"]').children().length);
            }
        });
        $('.listenstatistik[data-listenstatistik="angewaehlt"]').each(function () {
            const $listenstatistik = $(this);
            const instanz = $listenstatistik.attr("data-instanz");
            if (typeof instanz !== "undefined") {
                $(this).text($('.liste[id="' + instanz + '"]').find(".check:checked").length);
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

        // FORMULAR MEINE RÜCKMELDUNG EIN-/AUSBLENDEN
        $(".rueckmeldung_eingeladen").each(function () {
            Termine_RueckmeldungEinAusblenden($(this));
        });

        // RÜCKMELDUNG AKTUALISIEREN
        $(".zusagen, .absagen").each(function () {
            Termine_RueckmeldungAktualisieren($(this));
        });

        $(".jetzt").each(function () {
            Schnittstelle_JetztAktualisieren($(this));
        });
    });
}
