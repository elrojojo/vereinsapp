function Liste_FilternSpeichern($filtern, instanz, liste) {
    const $btn_filtern_modal_oeffnen = Schnittstelle_DomLetztesWartendesModalZurueck().find(".btn_filtern_modal_oeffnen[data-liste='" + liste + "']");

    if (typeof instanz !== "undefined") {
        LISTEN[liste].instanz[instanz].filtern = Liste_$Filtern2FilternZurueck($filtern, liste);
        Schnittstelle_EventAusfuehren(
            [Schnittstelle_EventVariableUpdLocalstorage, Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom],
            { liste: liste }
        );
    } else if ($btn_filtern_modal_oeffnen.exists()) $btn_filtern_modal_oeffnen.val(JSON.stringify(Liste_$Filtern2FilternZurueck($filtern, liste)));
}
