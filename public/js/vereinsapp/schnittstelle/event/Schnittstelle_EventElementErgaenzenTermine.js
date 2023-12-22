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
    $.each(Liste_TabelleGefiltertZurueck(termin["filtern_mitglieder"], "mitglieder"), function () {
        const mitglied = this;
        if (mitglied["id"] == ICH["id"]) termin["ich_eingeladen"] = true;
    });
}
