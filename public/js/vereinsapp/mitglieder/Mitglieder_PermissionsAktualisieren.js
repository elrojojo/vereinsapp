function Mitglieder_PermissionsAktualisieren($permissions, liste) {
    // DOM LÖSCHEN
    $permissions.find(".permission").each(function () {
        if (!($(this).find(".form-check-input").val() in PERMISSIONS))
            $(this).remove();
    });

    // DOM ERGÄNZEN
    $.each(PERMISSIONS, function (permission, beschriftung) {
        if (
            !$permissions
                .find('[value="' + permission + '"]')
                .parents(".permission")
                .first()
                .exists()
        ) {
            const $neue_permission = LISTEN[liste].$blanko_permission
                .clone()
                .removeClass("blanko invisible")
                .addClass("permission");

            $neue_permission.find("label").attr("for", permission);
            $neue_permission
                .find(".check_permission")
                .attr("id", permission)
                .val(permission);
            $neue_permission.appendTo($permissions);
        }
    });

    // ÜBERSCHRIFTEN EIN-/AUSBLENDEN
    if ($permissions.children().length == 0)
        $permissions
            .prev(
                '.ueberschrift[data-liste_id="' + $permissions.attr("id") + '"]'
            )
            .addClass("invisible");
    else
        $permissions
            .prev(
                '.ueberschrift[data-liste_id="' + $permissions.attr("id") + '"]'
            )
            .removeClass("invisible");
}
