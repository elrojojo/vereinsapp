const STATUS_SPINNER_HTML = '<span class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></span>';;
let STATUS_STANDARD_HTML;

$(document).ready( function() {

    //POPOVER AKTIVIEREN
    $('[data-toggle="popover"]').popover();


    // AUTOMATISCHES SCROLLEN
    const LETZTER_PATHNAME = localStorage.getItem( 'vereinsapp_pathname' );
    const AKTUELLER_PATHNAME = $(location).attr('pathname');
    localStorage.setItem( 'vereinsapp_pathname', AKTUELLER_PATHNAME );

    if( LETZTER_PATHNAME == AKTUELLER_PATHNAME ) $(window).scrollTop( localStorage.getItem('vereinsapp_scrollpos') ); else localStorage.removeItem( 'vereinsapp_scrollpos' );
    $(window).scroll( function() {
	    const SCROLLPOS = $(window).scrollTop();
        localStorage.setItem( 'vereinsapp_scrollpos', SCROLLPOS );
    } );
    
    
    //COOKIES "DAUERHAFT ANGEMELDET" AUS LOCALSTORAGE
    if( ( !cookie( 'vereinsapp_dauerhaft_angemeldet_identifier', false )    && localStorage.getItem( cookie_redundanz_name('vereinsapp_dauerhaft_angemeldet_identifier') ) !== null )
     || ( !cookie( 'vereinsapp_dauerhaft_angemeldet_securitytoken', false ) && localStorage.getItem( cookie_redundanz_name('vereinsapp_dauerhaft_angemeldet_securitytoken') ) !== null ) ) {
        if( !cookie( 'vereinsapp_dauerhaft_angemeldet_identifier', false ) ) cookie_redundanz_aktivieren( 'vereinsapp_dauerhaft_angemeldet_identifier' );
        if( !cookie( 'vereinsapp_dauerhaft_angemeldet_securitytoken', false ) ) cookie_redundanz_aktivieren( 'vereinsapp_dauerhaft_angemeldet_securitytoken' );
        window.location.replace( ABSPRUNG );
    } else {
        if( cookie('vereinsapp_dauerhaft_angemeldet_identifier').length
        && (
            localStorage.getItem( cookie_redundanz_name('vereinsapp_dauerhaft_angemeldet_identifier') ) === null 
        ||  localStorage.getItem( cookie_redundanz_name('vereinsapp_dauerhaft_angemeldet_identifier') ) != cookie('vereinsapp_dauerhaft_angemeldet_identifier')
        ) ) {
            let ablaufdatum = new Date(); ablaufdatum.setTime( new Date().getTime() + ( LOGIN_COOKIE_EXPIRE*1000 ) ); ablaufdatum = ablaufdatum.toUTCString();
            cookie_redundanz_eintragen( 'vereinsapp_dauerhaft_angemeldet_identifier', ablaufdatum );
        }
        if( cookie('vereinsapp_dauerhaft_angemeldet_securitytoken').length
        && (
            localStorage.getItem( cookie_redundanz_name('vereinsapp_dauerhaft_angemeldet_securitytoken') ) === null 
        ||  localStorage.getItem( cookie_redundanz_name('vereinsapp_dauerhaft_angemeldet_securitytoken') ) != cookie('vereinsapp_dauerhaft_angemeldet_securitytoken')
        ) ) {
            let ablaufdatum = new Date(); ablaufdatum.setTime( new Date().getTime() + ( LOGIN_COOKIE_EXPIRE*1000 ) ); ablaufdatum = ablaufdatum.toUTCString();
            cookie_redundanz_eintragen( 'vereinsapp_dauerhaft_angemeldet_securitytoken', ablaufdatum );
        }
    }


    // COOKIES AKZEPTIEREN
    const COOKIES_AKZEPTIEREN_LAUFZEIT = 60*60*24*30*12*5;
    if( Number( cookie('vereinsapp_cookies_'+COOKIES_RICHTLINIE_DATUM) )+COOKIES_AKZEPTIEREN_LAUFZEIT < Math.floor(new Date()/1000) ) {
        $.ajax( {
            url: BASE_URL+'/ajax/ajax_cookies_richtlinie',
            method: 'get',
            dataType: 'html',
            success: function(cookies_richtlinie) {
                $('#modals_anzeigen_liste').append( cookies_richtlinie );
                $('#cookies_richtlinie').modal('show');
                $('#cookies_richtlinie_akzeptieren').click( function() {
                    cookie_eintragen( 'vereinsapp_cookies_'+COOKIES_RICHTLINIE_DATUM, Math.floor(new Date()/1000), COOKIES_AKZEPTIEREN_LAUFZEIT ); console.log( 'Cookie-Richtlinie akzeptiert');
                    $('#cookies_richtlinie').modal('hide');            
                } );
            },
            error: function(xhr){ alert( 'cookies_richtlinie konnte nicht geladen werden: ' + xhr.status + ' ' + xhr.statusText); },
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