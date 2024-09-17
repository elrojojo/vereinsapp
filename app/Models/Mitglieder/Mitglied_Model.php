<?php
// https://github.com/codeigniter4/shield/discussions/333

namespace App\Models\Mitglieder;

use CodeIgniter\Shield\Models\UserModel;

class Mitglied_Model extends UserModel {
   
    protected $allowedFields  = [
        // 'username',
        // 'status',
        // 'status_message',
        // 'active',
        // 'last_active',
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
        'vorname',
        'nachname',
        'geburt',
        'postleitzahl',
        'wohnort',
        'geschlecht',
        'register',
        'auto',
        'funktion',
        'vorstandschaft',
        'aktiv',
    ];
   
}