<?php

namespace App\Models\Termine;

use CodeIgniter\Model;

class Termin_Model extends Model {
   
    protected $table          = 'termine';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'titel',
        'organisator',
        'start',
        'ort',
        'kategorie',
        'beschr_mitglieder',
        'setlist',
        'bemerkung',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = true;
}