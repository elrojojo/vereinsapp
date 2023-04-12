LISTEN.rueckmeldungen = {
  controller:'termine',
  element:'rueckmeldung',
};

LISTEN.anwesenheiten = {
  controller:'termine',
  element:'anwesenheit',
};

LISTEN.termine = {
  controller:'termine',
  element:'termin',
};

PERSONENKREIS_BESCHRAENKEN = new Object();

$(document).ready( function() {

  {
    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung = $('.personenkreis_beschraenken').find('.blanko').first(); $('.personenkreis_beschraenken').empty();
    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_element = PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung.find('.blanko').first(); PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung.find('.personenkreis_beschraenken_kind').empty();

    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition = new Object();
    $( '.personenkreis_beschraenken_definitionen' ).find('.blanko').each( function() { const $blanko = $(this);
    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition[ $blanko.attr('data-typ') ] = $blanko;
    } ); $( '.personenkreis_beschraenken_definitionen' ).empty();
  }

  //ELEMENTE UND PERSONENKREIS BESCHRÄNKEN IM DOM AKTUALISIEREN
  $(document).on( 'VAR_upd_DOM_termine', function() {

    $( '.element[data-element="'+LISTEN.termine.element+'"]' ).each( function() { const $element = $(this); const element_id = Number( $element.attr('data-element_id') );

      // FORMULAR MEINE RÜCKMELDUNG EIN-/AUSBLENDEN
      $element.find('.rueckmeldung').each( function() { const $rueckmeldung = $(this); const $rueckmeldung_nicht_eingeladen = $rueckmeldung.siblings('.rueckmeldung_nicht_eingeladen').first();
        if( LISTEN.termine.tabelle[ element_id ].ich_eingeladen ) {
          $rueckmeldung.removeClass('invisible');
          $rueckmeldung_nicht_eingeladen.addClass('invisible');
        } else {
          $rueckmeldung.addClass('invisible');
          $rueckmeldung_nicht_eingeladen.removeClass('invisible');
        }
      } );
        
      // MEINE RÜCKMELDUNG AKTUALISIEREN
      $element.find('.zusagen, .absagen').each( function() {
        const $btn_rueckmelden = $(this); const $formular = $btn_rueckmelden.parents('.formular').first();
        const $btn_rueckmeldung_detaillieren = $btn_rueckmelden.siblings('.btn_rueckmeldung_detaillieren');
        let ich_rueckmeldung_id = LISTEN.termine.tabelle[ element_id ].ich_rueckmeldung_id;

        if( typeof ich_rueckmeldung_id === 'undefined' ) ich_rueckmeldung_id = null;
        if( ich_rueckmeldung_id !== null ) $btn_rueckmelden.attr( 'data-element_id', ich_rueckmeldung_id ).attr( 'data-aktion', 'aendern' );
        else {
          let data_werte = $btn_rueckmelden.attr('data-werte'); if( typeof data_werte !== 'undefined' ) data_werte = JSON.parse( data_werte ); else data_werte = new Object();
          data_werte.termin_id = element_id; $btn_rueckmelden.attr( 'data-werte', JSON.stringify( data_werte ) );
        }
        
        if( $btn_rueckmelden.hasClass('zusagen') ) {
          if( ich_rueckmeldung_id !== null && LISTEN.rueckmeldungen.tabelle[ ich_rueckmeldung_id ].status >= 1 ) {
            $btn_rueckmelden.prop( 'disabled', true ).removeClass('w-100').addClass('w-75').removeClass('btn-outline-success').addClass('btn-success').removeClass('rounded-end').removeClass('rounded-pill').addClass('rounded-0').text('ZUGESAGT');
            $btn_rueckmeldung_detaillieren.removeClass('invisible').attr( 'data-element_id', ich_rueckmeldung_id );
            const bemerkung = LISTEN.rueckmeldungen.tabelle[ ich_rueckmeldung_id ].bemerkung;
            if( typeof bemerkung !== 'undefined' && bemerkung != null && bemerkung != '' ) $btn_rueckmeldung_detaillieren.removeClass('btn-outline-success').addClass('btn-success');
            else $btn_rueckmeldung_detaillieren.addClass('btn-outline-success').removeClass('btn-success');
          }
          else {
            $btn_rueckmelden.prop( 'disabled', false ).removeClass('w-75').addClass('w-100').removeClass('btn-success').addClass('btn-outline-success').removeClass('rounded-0').addClass('rounded-end').addClass('rounded-pill').text('ZUSAGEN');
            $btn_rueckmeldung_detaillieren.addClass('invisible').removeClass('btn-success').addClass('btn-outline-success');
          }
        } else if( $btn_rueckmelden.hasClass('absagen') ) {
          if( ich_rueckmeldung_id !== null && LISTEN.rueckmeldungen.tabelle[ ich_rueckmeldung_id ].status == 0 ) {
            $btn_rueckmelden.prop( 'disabled', true ).removeClass('w-100').addClass('w-75').removeClass('btn-outline-danger').addClass('btn-danger').removeClass('rounded-start').removeClass('rounded-pill').addClass('rounded-0').text('ABGESAGT');
            $btn_rueckmeldung_detaillieren.removeClass('invisible').attr( 'data-element_id', ich_rueckmeldung_id );
            const bemerkung = LISTEN.rueckmeldungen.tabelle[ ich_rueckmeldung_id ].bemerkung;
            if( typeof bemerkung !== 'undefined' && bemerkung != null && bemerkung != '' ) $btn_rueckmeldung_detaillieren.removeClass('btn-outline-danger').addClass('btn-danger');
            else $btn_rueckmeldung_detaillieren.addClass('btn-outline-danger').removeClass('btn-danger');
          }
          else {
            $btn_rueckmelden.prop( 'disabled', false ).removeClass('w-75').addClass('w-100').removeClass('btn-danger').addClass('btn-outline-danger').removeClass('rounded-0').addClass('rounded-start').addClass('rounded-pill').text('ABSAGEN');
            $btn_rueckmeldung_detaillieren.addClass('invisible').removeClass('btn-danger').addClass('btn-outline-danger');
          }
        }
      } );

    } );

    // PERSONENKREIS BESCHRÄNKEN AKTUALISIEREN
    $( '.personenkreis_beschraenken' ).each( function() { const $personenkreis_beschraenken = $(this);
      const element_id = $personenkreis_beschraenken.attr('data-element_id');
      if( typeof element_id !== 'undefined' ) $personenkreis_beschraenken.html( filtern_mitglieder2$personenkreis_beschraenken( LISTEN.termine.tabelle[ element_id ].filtern_mitglieder, 'mitglieder' ) );
    } );

  } );
  
  // FORMULAR (MODAL) ÖFFNEN
  $('.formular_personenkreis_beschraenken').on('show.bs.modal', function ( event ) { const $formular = $(this); const $btn_oeffnend = $(event.relatedTarget);
    const element_id = $btn_oeffnend.attr('data-element_id');// const aktion = $btn_oeffnend.attr('data-aktion');
    // const liste = 'termine'; const LISTE = LISTEN[ liste ]; const element = LISTE.element;
    const filtern_liste = 'mitglieder'; const FILTERN_LISTE = LISTEN[ filtern_liste ]; const filtern_element = FILTERN_LISTE.element;

    $formular.find('.personenkreis_beschraenken, .personenkreis_beschraenken_definitionen').attr( 'data-filtern_liste', filtern_liste ).attr( 'data-element_id', element_id );

    $( '.personenkreis_beschraenken_definitionen' ).empty();
    $.each( FILTERBARE_EIGENSCHAFTEN[ filtern_liste ], function( index, eigenschaft) { const EIGENSCHAFT = EIGENSCHAFTEN[ FILTERN_LISTE.controller ][ filtern_liste ][ eigenschaft ];
      const typ = EIGENSCHAFT.typ;
      const beschriftung = EIGENSCHAFT.beschriftung;
      const $neue_personenkreis_beschraenken_definition = PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition[ typ ].clone().removeClass('blanko invisible').addClass('personenkreis_beschraenken_definition').attr( 'data-eigenschaft', eigenschaft );
      $neue_personenkreis_beschraenken_definition.find('.accordion-button').attr( 'data-bs-target', '#personenkreis_beschraenken_'+eigenschaft ).text( beschriftung );
      $neue_personenkreis_beschraenken_definition.find('.accordion-collapse').attr( 'id', 'personenkreis_beschraenken_'+eigenschaft );
      if( typ == 'vorgegebene_werte' ) {
          $neue_personenkreis_beschraenken_definition.find('.personenkreis_beschraenken_wert').empty();
          $.each( VORGEGEBENE_WERTE[ filtern_liste ][ eigenschaft ], function( wert, eigenschaften) {
              $( '<option value="'+wert+'">'+eigenschaften.beschriftung+'</option>' ).appendTo( $neue_personenkreis_beschraenken_definition.find('.personenkreis_beschraenken_wert') );
          } );
      }
      $neue_personenkreis_beschraenken_definition.appendTo( $formular.find( '.personenkreis_beschraenken_definitionen' ) );
    } );
    
    $(document).trigger( 'VAR_upd_DOM', [ 'termine' ] );
  } );

  // PERSONENKREIS BESCHRÄNKEN ERSTELLEN
  $(document).on("click", ".btn_personenkreis_beschraenken_erstellen" , function() {
    const $btn = $(this); const btn_beschriftung = $btn.html(); const $formular = $btn.parents('.personenkreis_beschraenken_definition').first();
    const filtern_liste = $btn.parents('[data-filtern_liste]').first().attr('data-filtern_liste'); const FILTERN_LISTE = LISTEN[ filtern_liste ];
    const eigenschaft = $formular.attr('data-eigenschaft'); const element_id = $btn.parents('.personenkreis_beschraenken_definitionen').first().attr('data-element_id');

    const filtern_eigenschaft = new Array();
    $formular.find('.personenkreis_beschraenken_wert').each( function() { const $personenkreis_beschraenken_wert = $(this); if( $personenkreis_beschraenken_wert.val() ) {
        const operator = $personenkreis_beschraenken_wert.attr('data-operator');
        let wert = $personenkreis_beschraenken_wert.val();
        if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
        if( typeof EIGENSCHAFTEN[ FILTERN_LISTE.controller ][ filtern_liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ FILTERN_LISTE.controller ][ filtern_liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) wert = DateTime.fromISO( wert );
        filtern_eigenschaft.push( { operator: operator, eigenschaft: eigenschaft, wert: wert } );
    } } );
    let filtern_eigenschaft_knoten; if( filtern_eigenschaft.length == 1 ) filtern_eigenschaft_knoten = filtern_eigenschaft[0];
    else filtern_eigenschaft_knoten = { verknuepfung: '||', filtern: filtern_eigenschaft }

    const filtern_mitglieder = LISTEN.termine.tabelle[ element_id ].filtern_mitglieder;
    if( filtern_mitglieder.length == 0 ) filtern_mitglieder.push( filtern_eigenschaft_knoten );
    else {
        if( 'verknuepfung' in filtern_mitglieder[0] ) filtern_mitglieder[0].filtern.push( filtern_eigenschaft_knoten );
        else { const einziges_element = filtern_mitglieder[0];
          filtern_mitglieder[0] = { verknuepfung: '||', filtern: new Array() };
          filtern_mitglieder[0].filtern.push( einziges_element );
          filtern_mitglieder[0].filtern.push( filtern_eigenschaft_knoten );
        }
    }
    const AJAX_DATA = { id: element_id, filtern_mitglieder: JSON.stringify( filtern_mitglieder ) };

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue( {
      url: BASE_URL+'/termine/ajax_termin_personenkreis_beschraenken', method: 'post',
      data: AJAX_DATA, dataType: 'json',
      beforeSend: function() { $btn.html( STATUS_SPINNER_HTML ).prop( 'disabled', true ); },
      success: function(antwort) { $('#csrf_hash').val(antwort.csrf_hash);
        if( typeof antwort.validation !== 'undefined' ) console.log( 'FEHLER personenkreis beschraenken: validation -> '+JSON.stringify(antwort.validation) );
        else {
          if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );
          LISTEN.termine.tabelle[ element_id ].filtern_mitglieder = filtern_mitglieder;
          $(document).trigger( 'VAR_upd_LOC', [ 'termine' ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
        }
      },
      error: function(xhr) { console.log( 'FEHLER personenkreis beschraenken: ' + xhr.status + ' ' + xhr.statusText); },
      complete: function() { $btn.html( btn_beschriftung ).prop( 'disabled', false ); },
    } );
  } );

  // PERSONENKREIS BESCHRÄNKEN LÖSCHEN
  $(document).on("click", ".btn_personenkreis_beschraenken_loeschen" , function() {
    const $btn = $(this); const $personenkreis_beschraenken = $btn.parents('.personenkreis_beschraenken').first(); const element_id = $personenkreis_beschraenken.attr('data-element_id');
    const $element = $btn.parents('.personenkreis_beschraenken_element').first(); const $sammlung = $btn.parents('.personenkreis_beschraenken_sammlung').first();
    let $knoten; if( $element.exists() ) { $knoten = $element; } else  $knoten = $sammlung;
    let $knoten_parallel = $knoten.siblings('.personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung');
    let $sammlung_ebene_hoeher = $knoten.parents('.personenkreis_beschraenken_sammlung').first();

    $knoten.remove();
    while( $knoten_parallel.length == 1 ) {
      const $knoten_ebene_hoeher = $sammlung_ebene_hoeher.siblings('.personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung');
      $sammlung_ebene_hoeher.replaceWith( $knoten_parallel )
      $knoten_parallel = $knoten_ebene_hoeher;
      sammlung_ebene_hoeher = $knoten_parallel.first().parents('.personenkreis_beschraenken_sammlung').first();
    }
    const filtern_mitglieder = $personenkreis_beschraenken2filtern_mitglieder( $personenkreis_beschraenken, 'mitglieder' );
    const AJAX_DATA = { id: element_id, filtern_mitglieder: JSON.stringify( filtern_mitglieder ) };

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue( {
      url: BASE_URL+'/termine/ajax_termin_personenkreis_beschraenken', method: 'post',
      data: AJAX_DATA, dataType: 'json',
      beforeSend: function() { $btn.addClass('invisible').prop( 'disabled', true ).after(STATUS_SPINNER_HTML); },
      success: function(antwort) { $('#csrf_hash').val(antwort.csrf_hash);
        if( typeof antwort.validation !== 'undefined' ) console.log( 'FEHLER personenkreis beschraenken: validation -> '+JSON.stringify(antwort.validation) );
        else {
          if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );
          LISTEN.termine.tabelle[ element_id ].filtern_mitglieder = filtern_mitglieder;
          $(document).trigger( 'VAR_upd_LOC', [ 'termine' ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
        }
      },
      error: function(xhr) { console.log( 'FEHLER personenkreis beschraenken: ' + xhr.status + ' ' + xhr.statusText); },
      complete: function() { $btn.removeClass('invisible').prop( 'disabled', false ); $btn.siblings( '.'+STATUS_SPINNER_CLASS ).remove(); },
    } );
  } );

  // PERSONENKREIS BESCHRÄNKEN ÄNDERN (VERKNÜPFUNG)
  $(document).on("click", ".btn_personenkreis_beschraenken_aendern" , function() {
    const $btn = $(this); const $personenkreis_beschraenken = $btn.parents('.personenkreis_beschraenken').first(); const element_id = $personenkreis_beschraenken.attr('data-element_id');
    const $verknuepfung = $btn.parents('.personenkreis_beschraenken_sammlung').first().find('.verknuepfung').first(); const verknuepfung = $verknuepfung.attr('data-verknuepfung');

    if( verknuepfung == '&&' ) $verknuepfung.attr('data-verknuepfung', '||');
    else if( verknuepfung == '||' ) $verknuepfung.attr('data-verknuepfung', '&&');
    const filtern_mitglieder = $personenkreis_beschraenken2filtern_mitglieder( $personenkreis_beschraenken, 'mitglieder' );
    const AJAX_DATA = { id: element_id, filtern_mitglieder: JSON.stringify( filtern_mitglieder ) };

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue( {
      url: BASE_URL+'/termine/ajax_termin_personenkreis_beschraenken', method: 'post',
      data: AJAX_DATA, dataType: 'json',
      beforeSend: function() { $btn.addClass('invisible').prop( 'disabled', true ).after(STATUS_SPINNER_HTML); },
      success: function(antwort) { $('#csrf_hash').val(antwort.csrf_hash);
        if( typeof antwort.validation !== 'undefined' ) console.log( 'FEHLER personenkreis beschraenken: validation -> '+JSON.stringify(antwort.validation) );
        else {
          if( typeof antwort.info !== 'undefined' ) console.log( JSON.stringify(antwort.info) ); //console.log( 'ERFOLG '+element+' '+aktion );
          LISTEN.termine.tabelle[ element_id ].filtern_mitglieder = filtern_mitglieder;
          $(document).trigger( 'VAR_upd_LOC', [ 'termine' ] ); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );        
        }
      },
      error: function(xhr) { console.log( 'FEHLER personenkreis beschraenken: ' + xhr.status + ' ' + xhr.statusText); },
      complete: function() { $btn.removeClass('invisible').prop( 'disabled', false ); $btn.siblings( '.'+STATUS_SPINNER_CLASS ).remove(); },
    } );
  } );

} );

function filtern_mitglieder2$personenkreis_beschraenken( filtern, liste ) { const LISTE = LISTEN[ liste ]; const $filtern = new Array();
  $.each( filtern, function( index, knoten ) {
    if( 'verknuepfung' in knoten ) { const verknuepfung = knoten.verknuepfung;
      const $neue_filtern_sammlung = PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung.clone().removeClass('blanko invisible').addClass('personenkreis_beschraenken_sammlung');
      const $verknuepfung = $neue_filtern_sammlung.find('.verknuepfung');
      $verknuepfung.attr( 'data-verknuepfung', verknuepfung );
      if( verknuepfung == '&&' ) $verknuepfung.text('UND'); else if( verknuepfung == '||' ) $verknuepfung.text('ODER');
      $.each( filtern_mitglieder2$personenkreis_beschraenken( knoten.filtern, liste ), function( index, $filtern) { $filtern.appendTo( $neue_filtern_sammlung.find('.personenkreis_beschraenken_kind').first() ); } );
      $filtern.push( $neue_filtern_sammlung );
    } else { const operator = knoten.operator; const eigenschaft = knoten.eigenschaft; const wert = knoten.wert;
      const $neues_filtern_element = PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_element.clone().removeClass('blanko invisible').addClass('personenkreis_beschraenken_element');
      $neues_filtern_element.find('.eigenschaft').attr( 'data-eigenschaft', eigenschaft ).text( EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ].beschriftung );
      $neues_filtern_element.find('.operator').attr( 'data-operator', operator ).text( operator );
      let data_wert = wert; if( EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ].typ == 'zeitpunkt' ) data_wert = wert.toFormat( SQL_DATETIME );
      $neues_filtern_element.find('.wert').attr( 'data-wert', data_wert ).text( wert_formatieren( wert, eigenschaft, liste ) );
      $neues_filtern_element.find('.btn_filtern_loeschen').attr( 'data-liste', liste );
      $filtern.push( $neues_filtern_element );
    }
  } ); return $filtern;
}

