function Liste_ElementCheckAktualisieren($check, $element, liste) {
    const $liste = $check.parents(".liste").first();

    const filtern = [
        {
            verknuepfung: "&&",
            filtern: [
                { operator: "==", eigenschaft: $liste.attr("data-gegen_element") + "_id", wert: Number($liste.attr("data-gegen_element_id")) },
                { operator: "==", eigenschaft: $element.attr("data-element") + "_id", wert: Number($check.val()) },
            ],
        },
    ];
    const gefilterte_tabelle = Liste_TabelleGefiltertZurueck(filtern, $check.attr("name"));

    $check.attr("checked", gefilterte_tabelle.length > 0);
}
