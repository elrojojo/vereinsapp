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

  //LISTEN, ELEMENTE PERMISSIONS IM DOM AKTUALISIEREN
  $(document).on( 'VAR_upd_DOM_mitglieder', function() {

    // PERMISSIONS AKTUALISIEREN
    $( '.permissions' ).each( function() { const $permissions = $(this); const gegen_element_id = $permissions.attr('data-gegen_element_id');

        // PERMISSIONS FILTERN
        // let filtern = $permissions.attr('data-filtern'); if( typeof filtern !== 'undefined' ) filtern = phpfiltern2filtern( JSON.parse( filtern ), liste ); else filtern = new Array();
        // if( LISTE.filtern.length >= 1 ) filtern = [ { verknuepfung: '&&', filtern: filtern.concat( LISTE.filtern ) } ];
        // const permissions_gefiltert = tabelle_filtern( filtern, liste );
        const permissions_gefiltert = PERMISSIONS;

        // DOM LÖSCHEN
        $permissions.find( '.permission' ).each( function() { const $permission = $(this);
          if( !( $permission.find('.form-check-input').val() in permissions_gefiltert ) ) $permission.remove();
        } );
        
        // DOM ERGÄNZEN
        $.each( permissions_gefiltert, function( permission, beschriftung) { const $permission = $permissions.find( '[value="'+permission+'"]' ).parents('.permission').first();
          if( !$permission.exists() ) {
            const $neue_permission = LISTEN.mitglieder.$blanko_permission.clone().removeClass('blanko invisible').addClass('permission');
            $neue_permission.find('label').attr( 'for', permission );
            $neue_permission.find('.check_permission').attr( 'id', permission ).val( permission );
            $neue_permission.appendTo( $permissions );
          }
        } );

        // ÜBERSCHRIFTEN EIN-/AUSBLENDEN
        if ( $permissions.children().length == 0 ) $permissions.prev('.ueberschrift[data-liste_id="'+$permissions.attr('id')+'"]').addClass('invisible');
        else $permissions.prev('.ueberschrift[data-liste_id="'+$permissions.attr('id')+'"]').removeClass('invisible');
      
    } );

    // PERMISSION AKTUALISIEREN
    $( '.permission' ).each( function() { const $permission = $(this); const permission = $permission.find('.form-check-input').val(); const gegen_element_id = $permission.parents('.permissions').first().attr('data-gegen_element_id');
      $permission.find('.beschriftung').text( PERMISSIONS[ permission ] );
      if( LISTEN.mitglieder.tabelle[ gegen_element_id ].permissions.length > 0 && LISTEN.mitglieder.tabelle[ gegen_element_id ].permissions.includes( permission ) ) $permission.find('.form-check-input').prop( 'checked', true );
      else $permission.find('.form-check-input').prop( 'checked', false );
      if( permission == 'global.einstellungen' || permission == 'mitglieder.rechte' || !( LISTEN.mitglieder.tabelle[ ICH.id ].permissions.length > 0 && LISTEN.mitglieder.tabelle[ ICH.id ].permissions.includes('mitglieder.rechte') ) ) $permission.find('.form-check-input').prop( 'disabled', true );
      else $permission.find('.form-check-input').prop( 'disabled', false );
    } );

  } );

  // PERMISSIONS ÄNDERN
  $(document).on("change", ".check_permission" , function() {
    const $check = $(this); const $check_beschriftung = $check.siblings('.beschriftung'); const check_beschriftung = $check_beschriftung.html();
    const $liste = $check.parents('.permissions').first(); const aktion = $liste.attr('data-aktion');

    /* const liste = $liste.attr('data-liste'); const LISTE = LISTEN[ liste ]; */const element = 'permission'/*LISTE.element*/; const element_id = $check.val();
    const check_liste = $liste.attr('data-check_liste');/* const CHECK_LISTE = LISTEN[ check_liste ];*/ const check_element = /*CHECK_LISTE.*/element;
    const gegen_element = $liste.attr('data-gegen_element'); const gegen_element_id = $liste.attr('data-gegen_element_id');

    const AJAX_DATA = { checked: $check.is(':checked') };
    AJAX_DATA[ element+'_id' ] = element_id;
    AJAX_DATA[ gegen_element+'_id' ] = gegen_element_id;

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue( {
      url: BASE_URL+'/mitglieder/ajax_'+gegen_element+'_'+check_element+'_'+aktion+'', method: 'post',
      data: AJAX_DATA, dataType: 'json',
      beforeSend: function() { $check_beschriftung.html( STATUS_SPINNER_HTML ).addClass('text-primary') },
      success: function(antwort) { $('#csrf_hash').val(antwort.csrf_hash);
        if( typeof antwort.validation !== 'undefined' ) console.log( 'FEHLER '+element+' '+aktion+': validation -> '+JSON.stringify(antwort.validation) );
        else {
          if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );
          if( CSRF_NAME in AJAX_DATA ) delete AJAX_DATA[ CSRF_NAME ];
          $.each( LISTEN.mitglieder.tabelle[gegen_element_id].permissions, function( index, permission) {
            if( permission == element_id ) delete LISTEN.mitglieder.tabelle[gegen_element_id].permissions[ index ];
          } );
          if( !( 'permissions' in LISTEN.mitglieder.tabelle[gegen_element_id] ) || typeof LISTEN.mitglieder.tabelle[gegen_element_id].permissions !== 'object' ) LISTEN.mitglieder.tabelle[gegen_element_id].permissions = new Array();
          if( AJAX_DATA.checked ) LISTEN.mitglieder.tabelle[gegen_element_id].permissions.push( element_id );

          $(document).trigger( 'VAR_upd_LOC', ['mitglieder'] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );
        }

      },
      error: function(xhr) { console.log( 'FEHLER '+element+' '+aktion+': ' + xhr.status + ' ' + xhr.statusText); },
      complete: function() { $check_beschriftung.html( check_beschriftung ).removeClass('text-primary'); },
    } );
      
  } );
  
} );