function Mitglieder_EinmalLinkErstellen($btn) {
    const liste = $btn.attr("data-liste");
    // const element = G.LISTEN[liste].element;
    const element_id = $btn.attr("data-element_id");
    // const aktion = $btn.attr("data-aktion");
    const data_werte = $btn.attr("data-werte");

    const AJAX_DATA = new Object();
    if (typeof element_id !== "undefined") AJAX_DATA.id = Number(element_id);
    if (typeof data_werte !== "undefined")
        $.each(JSON.parse(data_werte), function (eigenschaft, wert) {
            AJAX_DATA[eigenschaft] = wert;
        });

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: "mitglied_einmal_link_erstellen",
        url: G.LISTEN[liste].controller + "/ajax_mitglied_einmal_link_erstellen",
        data: AJAX_DATA,
        liste: liste,
        $btn: $btn,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            if (AJAX.data.email) {
                console.log("link zugeschickt.");

                Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                const $formular = AJAX.$btn.closest(".formular");
                $formular.modal("hide");
            } else {
                const $formular = AJAX.$btn.closest(".formular");
                const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
                const btn_dismiss_beschriftung = $btn_dismiss.text();

                $formular.find(".einmal_link").val(AJAX.antwort.einmal_link);
                $formular.find(".btn_mitglied_einmal_link_anzeigen").addClass("invisible");
                $btn_dismiss.attr("data-beschriftung", btn_dismiss_beschriftung);
                $btn_dismiss.removeClass("btn-outline-danger").addClass("btn-outline-primary").text("Schließen");

                Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);
            }
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
