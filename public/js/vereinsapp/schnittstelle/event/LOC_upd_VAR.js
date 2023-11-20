function LOC_upd_VAR(liste) {
    G.LISTEN[liste].tabelle = new Array();
    $.each(Schnittstelle_GibLocalstorageRaus(liste + "_tabelle", true), function () {
        const element = this;

        $.each(element, function (eigenschaft, wert) {
            if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") element[eigenschaft] = Number(wert);
            if (
                typeof EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft] !== "undefined" &&
                EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft]["typ"] == "zeitpunkt"
            )
                element[eigenschaft] = DateTime.fromFormat(wert, SQL_DATETIME);
        });

        if (liste == "mitglieder") {
            if ("geburt" in element) {
                element["alter"] = -1 * element["geburt"].diffNow("years").years;
                element["geburtstag"] = DateTime.fromFormat(element["geburt"].toFormat("dd.MM.") + DateTime.now().toFormat("yyyy"), "dd.MM.yyyy");
                if (element["geburtstag"] < DateTime.now().startOf("day"))
                    element["geburtstag"] = element["geburtstag"].plus({
                        years: 1,
                    });
                element["alter_geburtstag"] = element["geburtstag"].diff(element["geburt"], "years").years;
            }
            element["abwesend"] = false;
            if ("abwesenheiten" in G.LISTEN)
                $.each(G.LISTEN.abwesenheiten.tabelle, function () {
                    const abwesenheit = this;
                    if ("id" in abwesenheit) {
                        if (
                            abwesenheit["mitglied_id"] == element["id"] &&
                            abwesenheit["start"] <= DateTime.now() &&
                            DateTime.now() <= abwesenheit["ende"]
                        )
                            element["abwesend"] = true;
                    }
                });
        } else if (liste == "termine") {
            element["ich_rueckmeldung_id"] = null;
            if ("rueckmeldungen" in G.LISTEN)
                $.each(G.LISTEN.rueckmeldungen.tabelle, function () {
                    const rueckmeldung = this;
                    if ("id" in rueckmeldung) {
                        if (rueckmeldung["termin_id"] == element["id"] && rueckmeldung["mitglied_id"] == ICH["id"])
                            element["ich_rueckmeldung_id"] = rueckmeldung["id"];
                    }
                });
            if (typeof element["filtern_mitglieder"] !== "undefined")
                element["filtern_mitglieder"] = Liste_GibSqlFiltern2Filtern(JSON.parse(element["filtern_mitglieder"]), "mitglieder");
            else element["filtern_mitglieder"] = new Array();
            element["ich_eingeladen"] = false;
            $.each(Liste_GibTabelleGefiltert(element["filtern_mitglieder"], "mitglieder"), function () {
                const mitglied = this;
                if (mitglied["id"] == ICH["id"]) element["ich_eingeladen"] = true;
            });
        } else if (liste == "notenbank") {
            function anzahl_dateien(verzeichnis) {
                const anzahl = { noten: 0, audio: 0, verzeichnis: 0 };
                $.each(verzeichnis, function (index, datei) {
                    if (typeof datei == "array" || typeof datei == "object") {
                        const unterverzeichnis = datei;
                        anzahl.verzeichnis++;
                        const anzahl_unterverzeichnis = anzahl_dateien(unterverzeichnis);
                        anzahl.noten += anzahl_unterverzeichnis.noten;
                        anzahl.audio += anzahl_unterverzeichnis.audio;
                    } else if (datei.substring(datei.length - 4, datei.length) == ".pdf") anzahl.noten++;
                    else if (datei.substring(datei.length - 4, datei.length) == ".m4a") anzahl.audio++;
                });
                return anzahl;
            }
            element["anzahl_noten"] = anzahl_dateien(element["verzeichnis"]).noten;
            element["anzahl_audio"] = anzahl_dateien(element["verzeichnis"]).audio;
            element["anzahl_verzeichnis"] = anzahl_dateien(element["verzeichnis"]).verzeichnis;
        }

        G.LISTEN[liste].tabelle[element["id"]] = element;
    });

    G.LISTEN[liste].sortieren = Schnittstelle_GibLocalstorageRaus(liste + "_sortieren", true);

    G.LISTEN[liste].filtern = Schnittstelle_GibLocalstorageRaus(liste + "_filtern", true);
    function LOC_upd_VAR_filtern(filtern, liste) {
        $.each(filtern, function (index, knoten) {
            if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
            else if ("operator" in knoten) {
                const eigenschaft = knoten.eigenschaft;
                let wert = knoten.wert;
                if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") knoten.wert = Number(wert);
                if (
                    typeof EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft] !== "undefined" &&
                    EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft]["typ"] == "zeitpunkt"
                )
                    knoten.wert = DateTime.fromFormat(wert, SQL_DATETIME);
            }
        });
    }
    LOC_upd_VAR_filtern(G.LISTEN[liste].filtern, liste);
}
