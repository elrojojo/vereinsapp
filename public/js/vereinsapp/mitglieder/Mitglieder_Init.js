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
    // EINMAL-LINK EMAIL ANZEIGEN
    $(document).on("click", ".btn_mitglied_einmal_link_anzeigen", function () {
        Mitglieder_EinmalLinkAnzeigen($(this));
    });

    // FORMULAR EINMAL-LINK ANZEIGEN (MODAL) ÖFFNEN
    $("#mitglied_einmal_link_anzeigen_Modal").on("show.bs.modal", function () {
        const $formular = $(this);
        const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
        const btn_dismiss_beschriftung = $btn_dismiss.attr("data-beschriftung");

        $formular.find(".einmal_link").val("");
        $formular.find(".btn_mitglied_einmal_link_anzeigen").removeClass("invisible");

        if (typeof btn_dismiss_beschriftung !== "undefined") $btn_dismiss.text(btn_dismiss_beschriftung);
        $btn_dismiss.addClass("btn-outline-danger").removeClass("btn-outline-primary");
    });

    // EINMAL-LINK EMAIL ZUSCHICKEN
    $(document).on("click", ".btn_mitglied_einmal_link_email", function () {
        Mitglieder_EinmalLinkEmail($(this));
    });
}