function $personenkreis_beschraenken2filtern_mitglieder( $personenkreis_beschraenken, liste ) { const LISTE = LISTEN[ liste ]; const filtern = new Array();
  $personenkreis_beschraenken.children('.personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung').each( function() { const $knoten = $(this);
      if( $knoten.hasClass('personenkreis_beschraenken_sammlung') ) {
          const verknuepfung = $knoten.find('.verknuepfung').attr('data-verknuepfung');
          filtern.push( { verknuepfung: verknuepfung, filtern: $personenkreis_beschraenken2filtern_mitglieder( $knoten.find('.personenkreis_beschraenken_kind').first(), liste ) } );
      }
      else if( $knoten.hasClass('personenkreis_beschraenken_element') ) {
          const operator = $knoten.find('.operator').attr('data-operator');
          const eigenschaft = $knoten.find('.eigenschaft').attr('data-eigenschaft');
          let wert = $knoten.find('.wert').attr('data-wert');
          if( wert && !Number.isNaN( Number(wert) ) && typeof wert !== 'boolean' ) wert = Number(wert);
          if( typeof EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ] !== 'undefined' && EIGENSCHAFTEN[ LISTE.controller ][ liste ][ eigenschaft ]['typ'] == 'zeitpunkt' ) wert = DateTime.fromFormat( wert, SQL_DATETIME );
          filtern.push( { operator: operator, eigenschaft: eigenschaft, wert: wert } );
      }
  } ); return filtern;
}