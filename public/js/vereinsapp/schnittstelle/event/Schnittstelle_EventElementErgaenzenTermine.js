function Schnittstelle_EventElementErgaenzenTermine(element) {
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
        element["filtern_mitglieder"] = Liste_SqlFiltern2FilternZurueck(JSON.parse(element["filtern_mitglieder"]), "mitglieder");
    else element["filtern_mitglieder"] = new Array();
    element["ich_eingeladen"] = false;
    $.each(Liste_TabelleGefiltertZurueck(element["filtern_mitglieder"], "mitglieder"), function () {
        const mitglied = this;
        if (mitglied["id"] == ICH["id"]) element["ich_eingeladen"] = true;
    });
}
