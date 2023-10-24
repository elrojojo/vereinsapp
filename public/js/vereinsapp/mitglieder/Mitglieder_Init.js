LISTEN.abwesenheiten = {
    controller:'mitglieder',
    element:'abwesenheit',
};

LISTEN.mitglieder = {
    controller:'mitglieder',
    element:'mitglied',
};

$(document).ready( function() {

    LISTEN.mitglieder.$blanko_permission = $('.permissions').find('.blanko').first(); $('.permissions').empty();

    // PERMISSIONS IM DOM AKTUALISIEREN
    $(document).on( 'VAR_upd_DOM_mitglieder', function() {

        // PERMISSIONS AKTUALISIEREN
        $( '.permissions' ).each( function() {
            Mitglieder_PermissionsAktualisieren( $(this), 'mitglieder' )
        } );

        // PERMISSION AKTUALISIEREN
        $( '.permission' ).each( function() {
            Mitglieder_PermissionAktualisieren( $(this), 'mitglieder' )
        } );

    } );

    // PERMISSIONS ÄNDERN
    $(document).on("change", ".check_permission" , function() {
        Mitglieder_PermissionAendern( $(this), 'mitglieder' )
    } );
  
} );