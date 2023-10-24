function Mitglieder_PermissionAktualisieren( $permission, liste ) {

    const permission = $permission.find('.form-check-input').val();
    const gegen_element_id = $permission.parents('.permissions').first().attr('data-gegen_element_id');

    // BESCHRIFTUNG AKTUALISIEREN
    $permission.find('.beschriftung').text( PERMISSIONS[ permission ] );

    // CHECKED AKTUALISIEREN
    $permission.find('.form-check-input').prop( 'checked',
        LISTEN[ liste ].tabelle[ gegen_element_id ].permissions.length > 0 && LISTEN[ liste ].tabelle[ gegen_element_id ].permissions.includes( permission )
    );

    // DISABLED AKTUALISIEREN
    $permission.find('.form-check-input').prop( 'disabled',
        permission == 'global.einstellungen' || permission == 'mitglieder.rechte' || !( LISTEN[ liste ].tabelle[ ICH.id ].permissions.length > 0 && LISTEN[ liste ].tabelle[ ICH.id ].permissions.includes('mitglieder.rechte') )
    );

}