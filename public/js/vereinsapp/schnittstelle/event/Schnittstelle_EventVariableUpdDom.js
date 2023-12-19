function Schnittstelle_EventVariableUpdDom(liste, naechste_aktionen) {
    Schnittstelle_EventDurchfuehren(liste, naechste_aktionen, function (liste) {
        // AUSWERTUNGEN AKTUALISIEREN
        $('.auswertungen[data-liste="' + liste + '"]').each(function () {
            Liste_AuswertungenAktualisieren($(this), liste);
            let cluster = $(this).attr("data-cluster");
            if (typeof cluster !== "undefined") cluster = JSON.parse(cluster);
            else cluster = new Object();
            Schnittstelle_EventVariableUpdDom(cluster.liste);
        });

        // LISTE AKTUALISIEREN
        $('.liste[data-liste="' + liste + '"]').each(function () {
            Liste_Aktualisieren($(this));
        });

        // ELEMENT AKTUALISIEREN
        $('.element[data-element="' + G.LISTEN[liste].element + '"]').each(function () {
            Liste_ElementAktualisieren($(this), liste);
        });

        $.each(G.LISTEN[liste].instanz, function (liste_id, instanz) {
            // FILTERN AKTUALISIEREN
            $('.filtern[data-liste_id="' + liste_id + '"]').html(
                Liste_Filtern2$FilternZurueck(
                    G.LISTEN[liste].instanz[liste_id].filtern,
                    FILTERN.$blanko_filtern_sammlung,
                    FILTERN.$blanko_filtern_element,
                    "filtern",
                    liste
                )
            );
            $('.filtern[data-liste_id="' + liste_id + '"]')
                .find(".btn_filtern_aendern, .btn_filtern_loeschen")
                .attr("data-liste", liste)
                .attr("data-liste_id", liste_id);

            // SORTIEREN AKTUALISIEREN
            $('.sortieren[data-liste_id="' + liste_id + '"]').each(function () {
                $(this).html(Liste_Sortieren2$SortierenZurueck(G.LISTEN[liste].instanz[liste_id].sortieren, liste));
            });
            $('.sortieren[data-liste_id="' + liste_id + '"]')
                .find(".btn_sortieren_aendern, .btn_sortieren_loeschen")
                .attr("data-liste", liste)
                .attr("data-liste_id", liste_id);
        });

        // PERMISSIONS AKTUALISIEREN
        $(".permissions").each(function () {
            Mitglieder_PermissionsAktualisieren($(this), "mitglieder");
        });

        // PERMISSION AKTUALISIEREN
        $(".permission").each(function () {
            Mitglieder_PermissionAktualisieren($(this), "mitglieder");
        });

        // FORMULAR MEINE RÜCKMELDUNG EIN-/AUSBLENDEN
        $('.formular[data-formular="rueckmeldung"]').each(function () {
            Termine_FormularMeineRueckmeldungEinAusblenden($(this));
        });

        // MEINE RÜCKMELDUNG AKTUALISIEREN
        $(".zusagen, .absagen").each(function () {
            Termine_MeineRueckmeldungAktualisieren($(this));
        });
    });
}
