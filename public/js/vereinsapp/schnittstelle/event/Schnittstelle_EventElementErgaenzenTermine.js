function Schnittstelle_EventElementErgaenzenTermine(termin) {
    termin["ich_rueckmeldung_id"] = null;
    if ("rueckmeldungen" in G.LISTEN) {
        Schnittstelle_EventLocalstorageUpdVariable("rueckmeldungen");
        $.each(G.LISTEN.rueckmeldungen.tabelle, function () {
            const rueckmeldung = this;
            if ("id" in rueckmeldung) {
                if (rueckmeldung["termin_id"] == termin["id"] && rueckmeldung["mitglied_id"] == ICH["id"])
                    termin["ich_rueckmeldung_id"] = rueckmeldung["id"];
            }
        });
    }

    termin["ich_eingeladen"] = false;
    if (typeof termin["filtern_mitglieder"] !== "undefined")
        termin["filtern_mitglieder"] = Liste_SqlFiltern2FilternZurueck(JSON.parse(termin["filtern_mitglieder"]), "mitglieder");
    else termin["filtern_mitglieder"] = new Array();
    $.each(Liste_TabelleGefiltertZurueck(termin["filtern_mitglieder"], "mitglieder"), function () {
        const mitglied = this;
        if (mitglied["id"] == ICH["id"]) termin["ich_eingeladen"] = true;
    });
}
