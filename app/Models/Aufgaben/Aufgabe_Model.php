<?php

namespace App\Models\Aufgaben;

use CodeIgniter\Model;

use CodeIgniter\I18n\Time;

class Aufgabe_Model extends Model {
   
    protected $table          = 'aufgaben';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'zugeordnete_liste',
        'zugeordnete_element_id',
        'titel',
        'mitglied_id',
        'erledigt',
        'bemerkung',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = TRUE;

    public function aufgaben_tabelle() {
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