function Termine_FormularMeineRueckmeldungEinAusblenden( $rueckmeldung, $element, liste ) {

    const element_id = Number( $element.attr('data-element_id') );
    const $rueckmeldung_nicht_eingeladen = $rueckmeldung.siblings('.rueckmeldung_nicht_eingeladen').closest();

    if( LISTEN[ liste ].tabelle[ element_id ].ich_eingeladen ) {

      $rueckmeldung.removeClass('invisible');
      $rueckmeldung_nicht_eingeladen.addClass('invisible');

    } else {

      $rueckmeldung.addClass('invisible');
      $rueckmeldung_nicht_eingeladen.removeClass('invisible');

    }

}