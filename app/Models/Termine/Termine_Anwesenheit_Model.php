<?php

namespace App\Models\Termine;

use CodeIgniter\Model;

class Termine_Anwesenheit_Model extends Model {
   
    protected $table          = 'termine_anwesenheiten';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'termin_id',
        'mitglied_id',
        'bemerkung',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}