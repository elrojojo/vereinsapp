<?php

namespace App\Models\Termine;

use CodeIgniter\Model;

class Termine_Rueckmeldung_Model extends Model {
   
    protected $table          = 'termine_rueckmeldungen';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'termin_id',
        'mitglied_id',
        'status',
        'bemerkung',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}