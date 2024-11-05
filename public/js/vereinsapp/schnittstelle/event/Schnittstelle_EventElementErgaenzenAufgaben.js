function Schnittstelle_EventElementErgaenzenAufgaben(aufgabe) {
    if (aufgabe["erledigt"] === null) aufgabe["erledigt_janein"] = false;
    else aufgabe["erledigt_janein"] = true;

    if (aufgabe["liste"] !== null && aufgabe["element_id"] !== null) aufgabe["element"] = { liste: aufgabe["liste"], id: aufgabe["element_id"] };
    // else aufgabe["element"] = null;
}
