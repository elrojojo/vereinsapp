function Liste_SortierenAktualisieren($formular, liste) {
    $.each(G.LISTEN[liste].instanz, function (instanz) {
        $formular.find('.sortieren[data-instanz="' + instanz + '"]').each(function () {
            const $sortieren = $(this);
            $sortieren.html(Liste_Sortieren2$SortierenZurueck(G.LISTEN[liste].instanz[instanz].sortieren, liste));
            $sortieren.find(".btn_sortieren_aendern, .btn_sortieren_loeschen").attr("data-liste", liste).attr("data-instanz", instanz);
        });
    });
}
