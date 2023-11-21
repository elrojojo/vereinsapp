function Schnittstelle_EventElementErgaenzenMitglieder(element) {
    if ("geburt" in element) {
        element["alter"] = -1 * element["geburt"].diffNow("years").years;

        element["geburtstag"] = DateTime.fromFormat(element["geburt"].toFormat("dd.MM.") + DateTime.now().toFormat("yyyy"), "dd.MM.yyyy");
        if (element["geburtstag"] < DateTime.now().startOf("day"))
            element["geburtstag"] = element["geburtstag"].plus({
                years: 1,
            });

        element["alter_geburtstag"] = element["geburtstag"].diff(element["geburt"], "years").years;
    }

    if ("abwesenheiten" in G.LISTEN) {
        element["abwesend"] = false;
        $.each(G.LISTEN.abwesenheiten.tabelle, function () {
            const abwesenheit = this;
            if ("id" in abwesenheit) {
                if (abwesenheit["mitglied_id"] == element["id"] && abwesenheit["start"] <= DateTime.now() && DateTime.now() <= abwesenheit["ende"])
                    element["abwesend"] = true;
            }
        });
    }
}
