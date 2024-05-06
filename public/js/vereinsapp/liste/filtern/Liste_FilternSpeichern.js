function Liste_FilternSpeichern($formular, instanz, liste) {
    const $btn_filtern_formular_oeffnen = Schnittstelle_DomLetztesWartendesModalZurueck().find(
        ".btn_filtern_formular_oeffnen[data-liste='" + liste + "']"
    );

    if (typeof instanz !== "undefined") {
        G.LISTEN[liste].instanz[instanz].filtern = Liste_$Filtern2FilternZurueck($formular.find(".filtern"), liste);
        Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    } else if ($btn_filtern_formular_oeffnen.exists())
        $btn_filtern_formular_oeffnen.val(JSON.stringify(Liste_$Filtern2FilternZurueck($formular.find(".filtern"), liste)));
}
