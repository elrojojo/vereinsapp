<?php

namespace App\Models\Umfragen;

use CodeIgniter\Model;

use CodeIgniter\I18n\Time;

class Umfrage_Model extends Model {
   
    protected $table          = 'umfragen';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'titel',
        'status_auswahl',
        'bemerkung',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = TRUE;

    public function umfragen_tabelle() {
        $tabelle = array();

        foreach( $this->findAll() as $eintrag ) {
            $eintrag['erstellung'] = $eintrag['created_at'];
            if( $eintrag['erstellung'] != NULL ) $eintrag['erstellung'] = ( new Time( $eintrag['erstellung'] ) )->setTimezone('Europe/Berlin')->toDateTimeString();

            $tabelle[] = $this->eintrag_bereinigen( json_decode( json_encode( $eintrag ), TRUE ), 'aufgaben' );
        }

        return $tabelle;
    }

    private function eintrag_bereinigen( $eintrag, $liste ) {
        foreach( $eintrag as $eigenschaft => $wert ) if( is_numeric( $wert ) )
            if( array_key_exists( $liste, EIGENSCHAFTEN ) AND !array_key_exists( $eigenschaft, EIGENSCHAFTEN[$liste] ) ) unset( $eintrag[$eigenschaft] );
            elseif( is_numeric( $wert ) ) {
                if( (int) $wert == $wert ) $eintrag[ $eigenschaft ] = (int)$wert;
                elseif( (float) $wert == $wert ) $eintrag[ $eigenschaft ] = (float)$wert;
            }
        return $eintrag;
    }
}