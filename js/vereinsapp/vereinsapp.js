dayjs.extend(window.dayjs_plugin_isToday);

const STATUS_SPINNER_HTML = '<span class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></span>';
let STATUS_STANDARD_HTML;

$(document).ready( function() {

  //POPOVER AKTIVIEREN
  $('[data-toggle="popover"]').popover();

  //ALLGEMEINE AJAX-EINSTELLUNGEN
  STATUS_STANDARD_HTML = $('#status').html();

  $(document).ajaxStart( function() {
    $('#status').html( STATUS_SPINNER_HTML );
  } );

  $(document).ajaxStop( function() {
    $('#status').html( STATUS_STANDARD_HTML );
  } );

  $(document).ajaxSuccess( function() {
    $('#status').removeClass('text-danger');
    $('#status').addClass('text-success');
  } );

  $(document).ajaxError( function() {
    $('#status').removeClass('text-success');
    $('#status').addClass('text-danger');
  } );

  // DATENACHUTZ-RICHTLINIE AKZEPTIEREN
  if( localStorage.getItem( 'vereinsapp_datenschutz_richtlinie_'+DATENACHUTZ_RICHTLINIE_DATUM ) === null ) {
    $.ajax( {
      url: BASE_URL+'/login/ajax_datenschutz_richtlinie',
      method: 'get',
      dataType: 'html',
      success: function(datenschutz_richtlinie) {
        $('#modals_anzeigen_liste').append( datenschutz_richtlinie );
        $('#datenschutz_richtlinie_modal').modal('show');
        $('#datenschutz_richtlinie_akzeptieren').click( function() {
          localStorage.setItem(  'vereinsapp_datenschutz_richtlinie_'+DATENACHUTZ_RICHTLINIE_DATUM, dayjs() ); console.log('Datenschutz-Richtlinie akzeptiert');
          $('#datenschutz_richtlinie_modal').modal('hide');
        } );
      },
      error: function(xhr) { alert( 'datenschutz_richtlinie konnte nicht geladen werden: ' + xhr.status + ' ' + xhr.statusText); },
    } );
  }
  

    // PASSWORT ANZEIGEN
    $('.passwort_anzeigen').click( function(event) {
        event.preventDefault();
        let feld = $(this).data('feld');
    
        if($('#'+feld).attr('type') == 'text'){
            $('#'+feld).attr('type', 'password');
            $('#'+feld+'_anzeigen').addClass( 'bi-'+SYMBOLE['unsichtbar']['bootstrap'] );
            $('#'+feld+'_anzeigen').removeClass( 'bi-'+SYMBOLE['sichtbar']['bootstrap'] );
        }
        else if($('#'+feld).attr('type') == 'password'){
            $('#'+feld).attr('type', 'text');
            $('#'+feld+'_anzeigen').addClass( 'bi-'+SYMBOLE['sichtbar']['bootstrap'] );
            $('#'+feld+'_anzeigen').removeClass( 'bi-'+SYMBOLE['unsichtbar']['bootstrap'] );
        }
    } );


    // SORTABLE
    $('.sortable').sortable( {
        handle: '#sortable_aendern',
        start: function( event, ui ) {
            ui.item.addClass('border-top border-primary shadow');
        },
        stop: function( event, ui ) {
            ui.item.removeClass('border-top border-primary shadow');
        },
        update: function() { 
            $('#sortable_speichern').attr( 'disabled', false );
        }
    } );

} );


$(window).on('beforeunload', function() {
    $('#status').html( STATUS_SPINNER_HTML );
} );

$.fn.exists = function () {
    return this.length !== 0;
}