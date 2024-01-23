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
            $('.filtern[data-instanz="' + instanz + '"]')
                .html(
                    Liste_Filtern2$FilternZurueck(
                        G.LISTEN[liste].instanz[instanz].filtern,
                        FILTERN.$blanko_filtern_sammlung,
                        FILTERN.$blanko_filtern_element,
                        liste
                    )
                )
                .find(".btn_filtern_aendern, .btn_filtern_loeschen")
                .attr("data-liste", liste)
                .attr("data-instanz", instanz);

            // SORTIEREN AKTUALISIEREN
            $('.sortieren[data-instanz="' + instanz + '"]')
                .each(function () {
                    $(this).html(
                        Liste_Sortieren2$SortierenZurueck(G.LISTEN[liste].instanz[instanz].sortieren, SORTIEREN.$blanko_sortieren_element, liste)
                    );
                })
                .find(".btn_sortieren_aendern, .btn_sortieren_loeschen")
                .attr("data-liste", liste)
                .attr("data-instanz", instanz);
        });

        // FILTERN IN EIGENSCHAFTEN AKTUALISIEREN
        $('.filtern[data-liste="' + liste + '"][data-eigenschaft^="filtern_"]').each(function () {
            const $filtern = $(this);
            const eigenschaft = $filtern.attr("data-eigenschaft");
            const filtern_liste = $filtern.attr("data-filtern_liste");
            const element_id = $filtern.attr("data-element_id");
            $filtern.html(
                Liste_Filtern2$FilternZurueck(
                    Schnittstelle_VariableRausZurueck(eigenschaft, element_id, liste),
                    FILTERN.$blanko_filtern_sammlung,
                    FILTERN.$blanko_filtern_element,
                    filtern_liste
                )
            );
            $filtern
                .find(".btn_filtern_aendern, .btn_filtern_loeschen")
                .attr("data-liste", liste)
                .attr("data-eigenschaft", eigenschaft)
                .attr("data-filtern_liste", filtern_liste);
            if (typeof element_id !== "undefined") $filtern.find(".btn_filtern_aendern, .btn_filtern_loeschen").attr("data-element_id", element_id);
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
