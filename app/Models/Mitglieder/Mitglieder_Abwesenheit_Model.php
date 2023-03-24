<?php

namespace App\Models\Mitglieder;

use CodeIgniter\Model;

class Mitglieder_Abwesenheit_Model extends Model {
   
    protected $table          = 'mitglieder_abwesenheiten';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'mitglied_id',
        'start',
        'ende',
        'bemerkung',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
}