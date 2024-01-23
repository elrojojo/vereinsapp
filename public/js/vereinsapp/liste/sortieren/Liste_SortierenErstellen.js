function Liste_SortierenErstellen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    // const eigenschaft = $btn.attr("data-eigenschaft");
    // const sortieren_liste = $btn.attr("data-sortieren_liste");
    // const element_id = $btn.attr("data-element_id");
    const $formular = $btn.closest(".modal");

    const $sortieren_definitionen = $btn.closest(".sortieren_definitionen");

    G.LISTEN[liste].instanz[instanz].sortieren.push({
        richtung: Number($sortieren_definitionen.find(".sortieren_richtung:checked").val()),
        eigenschaft: $sortieren_definitionen.find(".sortieren_eigenschaft").val(),
    });

    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);

    Liste_SortierenAktualisieren($formular, liste);
}
