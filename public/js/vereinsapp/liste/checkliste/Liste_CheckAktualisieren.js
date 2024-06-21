function Liste_CheckAktualisieren($check, element_id, elemente_disabled, liste) {
    const $checkliste = $check.closest('.checkliste[data-liste="' + liste + '"]');
    const $label = $check.closest("label");

    $check.attr("id", element_id).val(element_id);

    let check_element_array = new Array();
    if ($checkliste.exists())
        check_element_array = Liste_TabelleGefiltertZurueck(
            [
                {
                    verknuepfung: "&&",
                    filtern: [
                        {
                            operator: "==",
                            eigenschaft: LISTEN[$checkliste.attr("data-gegen_liste")].element + "_id",
                            wert: Number($checkliste.attr("data-gegen_element_id")),
                        },
                        { operator: "==", eigenschaft: LISTEN[liste].element + "_id", wert: element_id },
                    ],
                },
            ],
            $checkliste.attr("data-checkliste")
        );

    // Check setzen
    $check.attr("checked", check_element_array.length > 0);

    // Label mit dem Check verknüpfen
    $label.attr("for", element_id);

    // Check ggf. ausgrauen
    if (elemente_disabled.length > 0 && elemente_disabled.includes(element_id)) {
        $check.attr("disabled", true);
        $label.removeAttr("role");
    } else {
        $check.attr("disabled", false);
        $label.attr("role", "button");
    }
}
