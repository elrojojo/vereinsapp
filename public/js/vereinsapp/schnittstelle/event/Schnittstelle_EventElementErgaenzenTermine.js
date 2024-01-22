function Schnittstelle_EventElementErgaenzenTermine(termin) {
    if ("rueckmeldungen" in G.LISTEN) {
        termin["ich_rueckmeldung_id"] = Termine_RueckmeldungIdZurueck(Number(termin["id"]), Number(ICH["id"]));
        if (termin["ich_rueckmeldung_id"] === null) termin["ich_rueckgemeldet"] = false;
        else termin["ich_rueckgemeldet"] = true;
    }

    termin["ich_eingeladen"] = false;
    if ("filtern_mitglieder" in termin)
        termin["filtern_mitglieder"] = Liste_SqlFiltern2FilternZurueck(JSON.parse(termin["filtern_mitglieder"]), "mitglieder");
    else termin["filtern_mitglieder"] = new Array();
    let termin_kategorie_filtern_mitglieder;
    if (termin["kategorie"] in TERMINE_KATEGORIE_FILTERN_MITGLIEDER)
        termin_kategorie_filtern_mitglieder = Liste_SqlFiltern2FilternZurueck(
            TERMINE_KATEGORIE_FILTERN_MITGLIEDER[termin["kategorie"]],
            "mitglieder"
        );
    else termin_kategorie_filtern_mitglieder = new Array();
    let filtern_mitglieder_kombiniert;
    if (termin_kategorie_filtern_mitglieder.length > 0)
        if (termin["filtern_mitglieder"].length == 0) filtern_mitglieder_kombiniert = termin_kategorie_filtern_mitglieder;
        else
            filtern_mitglieder_kombiniert = [
                { verknuepfung: "&&", filtern: termin["filtern_mitglieder"].concat(termin_kategorie_filtern_mitglieder) },
            ];
    else filtern_mitglieder_kombiniert = termin["filtern_mitglieder"];
    $.each(Liste_TabelleGefiltertZurueck(filtern_mitglieder_kombiniert, "mitglieder"), function () {
        if (this["id"] == ICH["id"]) termin["ich_eingeladen"] = true;
    });
}
