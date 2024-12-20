function Aufgaben_AufgabeElementZuordnen(auswahl_einfordern, dom, title, liste) {
    if (auswahl_einfordern) Liste_ElementAuswahlEinfordern({ $ziel: dom.$ziel }, title, liste, "btn_element_zuordnen");
    else {
        const element_id = dom.$quelle.attr("data-element_id");
        const $ziel = $("#" + dom.$quelle.attr("data-ziel_id"));
        const eingabe = $ziel.attr("data-eingabe");

        $ziel.val(element_id).removeAttr("id");
        EIGENSCHAFTEN.aufgaben[eingabe].change_aktion($ziel);

        if ("$modal" in dom && dom.$modal.exists()) Schnittstelle_DomModalSchliessen(dom.$modal);
    }
}
