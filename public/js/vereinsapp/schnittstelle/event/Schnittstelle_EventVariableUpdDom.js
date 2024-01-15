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

        // AUSWERTUNGEN AKTUALISIEREN
        $('.auswertungen[data-liste="' + liste + '"]').each(function () {
            Liste_AuswertungenAktualisieren($(this), liste);
            let cluster = $(this).attr("data-cluster");
            if (typeof cluster !== "undefined") {
                cluster = JSON.parse(cluster);
                if ("liste" in cluster) Schnittstelle_EventVariableUpdDom(cluster.liste);
            }
        });

        // VERZEICHNIS AKTUALISIEREN
        $('.verzeichnis[data-liste="' + liste + '"]').each(function () {
            Liste_VerzeichnisAktualisieren($(this), liste);
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
                $(this).html(
                    Liste_Sortieren2$SortierenZurueck(G.LISTEN[liste].instanz[instanz].sortieren, SORTIEREN.$blanko_sortieren_element, liste)
                );
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

        // RÜCKMELDUNG AKTUALISIEREN
        $(".zusagen, .absagen").each(function () {
            Termine_RueckmeldungAktualisieren($(this));
        });

        $(".jetzt").each(function () {
            Schnittstelle_JetztAktualisieren($(this));
        });
    });
}
