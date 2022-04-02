function cookie_eintragen( name, wert, laufzeit = null ) {
  let ablaufdatum;
  if( laufzeit === null ) { ablaufdatum = ''; }
  else { const JETZT = new Date(); JETZT.setTime( JETZT.getTime() + ( laufzeit*1000 ) ); ablaufdatum = JETZT.toUTCString(); }
  document.cookie = name + '=' + wert + ';expires='+ ablaufdatum + ';path=/';
  cookie_redundanz_eintragen( name, wert, ablaufdatum );
}

function cookie( name, redundant = true ) {
  const NAME = name + "=";
  const decodedCookie = decodeURIComponent(document.cookie);
  const ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(NAME) == 0) {
      return c.substring(NAME.length, c.length);
    }
  }
  if( redundant && cookie_redundanz_aktivieren( name ) ) { return cookie( name ); }
  return '';
}

function cookie_austragen( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
  localStorage.removeItem( cookie_redundanz_name(name) );
}

function cookie_redundanz_name( name ) { return name + '_cookie_redundanz'; }

function cookie_redundanz_eintragen( name, ablaufdatum ) {
  localStorage.setItem( cookie_redundanz_name(name), JSON.stringify( { wert: cookie( name ), ablaufdatum: ablaufdatum } ) );
}

function cookie_redundanz_aktivieren( name ) {
  if( localStorage.getItem( cookie_redundanz_name(name) ) !== null ) {
    REDUNDANZ = JSON.parse( localStorage.getItem( cookie_redundanz_name(name) ) );
    document.cookie = name + '=' + REDUNDANZ.wert + ';expires='+ REDUNDANZ.ablaufdatum + ';path=/';
    return true;
  } else return false;
}