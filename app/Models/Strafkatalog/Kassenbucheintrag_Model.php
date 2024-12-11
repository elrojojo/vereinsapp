<?php

namespace App\Models\Strafkatalog;

use CodeIgniter\Model;

use CodeIgniter\I18n\Time;

class Kassenbucheintrag_Model extends Model {
   
    protected $table          = 'strafkatalog_kassenbuch';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'titel',
        'wert',
        'mitglied_id',
        'erledigt',
        'bemerkung',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = TRUE;

    public function kassenbuch_tabelle() {
        $tabelle = array();

        foreach( $this->findAll() as $eintrag ) {
            $eintrag['erstellung'] = $eintrag['created_at'];
            if( $eintrag['erstellung'] != NULL ) $eintrag['erstellung'] = ( new Time( $eintrag['erstellung'] ) )->setTimezone('Europe/Berlin')->toDateTimeString();

            $tabelle[] = $this->eintrag_bereinigen( json_decode( json_encode( $eintrag ), TRUE ), 'kassenbuch' );
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