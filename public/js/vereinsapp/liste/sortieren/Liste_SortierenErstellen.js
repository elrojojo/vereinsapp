function Liste_SortierenErstellen($btn, liste) {
    const $formular = $btn.parents(".sortieren_definitionen").first();
    const eigenschaft = $formular.find(".sortieren_eigenschaft").val();
    const richtung = Number($formular.find(".sortieren_richtung:checked").val());

    G.LISTEN[liste].sortieren.push({ richtung: richtung, eigenschaft: eigenschaft });

    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
}
