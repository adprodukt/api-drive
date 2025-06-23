<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('roles')->insert([
            'role' => 'Преподаватель',
        ]);
        DB::table('roles')->insert([
            'role' => 'Администратор',
        ]);
        DB::table('users')->insert([
            'first_name' => 'Админимтратор',
            'last_name' => 'Админимтратор',
            'patronymic' => 'Админимтратор',
            'birth_date' => '2000-01-01',
            'email' => 'se24@oatk.org',
            'password' =>Hash::make('P@rtyOATK'),
            'role_id' => '2',
        ]);
        DB::table('users')->insert([
            'first_name' => 'Преподаватель',
            'last_name' => 'Преподаватель',
            'patronymic' => 'Преподаватель',
            'birth_date' => '2000-01-01',
            'email' => 'teacher@oatk.ru',
            'password' => Hash::make('QwertyP@rtyOATK'),
        ]);
    }
}
