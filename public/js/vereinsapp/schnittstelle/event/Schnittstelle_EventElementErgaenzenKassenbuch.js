function Schnittstelle_EventElementErgaenzenKassenbuch(kassenbucheintrag) {
    if (kassenbucheintrag["erledigt"] === null) kassenbucheintrag["erledigt_janein"] = false;
    else kassenbucheintrag["erledigt_janein"] = true;
}
