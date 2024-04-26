function Liste_SortierenErstellen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    // const eigenschaft = $btn.attr("data-eigenschaft");
    // let sortieren_liste = $btn.attr("data-sortieren_liste");
    // if (typeof sortieren_liste === "undefined")
    const sortieren_liste = liste;
    // const element_id = $btn.attr("data-element_id");
    const $formular = $btn.closest(".modal.sortieren");

    const $sortieren = $formular.find(".sortieren");
    const $sortieren_definitionen = $btn.closest(".sortieren_definitionen");

    const sortieren = [
        {
            richtung: Number($sortieren_definitionen.find(".sortieren_richtung:checked").val()),
            eigenschaft: $sortieren_definitionen.find(".sortieren_eigenschaft").val(),
        },
    ];
    $sortieren.append(Liste_Sortieren2$SortierenZurueck(sortieren, sortieren_liste));

    // if (typeof instanz !== "undefined") {
    G.LISTEN[liste].instanz[instanz].sortieren = Liste_$Sortieren2SortierenZurueck($sortieren, sortieren_liste);
    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    // }

    Liste_SortierenAktualisieren($formular, liste);
}
