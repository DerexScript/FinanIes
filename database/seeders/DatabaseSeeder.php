<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        \App\Models\Permission::factory(1)->create();
        \App\Models\Role::factory(1)->create();
        \App\Models\User::factory(1)->create();
    }
}
