function Aufgaben_AufgabeAktualisieren($aufgabe) {
    const aufgabe_id = Number($aufgabe.attr("data-element_id"));
    const mitglied_id = Schnittstelle_VariableRausZurueck("mitglied_id", aufgabe_id, "aufgaben");
    const $btn_aufgabe_mitglied_einplanen = $aufgabe.find(".btn_aufgabe_mitglied_einplanen");
    const $btn_aufgabe_mitglied_ausplanen = $aufgabe.find(".btn_aufgabe_mitglied_ausplanen");
    const $btn_aufgabe_erledigen = $aufgabe.find(".btn_aufgabe_erledigen");

    const $btn_group = $btn_aufgabe_mitglied_einplanen.closest(".btn-group");
    const $btn_group_invisible = $btn_aufgabe_mitglied_ausplanen.closest(".btn-group.invisible");

    $btn_aufgabe_mitglied_einplanen.attr("data-aufgabe_id", aufgabe_id);
    $btn_aufgabe_mitglied_ausplanen.attr("data-aufgabe_id", aufgabe_id);
    $btn_aufgabe_erledigen.attr("data-aufgabe_id", aufgabe_id);

    if (typeof mitglied_id === "undefined" || mitglied_id === null) {
        // Wenn kein Mitglied eingeplant ist
        if (Mitglieder_MitgliedBesitztRechtZurueck("aufgaben.verwaltung", ICH["id"])) {
            // Wenn das Recht zur Verwaltung der Aufgaben erteilt ist
            $btn_aufgabe_mitglied_einplanen.addClass("auswahl_oeffnen").removeClass("bestaetigung_einfordern").removeClass("disabled");
        } else {
            // Wenn das Recht zur Verwaltung der Aufgaben nicht erteilt ist
            $btn_aufgabe_mitglied_einplanen.removeClass("auswahl_oeffnen").addClass("bestaetigung_einfordern").removeClass("disabled");
        }

        $btn_aufgabe_mitglied_ausplanen.appendTo($btn_group_invisible);

        $btn_aufgabe_mitglied_einplanen
            .addClass("btn-outline-primary")
            .removeClass("btn-primary")
            .html('<i class="bi bi-' + SYMBOLE["erstellen"]["bootstrap"] + '"></i>');
    } else {
        // Wenn ein Mitglied eingeplant ist
        if (Mitglieder_MitgliedBesitztRechtZurueck("aufgaben.verwaltung", ICH["id"])) {
            // Wenn das Recht zur Verwaltung der Aufgaben erteilt ist
            $btn_aufgabe_mitglied_einplanen.addClass("auswahl_oeffnen").removeClass("bestaetigung_einfordern").removeClass("disabled");
            $btn_aufgabe_mitglied_ausplanen.appendTo($btn_group);
        } else if (mitglied_id == ICH["id"]) {
            // Wenn ich als Mitglied eingeplant bin
            $btn_aufgabe_mitglied_einplanen.removeClass("auswahl_oeffnen").addClass("bestaetigung_einfordern").addClass("disabled");
            $btn_aufgabe_mitglied_ausplanen.appendTo($btn_group);
        } else {
            // Wenn das Recht zur Verwaltung der Aufgaben nicht erteilt ist und ich nicht eingeplant bin
            $btn_aufgabe_mitglied_einplanen.removeClass("auswahl_oeffnen").addClass("bestaetigung_einfordern").addClass("disabled");
            $btn_aufgabe_mitglied_ausplanen.appendTo($btn_group_invisible);
        }

        $btn_aufgabe_mitglied_einplanen
            .removeClass("btn-outline-primary")
            .addClass("btn-primary")
            .text(Liste_ElementBeschriftungZurueck(mitglied_id, "mitglieder"));
    }
}
