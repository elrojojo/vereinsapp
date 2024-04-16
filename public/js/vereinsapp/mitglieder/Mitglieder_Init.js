G.LISTEN.verfuegbare_rechte = {
    controller: "mitglieder",
    element: "verfuegbares_recht",
};

G.LISTEN.vergebene_rechte = {
    controller: "mitglieder",
    element: "vergebenes_recht",
    verlinkte_listen: ["mitglieder", "verfuegbare_rechte"],
};

G.LISTEN.mitglieder = {
    controller: "mitglieder",
    element: "mitglied",
    beschriftung: [{ eigenschaft: "vorname" }, { eigenschaft: "nachname", prefix: " " }],
    verlinkte_listen: [],
    abhaengig_von: [],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenMitglieder,
};

function Mitglieder_Init() {
    // MITGLIED ERSTELLEN
    $(document).on("click", ".btn_mitglied_erstellen", function () {
        Mitglieder_MitgliedErstellen($(this));
    });

    // MITGLIED ÄNDERN
    $(document).on("click", ".btn_mitglied_aendern", function () {
        Mitglieder_MitgliedAendern($(this));
    });

    // MITGLIED DUPLIZIEREN
    $(document).on("click", ".btn_mitglied_duplizieren", function () {
        Mitglieder_MitgliedErstellen($(this));
    });

    // MITGLIED LÖSCHEN
    $(document).on("click", ".btn_mitglied_loeschen", function () {
        Liste_ElementLoeschen($(this));
    });

    // PASSWORT ÄNDERN
    $(document).on("click", ".btn_mitglied_passwort_aendern", function () {
        Mitglieder_PasswortAendern($(this));
    });

    // PASSWORT FESTLEGEN (MODAL) ÖFFNEN
    if (FORCE_PASSWORD_RESET) {
        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_passwort_festlegen_modal",
            rein_validation_pos_aktion: function (AJAX) {
                $("#modals").append(AJAX.antwort.html);
                Liste_ElementFormularOeffnen($("#mitglied_passwort_festlegen_modal"), "mitglieder", "passwort_festlegen");
            },
        };
        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }

    // PASSWORT FESTLEGEN
    $(document).on("click", ".btn_mitglied_passwort_festlegen", function () {
        Mitglieder_PasswortFestlegen($(this));
    });

    // FORMULAR EINMAL-LINK ANZEIGEN (MODAL) ÖFFNEN
    $(document).on("show.bs.modal", "#mitglied_einmal_link_anzeigen_modal", function () {
        const $formular = $(this);
        const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
        const btn_dismiss_beschriftung = $btn_dismiss.attr("data-beschriftung");

        $formular.find(".einmal_link").val("");
        $formular.find(".btn_mitglied_einmal_link_erstellen").removeClass("invisible");

        if (typeof btn_dismiss_beschriftung !== "undefined") $btn_dismiss.text(btn_dismiss_beschriftung);
        $btn_dismiss.addClass("btn-outline-danger").removeClass("btn-outline-primary");
    });

    // EINMAL-LINK ANZEIGEN
    $(document).on("click", ".btn_mitglied_einmal_link_anzeigen", function () {
        Mitglieder_EinmalLinkAnzeigen($(this));
    });

    // EINMAL-LINK PER EMAIL VERSCHICKEN
    $(document).on("click", ".btn_mitglied_einmal_link_email", function () {
        Mitglieder_EinmalLinkEmail($(this));
    });
}
