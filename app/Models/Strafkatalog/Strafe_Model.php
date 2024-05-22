<?php

namespace App\Models\Strafkatalog;

use CodeIgniter\Model;

class Strafe_Model extends Model {
   
    protected $table          = 'strafkatalog';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'titel',
        'wert',
        'kategorie',
        'bemerkung',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = TRUE;
}