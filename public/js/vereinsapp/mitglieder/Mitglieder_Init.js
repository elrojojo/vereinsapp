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
    // FORMULAR EINMAL-LINK EMAIL (MODAL) ÖFFNEN
    $("#mitglied_einmal_link_email_Modal").on("show.bs.modal", function () {
        const $formular = $(this);
        const $btn_oeffnend = G.MODALS.offen[G.MODALS.offen.length - 1].$btn_oeffnend;
        const element_id = Number($btn_oeffnend.attr("data-element_id"));

        $formular
            .find(".btn_mitglied_einmal_link_email")
            .attr("data-email", JSON.stringify({ email: G.LISTEN.mitglieder.tabelle[element_id].email }));
    });

    // EINMAL-LINK EMAIL ZUSCHICKEN
    $(document).on("click", ".btn_mitglied_einmal_link_email", function () {
        Mitglieder_EinmalLinkEmail($(this));
    });
}
