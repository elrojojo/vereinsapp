function Schnittstelle_EventElementErgaenzenAufgaben(aufgabe) {
    if (aufgabe["erledigt"] === null) aufgabe["erledigt_janein"] = false;
    else aufgabe["erledigt_janein"] = true;
}
