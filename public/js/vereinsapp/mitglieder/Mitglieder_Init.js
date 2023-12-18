G.LISTEN.abwesenheiten = {
    $blanko_element: new Object(),
    instanz: new Object(),
    controller: "mitglieder",
    element: "abwesenheit",
    verlinkte_listen: ["mitglieder"],
};

G.LISTEN.mitglieder = {
    $blanko_element: new Object(),
    instanz: new Object(),
    controller: "mitglieder",
    element: "mitglied",
    verlinkte_listen: [],
    abhaengig_von: ["abwesenheiten"],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenMitglieder,
};

function Mitglieder_Init() {
    G.LISTEN.mitglieder.$blanko_permission = $(".permissions").find(".blanko").first();
    $(".permissions").empty();

    // PERMISSIONS ÄNDERN
    $(document).on("change", ".check_permission", function () {
        Mitglieder_PermissionAendern($(this), "mitglieder");
    });
}
