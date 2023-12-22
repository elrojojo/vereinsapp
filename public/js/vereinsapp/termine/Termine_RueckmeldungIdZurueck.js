function Termine_RueckmeldungIdZurueck(termin_id, mitglied_id) {
    let rueckmeldung_id = null;

    $.each(G.LISTEN.rueckmeldungen.tabelle, function () {
        const rueckmeldung = this;
        if ("id" in rueckmeldung)
            if (rueckmeldung.termin_id == termin_id && rueckmeldung.mitglied_id == mitglied_id) {
                rueckmeldung_id = Number(rueckmeldung.id);
                return false;
            }
    });

    return rueckmeldung_id;
}
