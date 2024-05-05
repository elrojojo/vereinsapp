function Liste_SortierenSpeichern($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const $formular = $btn.closest(".modal.sortieren");
    const $btn_sortieren_formular_oeffnen = Schnittstelle_DomLetztesWartendesModalZurueck().find(
        ".btn_sortieren_formular_oeffnen[data-liste='" + liste + "']"
    );

    if (typeof instanz !== "undefined") {
        G.LISTEN[liste].instanz[instanz].sortieren = Liste_$Sortieren2SortierenZurueck($formular.find(".sortieren"), liste);
        Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    } else if ($btn_sortieren_formular_oeffnen.exists())
        $btn_sortieren_formular_oeffnen.val(JSON.stringify(Liste_$Sortieren2SortierenZurueck($formular.find(".sortieren"), liste)));

    Schnittstelle_DomModalSchliessen($formular);
}
