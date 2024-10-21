function Aufgaben_AufgabeAktualisieren($aufgabe) {
    const element_id = Number($aufgabe.attr("data-element_id"));

    const mitglied_id_geplant = Schnittstelle_VariableRausZurueck("mitglied_id_geplant", element_id, "aufgaben");
    const $btn_aufgabe_zuweisen = $aufgabe.find(".btn_aufgabe_zuweisen");

    $btn_aufgabe_zuweisen.attr("data-element_id", element_id);

    if (mitglied_id_geplant !== null) {
        if (!Mitglieder_MitgliedBesitztRechtZurueck("aufgaben.verwaltung", ICH["id"])) $btn_aufgabe_zuweisen.addClass("disabled");
        $btn_aufgabe_zuweisen
            .removeClass("btn-outline-primary")
            .addClass("btn-primary")
            .text(Liste_ElementBeschriftungZurueck(mitglied_id_geplant, "mitglieder"));
    } else
        $btn_aufgabe_zuweisen
            .removeClass("disabled")
            .addClass("btn-outline-primary")
            .removeClass("btn-primary")
            .html('<i class="bi bi-' + SYMBOLE["erstellen"]["bootstrap"] + '"></i>');
}
