function Schnittstelle_EventElementErgaenzenTermine(termin) {
    if ("rueckmeldungen" in LISTEN) {
        termin["ich_rueckmeldung_id"] = Liste_ElementIdZurueck(
            [
                { liste: "termine", element_id: Number(termin["id"]) },
                { liste: "mitglieder", element_id: Number(ICH["id"]) },
            ],
            "rueckmeldungen"
        );
        if (typeof termin["ich_rueckmeldung_id"] === "undefined") termin["ich_rueckgemeldet"] = false;
        else termin["ich_rueckgemeldet"] = true;
    }

    termin["ich_eingeladen"] = false;
    if ("filtern_mitglieder" in termin) termin["filtern_mitglieder"] = Schnittstelle_VariableArrayBereinigtZurueck(termin["filtern_mitglieder"]);
    else termin["filtern_mitglieder"] = new Array();
    let termin_kategorie_filtern_mitglieder;
    if (termin["kategorie"] in TERMINE_KATEGORIE_FILTERN_MITGLIEDER)
        termin_kategorie_filtern_mitglieder = Schnittstelle_VariableArrayBereinigtZurueck(TERMINE_KATEGORIE_FILTERN_MITGLIEDER[termin["kategorie"]]);
    else termin_kategorie_filtern_mitglieder = new Array();
    let filtern_mitglieder_kombiniert;
    if (termin_kategorie_filtern_mitglieder.length > 0)
        if (termin["filtern_mitglieder"].length == 0) filtern_mitglieder_kombiniert = termin_kategorie_filtern_mitglieder;
        else
            filtern_mitglieder_kombiniert = [
                { verknuepfung: "&&", filtern: [termin["filtern_mitglieder"][0], termin_kategorie_filtern_mitglieder[0]] },
            ];
    else filtern_mitglieder_kombiniert = termin["filtern_mitglieder"];
    $.each(Liste_TabelleGefiltertZurueck(filtern_mitglieder_kombiniert, "mitglieder"), function () {
        if (this["id"] == ICH["id"]) termin["ich_eingeladen"] = true;
    });
}
