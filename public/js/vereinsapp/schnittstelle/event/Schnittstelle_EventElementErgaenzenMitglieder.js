function Schnittstelle_EventElementErgaenzenMitglieder(mitglied) {
    if ("geburt" in mitglied) {
        mitglied["alter"] = -1 * mitglied["geburt"].diffNow("years").years;

        mitglied["geburtstag"] = DateTime.fromFormat(mitglied["geburt"].toFormat("dd.MM.") + DateTime.now().toFormat("yyyy"), "dd.MM.yyyy");
        if (mitglied["geburtstag"] < DateTime.now().startOf("day"))
            mitglied["geburtstag"] = mitglied["geburtstag"].plus({
                years: 1,
            });

        mitglied["alter_geburtstag"] = mitglied["geburtstag"].diff(mitglied["geburt"], "years").years;
    }
}
