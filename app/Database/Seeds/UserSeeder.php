<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        
        $mitglieder = [
            [ 'vorname'  => 'John', 'nachname' => 'Doe',
                'geburt' => '1988-07-15 00:00:00', 'postleitzahl' => 77815, 'wohnort' => 'Bühl',
                'geschlecht' => 'm', 'register' => 'tuba', 'funktion' => 'ohne', 'vorstandschaft' => 1, 'aktiv' => 1, ],
            [ 'vorname'  => 'Be', 'nachname' => 'rt',
                'geburt' => '1950-01-01 00:00:00', 'postleitzahl' => 99999, 'wohnort' => 'Entenhausen',
                'geschlecht' => 'm', 'register' => 'posaune', 'funktion' => 'ohne', 'vorstandschaft' => 0, 'aktiv' => 1, ],
            [ 'vorname'  => 'Te', 'nachname' => 'st',
                'geburt' => '1950-01-01 00:00:00', 'postleitzahl' => 12345, 'wohnort' => 'Testort',
                'geschlecht' => 'm', 'register' => 'klarinette', 'funktion' => 'ohne', 'vorstandschaft' => 0, 'aktiv' => 1, ],
            [ 'vorname'  => 'Te', 'nachname' => 'st2',
                'geburt' => '1950-01-01 00:00:00', 'postleitzahl' => 12345, 'wohnort' => 'Testort',
                'geschlecht' => 'm', 'register' => 'klarinette', 'funktion' => 'ohne', 'vorstandschaft' => 0, 'aktiv' => 1, ],
        ];
        $this->db->table('mitglieder')->insertBatch($mitglieder);
        
        $mitglieder_zugaenge = [
            [ 'user_id'  => 1, 'type' => 'email_password', 'secret' => 'christoph.kuepferle@web.de', 'secret2' => '$2y$10$AZB9pt4pC8ZQQIoiF2blVuBJcPAf0M8MfX5gqqurLlWOaKdE3hg4q', ],
            [ 'user_id'  => 2, 'type' => 'email_password', 'secret' => 'be.rt@test.de', 'secret2' => '$2y$10$AZB9pt4pC8ZQQIoiF2blVuBJcPAf0M8MfX5gqqurLlWOaKdE3hg4q', ],
            [ 'user_id'  => 3, 'type' => 'email_password', 'secret' => 'te.st@test.de', 'secret2' => '$2y$10$AZB9pt4pC8ZQQIoiF2blVuBJcPAf0M8MfX5gqqurLlWOaKdE3hg4q', ],
            [ 'user_id'  => 4, 'type' => 'email_password', 'secret' => 'te.st2@test.de', 'secret2' => '$2y$10$AZB9pt4pC8ZQQIoiF2blVuBJcPAf0M8MfX5gqqurLlWOaKdE3hg4q', ],
        ];
        $this->db->table('mitglieder_zugaenge')->insertBatch($mitglieder_zugaenge);
        
        $mitglieder_rollen = [
            [ 'user_id' => 1, 'group' => 'mitglied', ],
            [ 'user_id' => 2, 'group' => 'mitglied', ],
            [ 'user_id' => 3, 'group' => 'mitglied', ],
            [ 'user_id' => 4, 'group' => 'mitglied', ],
        ];
        $this->db->table('mitglieder_rollen')->insertBatch($mitglieder_rollen);
        
        $mitglieder_vergebene_rechte = [
            [ 'user_id' => 1, 'permission' => 'mitglieder.rechte', ],
            [ 'user_id' => 1, 'permission' => 'global.einstellungen', ],
            [ 'user_id' => 2, 'permission' => 'global.einstellungen', ],
        ];
        $this->db->table('mitglieder_vergebene_rechte')->insertBatch($mitglieder_vergebene_rechte);
    }
}
