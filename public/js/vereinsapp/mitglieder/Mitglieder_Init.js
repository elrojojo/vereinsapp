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

    // PERMISSIONS ÄNDERN
    $(document).on("change", ".check_permission", function () {
        Mitglieder_PermissionAendern($(this), "mitglieder");
    });
});
