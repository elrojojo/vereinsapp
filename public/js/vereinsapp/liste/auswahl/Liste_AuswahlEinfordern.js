function Liste_AuswahlEinfordern(dom, title, liste, klasse_id, data) {
    if (typeof data === "undefined") data = new Object();

    const ziel_id = zufaelligeZeichenketteZurueck(8);
    if ("$ziel" in dom && dom.$ziel.exists()) dom.$ziel.attr("id", ziel_id);
    data.ziel_id = ziel_id;

    const $neues_auswahl_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(
        ELEMENTE[LISTEN[liste].element].beschriftung + " " + title,
        "AUSWAHL"
    );
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
