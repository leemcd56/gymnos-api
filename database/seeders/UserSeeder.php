<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemUser = User::firstOrCreate([
            'display_name' => 'Gymnos',
            'username'     => 'Gymnos',
            'email'        => 'gymnos.community@gmail.com',
        ]);

        $systemUser->addRole('cronjob');
    }
}
