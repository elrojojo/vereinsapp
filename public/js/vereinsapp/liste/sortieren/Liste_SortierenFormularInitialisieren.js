function Liste_SortierenFormularInitialisieren($formular, instanz, liste) {
    const $sortieren_definitionen = $formular.find(".sortieren_definitionen");
    $sortieren_definitionen.find(".btn_sortieren_erstellen").attr("data-liste", liste).attr("data-instanz", instanz);

    const $sortieren_eigenschaft = $sortieren_definitionen.find(".sortieren_eigenschaft");
    $sortieren_eigenschaft.empty();
    $.each(SORTIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[liste][eigenschaft].beschriftung + "</option>").appendTo($sortieren_eigenschaft);
    });

    const sortieren_value = Schnittstelle_DomLetztesModalZurueck()
        .find(".btn_sortieren_modal_oeffnen[data-liste='" + liste + "']")
        .val();
    if (isJson(sortieren_value))
        $formular
            .find(".sortieren")
            .append(Liste_Sortieren2$SortierenZurueck(Schnittstelle_VariableArrayBereinigtZurueck(JSON.parse(sortieren_value)), undefined, liste));
    else $formular.find(".sortieren").append(Liste_Sortieren2$SortierenZurueck(LISTEN[liste].instanz[instanz].sortieren, instanz, liste));
}
