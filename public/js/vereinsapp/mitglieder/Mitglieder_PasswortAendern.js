function Mitglieder_PasswortAendern(dom, data, mitglied_id) {
    if (typeof mitglied_id !== "undefined") mitglied_id = Number(mitglied_id);

    Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

    const ajax_dom = dom;
    const ajax_data = data;
    ajax_data.id = mitglied_id;
    console.log(ajax_data);
    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "mitglieder/ajax_mitglied_passwort_aendern",
        data: ajax_data,
        liste: "mitglieder",
        dom: ajax_dom,
        rein_validation_pos_aktion: function (AJAX) {
            if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists()) AJAX.dom.$formular.find(".eigenschaft").val("");
            if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
            Schnittstelle_DomToastFeuern("Du hast erfolgreich das Passwort geändert.");
        },
        rein_validation_neg_aktion: function (AJAX) {
            if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
            if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
