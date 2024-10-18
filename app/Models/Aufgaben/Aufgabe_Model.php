<?php

namespace App\Models\Aufgaben;

use CodeIgniter\Model;

class Aufgabe_Model extends Model {
   
    protected $table          = 'aufgaben';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'liste',
        'element_id',
        'titel',
        'mitglied_id_geplant',
        'mitglied_id_erledigt',
        'zeitpunkt_erledigt',
        'bemerkung',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = TRUE;
}