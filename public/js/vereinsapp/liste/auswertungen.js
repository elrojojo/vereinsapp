

$(document).ready( function() {


    

    

    // AUSWERTUNGEN IM DOM AKTUALISIEREN
    $(document).on( 'VAR_upd_DOM', function( event, prio_liste ) { const todo = new Array();
        if( prio_liste in LISTEN ) {
            todo.push( prio_liste );
            $.each( Object.keys( LISTEN ), function( index, liste) { if( liste != prio_liste ) todo.push( liste ); } );
        }
        $.each( todo, function( prio, liste ) { const LISTE = LISTEN[ liste ];

            // AUSWERTUNGEN AKTUALISIEREN
            $( '.auswertungen[data-liste="'+liste+'"]' ).each( function() { const $auswertungen = $(this);

                // TABELLE FILTERN
                let filtern = $auswertungen.attr('data-filtern'); if( typeof filtern !== 'undefined' ) filtern = JSON.parse( filtern ); else filtern = new Array();
                const tabelle_gefiltert = tabelle_filtern( filtern, liste );

                // CLUSTER_TABELLE DEFINIEREN
                let cluster = $auswertungen.attr('data-cluster'); if( typeof cluster !== 'undefined' ) cluster = JSON.parse( cluster ); else cluster = new Object();
                const cluster_liste = cluster.liste; const CLUSTER_LISTE = LISTEN[ cluster_liste ];

                // CLUSTER_TABELLE FILTERN
                let cluster_filtern; if( 'filtern' in cluster ) cluster_filtern = sqlfiltern2filtern( JSON.parse( cluster.filtern ), cluster.liste ); else cluster_filtern = new Array();
                const cluster_tabelle_gefiltert = tabelle_filtern( cluster_filtern, cluster_liste );

                // CLUSTER_TABELLE CLUSTERN
                const cluster_tabelle_gefiltert_geclustert = new Object;
                $.each( cluster_tabelle_gefiltert, function( position, cluster_element ) { const wert = cluster_element[ cluster.eigenschaft ];
                    if( !Array.isArray( cluster_tabelle_gefiltert_geclustert[ wert ] ) ) cluster_tabelle_gefiltert_geclustert[ wert ] = new Array();
                    cluster_tabelle_gefiltert_geclustert[ wert ].push( cluster_element.id );
                } );
                
                // AUSWERTUNG DURCHFÜHREN
                const auswertungen = new Object();
                const auswertungen_gefiltert_sortiert = new Array();
                $.each( cluster_tabelle_gefiltert_geclustert, function( wert, cluster ) { auswertungen[ wert ] = new Object();

                    auswertungen[ wert ].positiv = new Array();
                    auswertungen[ wert ].neutral = new Array();
                    auswertungen[ wert ].negativ = new Array();
                    $.each( tabelle_gefiltert, function() { const element = this; if( 'id' in element ) {
                        $.each( cluster_tabelle_gefiltert_geclustert[ wert ], function( position, cluster_element_id ) {
                            if( element[ CLUSTER_LISTE.element+'_id' ] == cluster_element_id ) {
                                if( element.status == 0 ) auswertungen[ wert ].negativ.push( cluster_element_id );
                                else if( element.status >= 1 ) auswertungen[ wert ].positiv.push( cluster_element_id );
                                cluster_tabelle_gefiltert_geclustert[ wert ].splice( position, 1 );
                            }
                        } );
                    } } );
                    auswertungen[ wert ].neutral = cluster_tabelle_gefiltert_geclustert[ wert ];

                    auswertungen[ wert ].positiv_anzahl = auswertungen[ wert ].positiv.length;
                    auswertungen[ wert ].neutral_anzahl = auswertungen[ wert ].neutral.length;
                    auswertungen[ wert ].negativ_anzahl = auswertungen[ wert ].negativ.length;
                    auswertungen[ wert ].alle_anzahl
                        = auswertungen[ wert ].positiv_anzahl
                        + auswertungen[ wert ].neutral_anzahl
                        + auswertungen[ wert ].negativ_anzahl;

                    auswertungen[ wert ].wert = wert; auswertungen_gefiltert_sortiert.push( auswertungen[ wert ] );
                } );

                // DOM LÖSCHEN
                $auswertungen.find( '.auswertung[data-auswertung="'+cluster.eigenschaft+'"]' ).each( function() { const $auswertung = $(this);
                    if( !auswertungen_gefiltert_sortiert.includes( auswertungen[ $auswertung.attr('data-wert') ] ) ) $auswertung.remove();
                } );

                // DOM ERGÄNZEN
                $.each( auswertungen_gefiltert_sortiert, function( position, auswertung) { const $auswertung = $auswertungen.find( '.auswertung[data-auswertung="'+cluster.eigenschaft+'"][data-wert="'+auswertung.wert+'"]' );
                    if( !$auswertung.exists() ) {
                        const $neue_auswertung = LISTE.$blanko_auswertung[ $auswertungen.attr('id') ].clone().removeClass('blanko invisible').attr( 'data-auswertung', cluster.eigenschaft ).attr( 'data-wert', auswertung.wert );
                        $neue_auswertung.find('[data-bs-toggle="collapse"]').attr( 'data-bs-target', '#auswertung_'+cluster.eigenschaft+'_'+auswertung.wert );
                        $neue_auswertung.find('.collapse').attr( 'id', 'auswertung_'+cluster.eigenschaft+'_'+auswertung.wert );
                        if( position == 0 ) $neue_auswertung.appendTo( $auswertungen );
                        else $neue_auswertung.insertAfter( $auswertungen.find( '.auswertung[data-auswertung="'+cluster.eigenschaft+'"][data-wert="'+auswertungen_gefiltert_sortiert[ position-1 ].wert+'"]') );
                    }
                } );

                // DOM SORTIEREN ...

                // AUSWERTUNG AKTUALISIEREN
                $( '.auswertung[data-auswertung="'+cluster.eigenschaft+'"]' ).each( function() { const $auswertung = $(this); const wert = $auswertung.attr('data-wert');

                    // BESCHRIFTUNG AKTUALISIEREN
                    $auswertung.find('.beschriftung').text( VORGEGEBENE_WERTE[ cluster.liste ][ cluster.eigenschaft ][ wert ].beschriftung );

                    // ERGEBNIS AKTUALISIEREN
                    $auswertung.find('.ergebnis').each( function() { const $ergebnis = $(this);
                        const ergebnis = $ergebnis.attr('data-ergebnis');
                        if( ergebnis == 'positiv' || ergebnis == 'neutral' || ergebnis == 'negativ' ) {
                            const filtern = new Array(); filtern_knoten = { verknuepfung: '||', filtern: new Array() };
                            if( auswertungen[ wert ][ ergebnis ].length > 0 ) $.each( auswertungen[ wert ][ ergebnis ], function( position, id) {
                                filtern_knoten.filtern.push( { operator: '==', eigenschaft: 'id',  wert: id } );
                            } ); else filtern_knoten.filtern.push( { operator: '==', eigenschaft: 'id',  wert: null } );
                            filtern.push( filtern_knoten ); $ergebnis.attr( 'data-filtern', JSON.stringify( filtern ) );
                        }
                        else if( ergebnis == 'positiv_anzahl' || ergebnis == 'neutral_anzahl' || ergebnis == 'negativ_anzahl' ) {
                            if( $ergebnis.hasClass('progress-bar') ) $ergebnis.attr( 'style', 'width: '+(auswertungen[ wert ][ ergebnis ]/auswertungen[ wert ].alle_anzahl*100)+'%').attr( 'aria-valuenow', auswertungen[ wert ][ ergebnis ]/auswertungen[ wert ].alle_anzahl*100 );
                            else $ergebnis.text( auswertungen[ wert ][ ergebnis ] );
                        }
                    } );

                } );

            } );

        } );
    } );

} );