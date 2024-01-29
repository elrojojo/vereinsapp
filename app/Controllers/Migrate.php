<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Throwable;

class Migrate extends Controller
{
    public function migrate()
    {

        $migrate = \Config\Services::migrations();
        try {
            $migrate->latest();
        } catch (Throwable $e) {
            echo $e;
        }

        $seeder = \Config\Database::seeder();
        try {
            $seeder->call('UserSeeder');
        } catch (Throwable $e) {
            echo $e;

        }

    }
}