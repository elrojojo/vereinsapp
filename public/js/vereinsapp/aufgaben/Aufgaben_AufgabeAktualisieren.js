function Aufgaben_AufgabeAktualisieren($aufgabe) {
    const element_id = Number($aufgabe.attr("data-element_id"));
    const mitglied_id_eingeplant = Schnittstelle_VariableRausZurueck("mitglied_id_eingeplant", element_id, "aufgaben");
    const $btn_aufgabe_mitglied_einplanen = $aufgabe.find(".btn_aufgabe_mitglied_einplanen");

    $btn_aufgabe_mitglied_einplanen.attr("data-aufgabe_id", element_id);
    if (mitglied_id_eingeplant === null) {
        if (!Mitglieder_MitgliedBesitztRechtZurueck("aufgaben.verwaltung", ICH["id"]))
            $btn_aufgabe_mitglied_einplanen.removeClass("auswahl_oeffnen").addClass("bestaetigung_einfordern").removeClass("disabled");
        else $btn_aufgabe_mitglied_einplanen.addClass("auswahl_oeffnen").removeClass("bestaetigung_einfordern").removeClass("disabled");
        $btn_aufgabe_mitglied_einplanen.removeClass("disabled");
        $btn_aufgabe_mitglied_einplanen
            .addClass("btn-outline-primary")
            .removeClass("btn-primary")
            .html('<i class="bi bi-' + SYMBOLE["erstellen"]["bootstrap"] + '"></i>');
    } else {
        if (!Mitglieder_MitgliedBesitztRechtZurueck("aufgaben.verwaltung", ICH["id"])) {
            $btn_aufgabe_mitglied_einplanen.removeClass("auswahl_oeffnen").addClass("bestaetigung_einfordern");
            if (mitglied_id_eingeplant == ICH["id"]) $btn_aufgabe_mitglied_einplanen.removeClass("disabled");
            else $btn_aufgabe_mitglied_einplanen.addClass("disabled");
        } else $btn_aufgabe_mitglied_einplanen.addClass("auswahl_oeffnen").removeClass("bestaetigung_einfordern").removeClass("disabled");
        $btn_aufgabe_mitglied_einplanen
            .removeClass("btn-outline-primary")
            .addClass("btn-primary")
            .text(Liste_ElementBeschriftungZurueck(mitglied_id_eingeplant, "mitglieder"));
    }
}
