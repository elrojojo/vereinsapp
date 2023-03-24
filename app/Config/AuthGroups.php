<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'mitglied';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys are
     * the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://github.com/codeigniter4/shield/blob/develop/docs/quickstart.md#change-available-groups for more info
     */
    public array $groups = [
        'mitglied' => [
            'title'       => 'Mitglied',
            'description' => 'Einfache Mitglieder-Rechte',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system. Each system is defined
     * where the key is the
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'termine.verwaltung' => 'Verwaltung der Termine',
        'termine.anwesenheiten' => 'Anwesenheitskontrolle zu Terminen',
        'mitglieder.verwaltung' => 'Verwaltung der Mitglieder',
        'notenbank.verwaltung' => 'Verwaltung der Notenbank',
        'mitglieder.rechte' => 'Vergabe von Rechten',
        'global.einstellungen' => 'Globale Einstellungen',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     */
    public array $matrix = [
        'mitglied' => [],
    ];
}
