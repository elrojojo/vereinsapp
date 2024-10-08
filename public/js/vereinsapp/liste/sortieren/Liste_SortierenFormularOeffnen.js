function Liste_SortierenFormularOeffnen(data, liste) {
    if (typeof data === "undefined") data = new Object();

    if (!("instanz" in data)) data.instanz = undefined;
    const instanz = data.instanz;

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    const sortieren_value = Schnittstelle_DomLetztesModalZurueck()
        .find(".btn_sortieren_oeffnen[data-liste='" + liste + "']")
        .val();

    const $neues_sortieren_formular = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "sortieren");

    const $sortieren_definitionen = $neues_sortieren_formular.find(".sortieren_definitionen");
    $sortieren_definitionen.find(".btn_sortieren_erstellen").attr("data-liste", liste).attr("data-instanz", instanz);

    const $sortieren_eigenschaft = $sortieren_definitionen.find(".sortieren_eigenschaft");
    $sortieren_eigenschaft.empty();
    $.each(SORTIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[liste][eigenschaft].beschriftung + "</option>").appendTo($sortieren_eigenschaft);
    });

    if (typeof instanz !== "undefined")
        $neues_sortieren_formular
            .find(".sortieren")
            .append(Liste_Sortieren2$SortierenZurueck(LISTEN[liste].instanz[instanz].sortieren, instanz, liste));
    else if (isJson(sortieren_value))
        $neues_sortieren_formular
            .find(".sortieren")
            .append(Liste_Sortieren2$SortierenZurueck(Schnittstelle_VariableArrayBereinigtZurueck(JSON.parse(sortieren_value)), undefined, liste));

    Schnittstelle_DomModalOeffnen($neues_sortieren_formular);
}
