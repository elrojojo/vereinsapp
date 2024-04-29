function Liste_FilternAktualisieren($formular, liste) {
    // FILTERN INSTANZEN AKTUALISIEREN
    $.each(G.LISTEN[liste].instanz, function (instanz) {
        $formular.find('.filtern[data-instanz="' + instanz + '"]').each(function () {
            const $filtern = $(this);
            $filtern.html(Liste_Filtern2$FilternZurueck(G.LISTEN[liste].instanz[instanz].filtern, liste));
            $filtern.find(".btn_filtern_aendern, .btn_filtern_loeschen").attr("data-liste", liste).attr("data-instanz", instanz);
        });
    });

    // FILTERN EIGENSCHAFTEN AKTUALISIEREN
    $formular.find('.filtern[data-liste="' + liste + '"][data-eigenschaft^="filtern_"]').each(function () {
        const $filtern = $(this);
        const eigenschaft = $filtern.attr("data-eigenschaft");
        const element_id = $filtern.attr("data-element_id");
        $filtern.html(Liste_Filtern2$FilternZurueck(Schnittstelle_VariableRausZurueck(eigenschaft, element_id, liste), liste));
        $filtern.find(".btn_filtern_aendern, .btn_filtern_loeschen").attr("data-liste", liste).attr("data-eigenschaft", eigenschaft);
        if (typeof element_id !== "undefined") $filtern.find(".btn_filtern_aendern, .btn_filtern_loeschen").attr("data-element_id", element_id);
    });
}
