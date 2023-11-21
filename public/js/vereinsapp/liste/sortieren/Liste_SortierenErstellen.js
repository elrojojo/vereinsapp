function Liste_SortierenErstellen($btn_erstellen, liste) {
    const $formular = $btn_erstellen.parents(".sortieren_definitionen").first();
    const eigenschaft = $formular.find(".sortieren_eigenschaft").val();
    const richtung = Number($formular.find(".sortieren_richtung:checked").val());

    G.LISTEN[liste].sortieren.push({ richtung: richtung, eigenschaft: eigenschaft });

    Schnittstelle_EventVariableUpdLocalstorage(liste); // impliziert auch ein Schnittstelle_EventLocalstorageUpdVariable
}
