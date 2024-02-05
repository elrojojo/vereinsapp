<?php

namespace App\Models\Termine;

use CodeIgniter\Model;

class Titel_Model extends Model {
   
    protected $table          = 'notenbank';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'titel',
        'titel_nr',
        'kategorie',
    ];
    protected $useTimestamps = TRUE;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $useSoftDeletes = TRUE;
}