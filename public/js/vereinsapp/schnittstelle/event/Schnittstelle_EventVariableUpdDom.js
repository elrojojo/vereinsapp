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

        // ÜBERSCHRIFT AKTUALISIEREN
        $('.ueberschrift[data-liste="' + liste + '"]').each(function () {
            const $ueberschrift = $(this);
            const instanz = $ueberschrift.attr("data-instanz");
            if ($("#" + instanz + ".liste").children().length === 0) $ueberschrift.addClass("invisible");
            else $ueberschrift.removeClass("invisible");
        });

        // LISTENSTATISTIK AKTUALISIEREN
        $('.listenstatistik[data-liste="' + liste + '"]').each(function () {
            const $listenstatistik = $(this);
            const $listenstatistik_sammler = $(this).closest(".listenstatistik_sammler");
            const instanz = $listenstatistik.attr("data-instanz");
            const $liste = $("#" + instanz + ".liste");

            if ($liste.children().length === 0) $listenstatistik_sammler.addClass("invisible");
            else {
                $listenstatistik_sammler.removeClass("invisible");

                switch ($listenstatistik.attr("data-listenstatistik")) {
                    case "anzahl": {
                        $listenstatistik.text($liste.children().length);
                        break;
                    }
                    case "angewaehlt": {
                        $listenstatistik.text($liste.find(".check:checked").length);
                        break;
                    }
                    case "summe": {
                        const eigenschaft = $listenstatistik.attr("data-eigenschaft");
                        if (typeof eigenschaft !== "undefined" && EIGENSCHAFTEN[liste][eigenschaft].typ == "zahl") {
                            let summe = 0;
                            $liste.children().each(function () {
                                summe += Number(Schnittstelle_VariableRausZurueck(eigenschaft, $(this).attr("data-element_id"), liste));
                            });
                            $listenstatistik.text(Liste_WertFormatiertZurueck(summe, eigenschaft, liste));
                        }
                        break;
                    }
                    case "durchschnitt": {
                        const eigenschaft = $listenstatistik.attr("data-eigenschaft");
                        if (typeof instanz !== "undefined" && typeof eigenschaft !== "undefined" && EIGENSCHAFTEN[liste][eigenschaft].typ == "zahl") {
                            let summe = 0;
                            $liste.children().each(function () {
                                summe += Number(Schnittstelle_VariableRausZurueck(eigenschaft, $(this).attr("data-element_id"), liste));
                            });
                            $listenstatistik.text(Liste_WertFormatiertZurueck(summe / $liste.children().length, eigenschaft, liste));
                        }
                    }
                }
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
