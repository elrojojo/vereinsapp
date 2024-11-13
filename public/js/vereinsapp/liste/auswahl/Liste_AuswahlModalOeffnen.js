function Liste_AuswahlModalOeffnen(title, liste, klasse_id, data) {
    const $neues_auswahl_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "AUSWAHL");
    Liste_AuswahlListeInitialisieren(
        $neues_auswahl_modal.find("#AUSWAHLLISTE.liste"),
        $neues_auswahl_modal.find('.werkzeug[data-instanz="AUSWAHLLISTE"]'),
        $neues_auswahl_modal.find('.listenstatistik[data-instanz="AUSWAHLLISTE"]'),
        liste + "_auswahl",
        liste,
        klasse_id,
        data
    );
    Schnittstelle_DomModalOeffnen($neues_auswahl_modal);
    Schnittstelle_EventLocalstorageUpdVariable(liste, [Schnittstelle_EventVariableUpdDom]);
}
