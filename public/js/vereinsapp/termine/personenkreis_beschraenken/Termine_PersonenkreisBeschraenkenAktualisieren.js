function Termine_PersonenkreisBeschraenkenAktualisieren($personenkreis_beschraenken, liste) {
    const element_id = $personenkreis_beschraenken.attr("data-element_id");

    if (typeof element_id !== "undefined")
        $personenkreis_beschraenken.html(
            Liste_Filtern2$FilternZurueck(
                G.LISTEN[liste].tabelle[element_id].filtern_mitglieder,
                PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung,
                PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_element,
                "personenkreis_beschraenken",
                "mitglieder"
            )
        );
}
