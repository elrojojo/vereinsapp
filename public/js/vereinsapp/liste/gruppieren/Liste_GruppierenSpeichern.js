function Liste_GruppierenSpeichern($gruppieren_eigenschaft, instanz, liste) {
    const $btn_gruppieren_modal_oeffnen = Schnittstelle_DomLetztesWartendesModalZurueck().find(
        ".btn_gruppieren_modal_oeffnen[data-liste='" + liste + "']"
    );

    if (typeof instanz !== "undefined") {
        LISTEN[liste].instanz[instanz].gruppieren = $gruppieren_eigenschaft.val();
        Schnittstelle_EventAusfuehren(
            [Schnittstelle_EventVariableUpdLocalstorage, Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom],
            { liste: liste }
        );
    } else if ($btn_gruppieren_modal_oeffnen.exists()) $btn_gruppieren_modal_oeffnen.val($gruppieren_eigenschaft.val());
}
