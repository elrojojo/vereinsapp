function Liste_SortierenErstellen($btn) {
    const liste = $btn.attr("data-liste");
    const $formular = $btn.closest(".modal.sortieren");

    const $sortieren = $formular.find(".sortieren");
    const $sortieren_definitionen = $btn.closest(".sortieren_definitionen");

    const sortieren = [
        {
            richtung: Number($sortieren_definitionen.find(".sortieren_richtung:checked").val()),
            eigenschaft: $sortieren_definitionen.find(".sortieren_eigenschaft").val(),
        },
    ];
    $sortieren.append(Liste_Sortieren2$SortierenZurueck(sortieren, liste));
}
