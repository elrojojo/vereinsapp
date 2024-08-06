function Liste_CheckAendern($check) {
    Schnittstelle_CheckWartenStart($check);

    const $element = $check.closest(".element");
    const liste = $element.attr("data-liste");
    const gegen_liste = $element.attr("data-gegen_liste");
    const checkliste = $check.attr("name");

    const ajax_data = new Object();
    ajax_data[LISTEN[liste].element + "_id"] = Number($check.val());
    ajax_data[LISTEN[gegen_liste].element + "_id"] = Number($element.attr("data-gegen_element_id"));
    ajax_data.status = Number($check.is(":checked"));

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: LISTEN[checkliste].controller + "/ajax_" + LISTEN[checkliste].element + "_speichern",
        data: ajax_data,
        liste: liste,
        $check: $check,
        rein_validation_pos_aktion: function (AJAX) {
            const $element = $check.closest(".element");
            const liste = AJAX.liste;
            const gegen_liste = $element.attr("data-gegen_liste");
            const checkliste = AJAX.$check.attr("name");
            
            const element = LISTEN[liste].element;
            const element_id = AJAX.data[element + "_id"];
            const gegen_element = LISTEN[gegen_liste].element;
            const gegen_element_id = AJAX.data[gegen_element + "_id"];

            // bereits vorhandene identische Einträge in der Checkliste werden gelöscht
            $.each(LISTEN[checkliste].tabelle, function () {
                const checkliste_element = this;
                if ("id" in checkliste_element) {
                    if (checkliste_element[element + "_id"] == element_id && checkliste_element[gegen_element + "_id"] == gegen_element_id)
                        Schnittstelle_VariableLoeschen(checkliste_element["id"], checkliste);
                }
            });

            // Falls der Haken gesetzt wurde, wird ein neuer Eintrag hinzugefügt
            if (AJAX.data.status) {
                if (LISTEN[checkliste].element + "_id" in AJAX.antwort && typeof AJAX.antwort[LISTEN[checkliste].element + "_id"] !== "undefined")
                    AJAX.data.id = Number(AJAX.antwort[LISTEN[checkliste].element + "_id"]);
                else AJAX.data.id = Number(LISTEN[checkliste].tabelle.length + 1);

                LISTEN[checkliste].tabelle[AJAX.data.id] = new Object();
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, AJAX.data.id, checkliste);
                });
            }

            Schnittstelle_EventVariableUpdLocalstorage(checkliste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
            Schnittstelle_CheckWartenEnde(AJAX.$check);
        },
        rein_validation_neg_aktion: function (AJAX) {
            Schnittstelle_DomToastFeuern("Beim Speichern ist ein Fehler aufgetreten!", "danger");
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
