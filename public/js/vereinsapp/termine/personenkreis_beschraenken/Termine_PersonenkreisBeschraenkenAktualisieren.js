function Termine_PersonenkreisBeschraenkenAktualisieren( $personenkreis_beschraenken, liste ) {

    const element_id = $personenkreis_beschraenken.attr('data-element_id');

    if( typeof element_id !== 'undefined' ) $personenkreis_beschraenken.html(
        filtern_mitglieder2$personenkreis_beschraenken( LISTEN[ liste ].tabelle[ element_id ].filtern_mitglieder, 'mitglieder' )
    );

}