G.LISTEN.abwesenheiten = {
    controller: "mitglieder",
    element: "abwesenheit",
    verlinkte_listen: ["mitglieder"],
};

G.LISTEN.mitglieder = {
    controller: "mitglieder",
    element: "mitglied",
    verlinkte_listen: [],
};

$(document).ready(function () {
    G.LISTEN.mitglieder.$blanko_permission = $(".permissions").find(".blanko").first();
    $(".permissions").empty();

    // PERMISSIONS IM DOM AKTUALISIEREN
    $(document).on("VAR_upd_DOM_mitglieder", function () {
        // PERMISSIONS AKTUALISIEREN
        $(".permissions").each(function () {
            Mitglieder_PermissionsAktualisieren($(this), "mitglieder");
        });

        // PERMISSION AKTUALISIEREN
        $(".permission").each(function () {
            Mitglieder_PermissionAktualisieren($(this), "mitglieder");
        });
    });

    // PERMISSIONS ÄNDERN
    $(document).on("change", ".check_permission", function () {
        Mitglieder_PermissionAendern($(this), "mitglieder");
    });
});
