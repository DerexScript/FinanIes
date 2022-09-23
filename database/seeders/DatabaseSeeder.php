<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        DB::table('users')->insert([
            'name' => 'admin',
            'surname' => 'system',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'email_verified_at' => gmdate('Y-m-d H:i:s'),
            'is_admin' => 1,
            'password' => '$2y$10$0rb1CegyVWyNFjHmEr3tOetqVI8F2DvvTdynl83KnJqtZ67A529CO', // password123
            'remember_token' => Str::random(10),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'surname' => 'system',
            'email' => 'user@user.com',
            'username' => 'user',
            'email_verified_at' => gmdate('Y-m-d H:i:s'),
            'is_admin' => 0,
            'password' => '$2y$10$0rb1CegyVWyNFjHmEr3tOetqVI8F2DvvTdynl83KnJqtZ67A529CO', // password123
            'remember_token' => Str::random(10),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        \App\Models\Role::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Company::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Entry::factory(10)->create();
        \App\Models\EntryGroup::factory(10)->create();
    }
}
