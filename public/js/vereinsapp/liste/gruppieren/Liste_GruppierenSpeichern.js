function Liste_GruppierenSpeichern($gruppieren_eigenschaft, instanz, liste) {
    const $btn_gruppieren_formular_oeffnen = Schnittstelle_DomLetztesWartendesModalZurueck().find(
        ".btn_gruppieren_formular_oeffnen[data-liste='" + liste + "']"
    );

    if (typeof instanz !== "undefined") {
        LISTEN[liste].instanz[instanz].gruppieren = $gruppieren_eigenschaft.val();
        Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    } else if ($btn_gruppieren_formular_oeffnen.exists()) $btn_gruppieren_formular_oeffnen.val($gruppieren_eigenschaft.val());
}
