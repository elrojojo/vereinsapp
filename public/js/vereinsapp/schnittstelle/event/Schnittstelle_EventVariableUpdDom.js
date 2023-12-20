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

        $.each(G.LISTEN[liste].instanz, function (instanz) {
            // FILTERN AKTUALISIEREN
            $('.filtern[data-instanz="' + instanz + '"]').html(
                Liste_Filtern2$FilternZurueck(
                    G.LISTEN[liste].instanz[instanz].filtern,
                    FILTERN.$blanko_filtern_sammlung,
                    FILTERN.$blanko_filtern_element,
                    "filtern",
                    liste
                )
            );
            $('.filtern[data-instanz="' + instanz + '"]')
                .find(".btn_filtern_aendern, .btn_filtern_loeschen")
                .attr("data-liste", liste)
                .attr("data-instanz", instanz);

            // SORTIEREN AKTUALISIEREN
            $('.sortieren[data-instanz="' + instanz + '"]').each(function () {
                $(this).html(Liste_Sortieren2$SortierenZurueck(G.LISTEN[liste].instanz[instanz].sortieren, liste));
            });
            $('.sortieren[data-instanz="' + instanz + '"]')
                .find(".btn_sortieren_aendern, .btn_sortieren_loeschen")
                .attr("data-liste", liste)
                .attr("data-instanz", instanz);
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
