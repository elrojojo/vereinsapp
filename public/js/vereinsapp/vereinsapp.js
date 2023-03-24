const DateTime = luxon.DateTime;
const STATUS_SPINNER_CLASS = 'spinner-border spinner-border-sm';
const STATUS_SPINNER_HTML = '<span class="'+STATUS_SPINNER_CLASS+'" role="status"><span class="visually-hidden">Loading...</span></span>';
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
        $.ajaxQueue( {
            url: BASE_URL+'/status/ajax_datenschutz_richtlinie',
            method: 'get',
            dataType: 'html',
            success: function(datenschutz_richtlinie) {
                $('#modals_anzeigen_liste').append( datenschutz_richtlinie );
                $('#datenschutz_richtlinie_modal').modal('show');
                $('#datenschutz_richtlinie_akzeptieren').click( function() {
                    localStorage.setItem(  'vereinsapp_datenschutz_richtlinie_'+DATENACHUTZ_RICHTLINIE_DATUM, DateTime.now() ); console.log('ERFOLG Datenschutz-Richtlinie akzeptiert');
                    $('#datenschutz_richtlinie_modal').modal('hide');
                } );
            },
            error: function(xhr) { console.log( 'FEHLER datenschutz_richtlinie: ' + xhr.status + ' ' + xhr.statusText); },
        } );
    }


    // PASSWORT ANZEIGEN
    $(document).on("click", ".passwort_anzeigen" , function(event) { $passwort_anzeigen = $(this);
        event.preventDefault();
        let feld = $passwort_anzeigen.closest('.input-group').find('input.form-control');
    
        if(feld.attr('type') == 'text'){
            feld.attr('type', 'password');
            $passwort_anzeigen.find('i').removeClass( 'bi-'+SYMBOLE['sichtbar']['bootstrap'] );
            $passwort_anzeigen.find('i').addClass( 'bi-'+SYMBOLE['unsichtbar']['bootstrap'] );
        }
        else if(feld.attr('type') == 'password'){
            feld.attr('type', 'text');
            $passwort_anzeigen.find('i').removeClass( 'bi-'+SYMBOLE['unsichtbar']['bootstrap'] );
            $passwort_anzeigen.find('i').addClass( 'bi-'+SYMBOLE['sichtbar']['bootstrap'] );
        }
    } );


    // VALIDATION-TOOLTIPS ENTFERNEN
    $('input, select').on( 'focus', function() {
        $(this).next('.invalid-tooltip').remove();
    } );


    // EIGENSCHAFT-INPUTS UND -SELECTS MIT STANDARDWERTEN BEFÜLLEN
    // $('input.eigenschaft select.eigenschaft').each( function() { const $eigenschaft = $(this); const eigenschaft = $eigenschaft.attr('data-eigenschaft');
    //     if( $eigenschaft.attr('type') == 'date' ) $eigenschaft.val( DateTime.now().toISODate() );
    //     if( $eigenschaft.attr('type') == 'time' ) $eigenschaft.val( DateTime.now().toISOTime() );
    //     // ...
    //     $eigenschaft.change();
    // } );

    
    //LOCALSTORAGE LEEREN
    $('.navbar-text').click( function() {
	    localStorage.clear();
	    alert( 'localStorage geleert.' );
    } );

} );


$(window).on('beforeunload', function() {
    $('#status').html( STATUS_SPINNER_HTML );
} );

$.fn.exists = function () {
    return this.length !== 0;
}

const UMLAUTE_KONVERTIERUNG = new Array(
    [ ' ', '_'],
    [ ' ', '-'],
    [ 'ä', 'ae'],
    [ 'ö', 'oe'],
    [ 'ü', 'ue'],
    [ 'Ä', 'Ae'],
    [ 'Ö', 'Oe'],
    [ 'Ü', 'Ue'],
    [ 'ß', 'ss'],
);
function unix2umlaute( umlaute ) {
    $.each( UMLAUTE_KONVERTIERUNG, function( index, konvertierung ) { umlaute = umlaute.replaceAll( konvertierung[1], konvertierung[0] ); } );
    return umlaute;
}
function umlaute2unix( unix ) {
    $.each( UMLAUTE_KONVERTIERUNG, function( index, konvertierung ) { unix = unix.replaceAll( konvertierung[0], konvertierung[1] ); } );
    return unix;
}

function bezeichnung_kapitalisieren( bezeichnung ) {
    return bezeichnung.substring( 0, 1 ).toUpperCase() + bezeichnung.substring( 1 );;
}

function HTML_time( zeitstempel ) {
}

function HTML_date( zeitpunkt ) {
    return new Date( zeitpunkt*1000 ).toLocaleDateString('en-CA');
}

function HTML_datetime_local( zeitstempel ) {
    return strval( date( 'Y-m-d\TH:i', $zeitstempel ) );
}