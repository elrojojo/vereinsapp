G.LISTEN.verfuegbare_rechte = {
    controller: "mitglieder",
    element: "verfuegbares_recht",
};

G.LISTEN.vergebene_rechte = {
    controller: "mitglieder",
    element: "vergebenes_recht",
    verlinkte_listen: ["mitglieder", "verfuegbare_rechte"],
};

G.LISTEN.abwesenheiten = {
    controller: "mitglieder",
    element: "abwesenheit",
    verlinkte_listen: ["mitglieder"],
};

G.LISTEN.mitglieder = {
    controller: "mitglieder",
    element: "mitglied",
    verlinkte_listen: [],
    abhaengig_von: ["abwesenheiten"],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenMitglieder,
};

function Mitglieder_Init() {
    // PASSWORT FESTLEGEN MODAL
    if (FORCE_PASSWORD_RESET) {
        // SCHNITTSTELLE AJAX
        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            label: "mitglied_passwort_festlegen",
            url: "mitglieder/ajax_mitglied_passwort_festlegen_modal",
            rein_validation_pos_aktion: function (AJAX) {
                $("#modals").append(AJAX.antwort.html);
                $("#mitglied_passwort_festlegen_Modal").modal("show");
            },
        };
        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }

    // FORMULAR EINMAL-LINK ANZEIGEN (MODAL) ÖFFNEN
    $(document).on("show.bs.modal", "#mitglied_einmal_link_anzeigen_Modal", function () {
        const $formular = $(this);
        const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
        const btn_dismiss_beschriftung = $btn_dismiss.attr("data-beschriftung");

        $formular.find(".einmal_link").val("");
        $formular.find(".btn_mitglied_einmal_link_erstellen").removeClass("invisible");

        if (typeof btn_dismiss_beschriftung !== "undefined") $btn_dismiss.text(btn_dismiss_beschriftung);
        $btn_dismiss.addClass("btn-outline-danger").removeClass("btn-outline-primary");
    });

    // EINMAL-LINK ERSTELLEN
    $(document).on("click", ".btn_mitglied_einmal_link_erstellen", function () {
        Mitglieder_EinmalLinkErstellen($(this));
    });
}
