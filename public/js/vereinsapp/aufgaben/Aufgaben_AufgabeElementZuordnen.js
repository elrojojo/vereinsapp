function Aufgaben_AufgabeElementZuordnen(auswahl_einfordern, dom, title, liste) {
    if (auswahl_einfordern) Liste_ElementAuswahlEinfordern({ $ziel: dom.$ziel }, title, liste, "btn_aufgabe_element_zuordnen");
    else {
        const element_id = dom.$quelle.attr("data-element_id");
        const $ziel = $("#" + dom.$quelle.attr("data-ziel_id"));

        $ziel.val(element_id);
        if ("$modal" in dom && dom.$modal.exists()) Schnittstelle_DomModalSchliessen(dom.$modal);
    }
}
