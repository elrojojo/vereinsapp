function Aufgaben_AufgabeAktualisieren($aufgabe) {
    const element_id = Number($aufgabe.attr("data-element_id"));

    const mitglied_id_geplant = Schnittstelle_VariableRausZurueck("mitglied_id_geplant", element_id, "aufgaben");
    const $btn_btn_aufgabe_zuweisen = $aufgabe.find(".btn_aufgabe_zuweisen");

    $btn_btn_aufgabe_zuweisen.attr("data-element_id", element_id);

    if (mitglied_id_geplant !== null) {
        $btn_btn_aufgabe_zuweisen
            .addClass("btn-primary")
            .removeClass("btn-outline-primary")
            .text(Liste_ElementBeschriftungZurueck(mitglied_id_geplant, "mitglieder"));
    } else
        $btn_btn_aufgabe_zuweisen
            .addClass("btn-outline-primary")
            .removeClass("btn-primary")
            .html('<i class="bi bi-' + SYMBOLE["erstellen"]["bootstrap"] + '"></i>');
}
