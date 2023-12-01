function Schnittstelle_EventVariableUpdDom(liste, naechste_aktionen) {
    if (typeof liste === "undefined")
        $.each(G.LISTEN, function (liste) {
            Schnittstelle_EventVariableUpdDom(liste);
        });
    else {
        G.DEBUG_COUNTER++;
        console.log(G.DEBUG_COUNTER, "Schnittstelle_EventLocalstorageUpdVariable", liste);

        // LISTE AKTUALISIEREN
        $('.liste[data-liste="' + liste + '"]').each(function () {
            Liste_Aktualisieren($(this), liste);
        });

        // ELEMENT AKTUALISIEREN
        $('.element[data-element="' + G.LISTEN[liste].element + '"]').each(function () {
            Liste_ElementAktualisieren($(this), liste);
        });

        // AUSWERTUNGEN AKTUALISIEREN
        $('.auswertungen[data-liste="' + liste + '"]').each(function () {
            Liste_AuswertungenAktualisieren($(this), liste);
        });

        // FILTERN AKTUALISIEREN
        $('.filtern[data-liste="' + liste + '"]').each(function () {
            const $filtern = $(this);
            $filtern.html(
                Liste_Filtern2$FilternZurueck(
                    G.LISTEN[liste].filtern,
                    FILTERN.$blanko_filtern_sammlung,
                    FILTERN.$blanko_filtern_element,
                    "filtern",
                    liste
                )
            );
        });

        // SORTIEREN AKTUALISIEREN
        $('.sortieren[data-liste="' + liste + '"]').each(function () {
            $(this).html(Liste_Sortieren2$SortierenZurueck(G.LISTEN[liste].sortieren, liste));
        });

        // PERMISSIONS AKTUALISIEREN
        $(".permissions").each(function () {
            Mitglieder_PermissionsAktualisieren($(this), "mitglieder");
        });

        // PERMISSION AKTUALISIEREN
        $(".permission").each(function () {
            Mitglieder_PermissionAktualisieren($(this), "mitglieder");
        });

        // PERSONENKREIS BESCHRÄNKEN AKTUALISIEREN
        $(".personenkreis_beschraenken").each(function () {
            Termine_PersonenkreisBeschraenkenAktualisieren($(this), "termine");
        });

        // FORMULAR MEINE RÜCKMELDUNG EIN-/AUSBLENDEN
        $(".rueckmeldung").each(function () {
            Termine_FormularMeineRueckmeldungEinAusblenden($(this));
        });

        // MEINE RÜCKMELDUNG AKTUALISIEREN
        $(".zusagen, .absagen").each(function () {
            Termine_MeineRueckmeldungAktualisieren($(this));
        });

        Schnittstelle_NaechsteAktion(liste, naechste_aktionen);
    }
}
