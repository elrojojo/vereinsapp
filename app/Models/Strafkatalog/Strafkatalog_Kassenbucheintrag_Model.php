<?php

namespace App\Models\Strafkatalog;

use CodeIgniter\Model;

class Strafkatalog_Kassenbucheintrag_Model extends Model {
   
    protected $table          = 'strafkatalog_kassenbuch';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'titel',
        'wert',
        'zeitpunkt',
        'aktiv',
        'mitglied_id',
        'bemerkung',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = TRUE;
}