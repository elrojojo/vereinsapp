function Liste_SortierenErstellen($sortieren_definitionen, instanz, liste) {
    const $sortieren = $sortieren_definitionen.closest(".sortieren_formular").find(".sortieren");

    const sortieren = [
        {
            richtung: Number($sortieren_definitionen.find(".sortieren_richtung:checked").val()),
            eigenschaft: $sortieren_definitionen.find(".sortieren_eigenschaft").val(),
        },
    ];
    $sortieren.append(Liste_Sortieren2$SortierenZurueck(sortieren, instanz, liste));

    Liste_SortierenSpeichern($sortieren, instanz, liste);
}
